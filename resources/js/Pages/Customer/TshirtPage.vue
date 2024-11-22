<script setup>
import { Head } from "@inertiajs/vue3";
import { ref, watch } from "vue";
import Customer from "@/Layouts/Customer.vue";
import ImageCarousel from "@/Components/ImageCarousel.vue";
import Price from "@/Components/TshirtPage/Price.vue";
import Reviews from "@/Components/TshirtPage/Reviews.vue";
import InputNumber from "primevue/inputnumber";
import Description from "@/Components/TshirtPage/Description.vue";
import Quality from "@/Icons/Quality.vue";
import Card from "@/Icons/Card.vue";
import World from "@/Icons/World.vue";

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
</script>

<template>
    <div class="py-16">
        <Head title="Tshirt Page" />
        <div class="w-full max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-12">
            <div class="flex flex-col md:gap-16 gap-4 md:flex-row py-2 px-4">
                <div
                    class="md:w-1/2 w-full order-2 flex flex-col gap-8 justify-between"
                >
                    <div class="">
                        <div class="space-y-2 mb-6">
                            <p
                                class="md:text-3xl text-2xl font-bold text-gray-800 font-main"
                            >
                                {{ tshirt.title }}
                            </p>
                            <Price :price="tshirt.price" />
                            <Reviews :num="tshirt.title" />
                            <div class="bg-slate-500 h-[1px] w-full"></div>
                        </div>
                        <div class="flex flex-col gap-6">
                            <!-- Size -->
                            <div class="space-y-1">
                                <p
                                    class="text-lg text-slate-800 font-main ms-1"
                                >
                                    Size
                                </p>
                                <div class="flex gap-2">
                                    <div v-for="size in sizes" :key="size.key">
                                        <label
                                            class="cursor-pointer py-2 px-4 rounded-lg border-2 border-slate-500"
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
                            <!-- Quantity -->
                            <div class="">
                                <p
                                    class="text-lg text-slate-800 font-main ms-1"
                                >
                                    Quantity
                                </p>
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
                            <!-- Features -->
                            <div class="space-y-1 mt-4">
                                <div
                                    class="flex justify-start items-center gap-2 text-slate-500"
                                >
                                    <Quality class="w-4 h-4" />
                                    <p>Premium quality material</p>
                                </div>
                                <div
                                    class="flex justify-start items-center gap-2 text-slate-500"
                                >
                                    <Card class="w-4 h-4" />
                                    <p>100% Secured Payment</p>
                                </div>
                                <div
                                    class="flex justify-start items-center gap-2 text-slate-500"
                                >
                                    <World class="w-4 h-4" />
                                    <p>Free shipping worldwide</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <button class="btn w-full !p-3">Add to Cart</button>
                </div>

                <div class="md:w-1/2 w-full order-1 flex flex-col gap-24">
                    <ImageCarousel
                        :images="tshirt.images.map((image) => image.url)"
                    />
                </div>
            </div>
            <div>
                <Description
                    :title="tshirt.title"
                    :description="tshirt.description"
                />
            </div>
        </div>
    </div>
</template>
