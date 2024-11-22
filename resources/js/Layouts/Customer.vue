<script setup>
import Footer from "@/Components/HomePage/Footer.vue";
import Cart from "@/Components/Cart.vue";
</script>

<template>
    <div class="bg-[#f5f5f5] relative">

        <Cart />

        <!-- Page Content -->
        <div class="bg-slate-200 mx-auto min-h-screen">
            <slot />
        </div>

        <!-- Footer -->
        <Footer />
    </div>
</template>
