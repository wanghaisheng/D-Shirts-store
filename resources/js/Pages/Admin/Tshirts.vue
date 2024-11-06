<script setup>
import Admin from "@/Layouts/Admin.vue";
import { Head } from "@inertiajs/vue3";

defineOptions({ layout: Admin });

const props = defineProps({
    tshirts: {
        type: Array,
    },
});
</script>

<template>
    <div class="">
        <Head title="T-Shirts" />
        <div class="w-full flex justify-end">
            <button class="btn">Add T-Shirt</button>
        </div>
        <div class="w-full overflow-x-auto grid grid-cols-4 gap-4 pb-8 pt-2">
            <div
                v-for="tshirt in tshirts"
                :key="tshirt.id"
                class="flex flex-col gap-2 bg-slate-200 w-full h-full p-3 rounded-md shadow-md"
            >
                <img
                    :src="tshirt.mainImage.url"
                    class="w-full h-full object-cover rounded-md"
                />
                <p class="text-lg font-bold">{{ tshirt.title }}</p>
                <p class="text-lg font-bold">{{}}</p>
                <p class="text-sm font-bold text-green-600">
                    ${{ tshirt.price }}
                </p>
                <div class="grid grid-cols-4 gap-2">
                    <template v-for="i in 4" :key="i">
                        <div
                            class="flex flex-col gap-2 bg-white w-full h-full rounded-md shadow-md"
                        >
                            <template v-if="tshirt.otherImages[i]">
                                <img
                                    :src="tshirt.otherImages[i].url"
                                    class="w-full h-full object-cover rounded-md"
                                />
                            </template>
                            <div
                                v-else
                                class="w-12 h-12 rounded-md"
                            ></div>
                        </div>
                    </template>
                </div>
                <button class="btn">Edit</button>
            </div>
        </div>
    </div>
</template>
