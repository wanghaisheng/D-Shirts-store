<script setup>
import { Head } from "@inertiajs/vue3";
import Customer from "@/Layouts/Customer.vue";
import ImageCarousel from "@/Components/ImageCarousel.vue";

defineOptions({ layout: Customer });

const props = defineProps({
    tshirt: {
        type: Object,
        required: true,
    },
});
</script>


<template>
    <div class=''>
        <Head title="Tshirt Page" />
        <div class="flex flex-col items-center justify-center gap-4 w-full max-w-7xl mx-auto px-4 py-16 md:flex-row">
           <div class="md:w-1/2 w-full order-2 flex flex-col gap-8">
                <div class=" space-y-2">
                    <p class="text-3xl font-bold text-gray-800 font-main">{{ tshirt.title }}</p>
                    <p class="font-main text-gray-800">{{ tshirt.description }}</p>
                    <p class="text-xl font-secondary font-bold text-gray-800">Price: ${{ tshirt.price }}</p>
                </div>
                <div class="flex gap-4">
                     
                    <select class="w-full">
                        <option value="" disabled selected>Select Size</option>
                        <option value="S">S</option>
                        <option value="M">M</option>
                        <option value="L">L</option>
                        <option value="XL">XL</option>
                    </select>
                    quantity:
                    <input type="number" name="quantity" class="w-full" placeholder="quantity">
                </div>
                <button class="btn w-full">Add to Cart</button>
           </div>
            
            <div class="md:w-1/2 w-full order-1 flex flex-col gap-24">
                <ImageCarousel :images="tshirt.images.map(image => image.url)" />
            </div>
        </div>
    </div>
</template>


<style scoped></style>