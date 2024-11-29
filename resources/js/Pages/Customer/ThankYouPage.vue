<script setup>
import { Head, Link } from "@inertiajs/vue3";
import Customer from "@/Layouts/Customer.vue";

// Import the Lottie player
import { onMounted } from "vue";

defineOptions({ layout: Customer });

onMounted(() => {
    // Dynamically load the Lottie player script
    const script = document.createElement("script");
    script.src =
        "https://unpkg.com/@lottiefiles/lottie-player@2.0.8/dist/lottie-player.js";
    script.async = true;
    document.head.appendChild(script);
});
</script>

<template>
    <div
        class="max-w-7xl mx-auto py-16 px-4 sm:py-24 sm:px-6 lg:px-8 min-h-screen flex flex-col justify-start items-center relative"
    >
        <Head title="Thank You" />

        <lottie-player
            src="https://lottie.host/b558db53-88a8-4f67-b4bc-d273dc097157/w7r2XaO97U.json"
            background="#FFFFFF00"
            speed="1"
            class="w-96 absolute left-0"
            loop
            autoplay
            direction="1"
            mode="normal"
        ></lottie-player>
        <lottie-player
            src="https://lottie.host/b558db53-88a8-4f67-b4bc-d273dc097157/w7r2XaO97U.json"
            background="#FFFFFF00"
            speed="1"
            class="w-96 absolute right-0"
            loop
            autoplay
            direction="1"
            mode="normal"
        ></lottie-player>
        <lottie-player
            src="https://lottie.host/b558db53-88a8-4f67-b4bc-d273dc097157/w7r2XaO97U.json"
            background="#FFFFFF00"
            speed="1"
            class="w-44 h-80 absolute top-0"
            loop
            autoplay
            direction="1"
            mode="normal"
        ></lottie-player>

        <h1 class="mt-24 text-3xl font-main font-semibold text-slate-700">
            Thanks for purchasing! 🥰
        </h1>
        <p class="mt-6 text-lg text-slate-600">
            Your order is being processed and will be shipped soon. 🚚
        </p>
        <p class="mt-1 text-lg text-slate-600">
            Check your email for updates and further details. Thanks for
            choosing us! 💖
        </p>
        <Link :href="route('home')" class="btn mt-6 w-44 text-center"
            >Back To Shop</Link
        >
    </div>
</template>
