<script setup>
import { Link } from "@inertiajs/vue3";
import Footer from "@/Components/HomePage/Footer.vue";
</script>

<template>
    <div class="bg-[#f5f5f5]">
        <!-- Nav bar -->
        

        <!-- Page Content -->
        <div class="bg-slate-200 mx-auto min-h-screen">
            <slot />
        </div>

        <!-- Footer -->
        <Footer />
    </div>
</template>
