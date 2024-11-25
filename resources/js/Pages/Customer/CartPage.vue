<script setup>
import { Head, Link, router } from "@inertiajs/vue3";
import Customer from "@/Layouts/Customer.vue";
import { computed, onMounted } from "vue";
import { usePage } from "@inertiajs/vue3";
import Remove from "@/Icons/Remove.vue";
import { useTextHelpers } from "@/plugins/textHelpers";
import Tshirt from "@/Icons/Tshirt.vue";
import { useToast } from "primevue/usetoast";
import Toast from "primevue/toast";
import { loadStripe } from "@stripe/stripe-js";

defineOptions({ layout: Customer });

const props = defineProps({
    clientSecret: {
        type: Object,
    },
});

const page = usePage();

const toast = useToast();

const cart = computed(() => page.props.cart);

const cartTotal = computed(() =>
    page.props.cart.reduce(
        (acc, item) => acc + item.tshirt_price * item.quantity,
        0
    )
);

const textHelper = useTextHelpers();

function removeItem(id) {
    router.delete(route("cart.remove", { id: id }), {
        onSuccess: () => {
            toast.add({
                severity: "info",
                summary: "Item removed",
                detail: "Item removed from cart",
                life: 3000,
            });
        },
        onError: () => {
            toast.add({
                severity: "error",
                summary: "Error",
                detail: "Item could not be removed from cart",
                life: 3000,
            });
        },
    });
}

function increaseQuantity(id) {
    router.post(route("cart.increaseQuantity", { id: id }));
}

function decreaseQuantity(id) {
    router.post(route("cart.decreaseQuantity", { id: id }));
}

const stripe = loadStripe("pk_test_51QP7uUBHCvL4QLRBIzapKyIwaWtCnMOlutux3hjkxUYJhp2KpfPSOYqdR2K6cQMReEB6lzqOwq0jkpQ3cOEGRP7M00IUXChOal");

onMounted(() => {
    stripe.then(async (stripe) => {
        const checkout = await stripe?.initEmbeddedCheckout({
            clientSecret: props.clientSecret,
        });

        checkout?.mount("#checkout-container");
    });
});
</script>

<template>
    <div class="">
        <Head title="Cart" />
        <Toast position="top-center" />
        <div class="max-w-7xl mx-auto pt-10 px-8 space-y-6">
            <div class="flex justify-between items-center w-2/3 pe-2">
                <h1 class="font-secondary font-semibold text-xl">
                    Shopping cart
                </h1>
                <Link
                    v-if="cart.length > 0"
                    class="bg-slate-700 text-slate-200 px-2 py-1p rounded-md flex justify-center items-center gap-2"
                    :href="route('home')"
                >
                    <Tshirt class="w-[1.3rem]" />
                    <p>Back to shop</p>
                </Link>
            </div>
            <div class="w-full h-[1px] bg-slate-500"></div>

            <!-- Cart Items -->
            <div v-if="cart.length > 0" class="flex gap-4">
                <div
                    class="w-2/3 flex flex-col divide-y-2 divide-gray-500 h-[75vh] overflow-y-auto"
                >
                    <div
                        v-for="item in cart"
                        :key="item.tshirt_id"
                        class="relative flex items-center h-40 gap-3"
                    >
                        <div class="w-2/12">
                            <img
                                :src="item.tshirt_image"
                                alt=""
                                class="w-full object-cover"
                            />
                        </div>
                        <div class="w-4/12 space-y-3">
                            <p class="font-main font-semibold">
                                {{
                                    textHelper.limitText(item.tshirt_title, 25)
                                }}
                            </p>
                            <p>
                                Size:<span
                                    class="ms-2 font-semibold bg-gray-100 py-1 px-2 rounded-md shadow-md"
                                    >{{ item.size }}</span
                                >
                            </p>
                            <p>
                                Price:<span
                                    class="ms-2 font-semibold bg-gray-100 py-1 px-2 rounded-md shadow-md"
                                >
                                    ${{ item.tshirt_price }}</span
                                >
                            </p>
                        </div>
                        <div class="w-3/12 text-center space-y-1">
                            <p class="text-sm text-gray-500">Quantity</p>
                            <div class="flex justify-center items-center gap-2">
                                <button
                                    @click="decreaseQuantity(item.item_id)"
                                    :disabled="item.quantity == 1"
                                    class="bg-slate-400 hover:bg-slate-500 text-white w-8 h-8 rounded-full disabled:cursor-not-allowed disabled:bg-slate-300"
                                >
                                    -
                                </button>
                                <p
                                    class="border border-slate-400 py-2 px-4 rounded-md bg-white"
                                >
                                    {{ item.quantity }}
                                </p>
                                <button
                                    @click="increaseQuantity(item.item_id)"
                                    :disabled="item.quantity == 10"
                                    class="bg-slate-400 hover:bg-slate-500 text-white w-8 h-8 rounded-full disabled:cursor-not-allowed disabled:bg-slate-300"
                                >
                                    +
                                </button>
                            </div>
                        </div>
                        <div
                            class="w-3/12 flex flex-col justify-center items-center gap-1"
                        >
                            <p>Subtotal:</p>
                            <p class="text-2xl font-main text-teal-600">
                                ${{ item.tshirt_price * item.quantity }}
                            </p>
                        </div>
                        <div
                            @click="removeItem(item.item_id)"
                            class="absolute right-3 top-3"
                        >
                            <Remove
                                class="w-5 h-5 text-slate-700 hover:text-red-800 cursor-pointer"
                            />
                        </div>
                    </div>
                </div>
                <div
                    class="w-1/3 bg-slate-50 border border-slate-300 rounded-xl shadow-xl min-h-[75vh] my-4"
                >
                <div id="checkout-container">

                </div>
                    <p>Total Price: {{ cartTotal }}</p>
                </div>
            </div>

            <div
                v-else
                class="h-[80vh] flex flex-col justify-center items-center"
            >
                <img
                    src="../../../../public/assets/empty-cart.png"
                    alt=""
                    class="w-64"
                />
                <div class="place-items-center">
                    <p class="font-main mb-4">
                        You don’t have any items in your cart.
                    </p>
                    <Link :href="route('home')" class="btn"
                        >Continue Shopping</Link
                    >
                </div>
            </div>
        </div>
    </div>
</template>

<style scoped></style>
