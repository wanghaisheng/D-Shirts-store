<script setup>
import { ref } from "vue";
import UploadImage from "@/Components/UploadImage.vue";
import { useForm } from "@inertiajs/vue3";



const form = useForm({
    mainImage: mainImageHere,
});
</script>

<template>
    <div class="">
        <form class="p-2" @submit.prevent="form.post('/admin/t-shirts')">
            <div class="w-full flex">
                <UploadImage
                    v-model="mainImage"
                    width="w-44"
                    height="h-44"
                    label="Main Image"
                />
            </div>
            <button type="submit">Add T-Shirt</button>
        </form>
    </div>
</template>
