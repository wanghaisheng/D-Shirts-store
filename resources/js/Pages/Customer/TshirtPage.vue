<script setup>
import { Head } from "@inertiajs/vue3";
import { ref, watch } from "vue";
import Customer from "@/Layouts/Customer.vue";
import ImageCarousel from "@/Components/ImageCarousel.vue";
import Price from "@/Components/TshirtPage/Price.vue";
import Reviews from "@/Components/TshirtPage/Reviews.vue";
import InputNumber from "primevue/inputnumber";

defineOptions({ layout: Customer });

const props = defineProps({
    tshirt: {
        type: Object,
        required: true,
    },
});

const quantity = ref(1);
const selectedSize = ref();

const sizes = [
    {
        key: "xs",
        label: "XS",
    },
    {
        key: "s",
        label: "S",
    },
    {
        key: "m",
        label: "M",
    },
    {
        key: "l",
        label: "L",
    },
    {
        key: "xl",
        label: "XL",
    },
];

watch(selectedSize, () => {
    console.log(selectedSize.value);
});
</script>

<template>
    <div class="py-16">
        <Head title="Tshirt Page" />
        <div class="w-full max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">
            <div class="flex flex-col gap-24 md:flex-row py-2 px-4">
                <div
                    class="md:w-1/2 w-full order-2 flex flex-col gap-8 justify-between"
                >
                    <div class="space-y-2">
                        <div class="">
                            <p
                                class="text-3xl font-bold text-gray-800 font-main"
                            >
                                {{ tshirt.title }}
                            </p>
                        </div>
                        <div>
                            <Price :price="tshirt.price" />
                        </div>
                        <div>
                            <Reviews :num="tshirt.title" />
                        </div>
                        <div class="bg-slate-500 h-[1px] w-full"></div>
                        <div class="flex justify-between items-center gap-3">
                            <!-- Quantity -->
                            <div class="w-1/2">
                                <p class="text-sm text-gray-500">Quantity</p>
                                <InputNumber
                                    v-model="quantity"
                                    inputId="horizontal-buttons"
                                    :min="1"
                                    :max="10"
                                    showButtons
                                    buttonLayout="horizontal"
                                    :step="1"
                                >
                                    <div>
                                        <p>+</p>
                                    </div>
                                    <div>
                                        <p>-</p>
                                    </div>
                                </InputNumber>
                            </div>
                            <!-- Size -->
                            <div class="w-1/2 ">
                                <p class="text-sm text-gray-500 ">Size</p>
                                <div class="flex gap-2 mt-2">
                                    <div v-for="size in sizes" :key="size.key">
                                        <label
                                            class="cursor-pointer py-1 px-2 rounded-lg border-2 border-slate-500"
                                            :class="
                                                selectedSize === size.key
                                                    ? 'bg-slate-700  text-slate-200'
                                                    : 'bg-white text-slate-600 hover:bg-slate-100'
                                            "
                                            :for="size.key"
                                            >{{ size.label }}</label
                                        >
                                        <input
                                            class="hidden"
                                            type="radio"
                                            name="dataFilter"
                                            v-model="selectedSize"
                                            :value="size.key"
                                            :id="size.key"
                                        />
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <button class="btn w-full">Add to Cart</button>
                </div>

                <div class="md:w-1/2 w-full order-1 flex flex-col gap-24">
                    <ImageCarousel
                        :images="tshirt.images.map((image) => image.url)"
                    />
                </div>
            </div>
            <div></div>
            Tshirt description / sizing
        </div>
    </div>
</template>
