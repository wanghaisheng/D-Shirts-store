<script setup>
import { Head } from "@inertiajs/vue3";
import Customer from "@/Layouts/Customer.vue";
defineOptions({ layout: Customer });

</script>


<template>
    <div class='max-w-7xl mx-auto py-16 px-4 sm:py-24 sm:px-6 lg:px-8 min-h-screen flex justify-center items-center'>
        <Head title="Thank You" />
        <h1 class="text-3xl font-main font-semibold text-slate-700">Thanks for purchasing! 🥰</h1>
    </div>
</template>