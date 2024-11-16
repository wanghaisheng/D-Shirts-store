<script setup>
import { Link } from "@inertiajs/vue3";
</script>

<template>
    <div class="bg-slate-100">
        <!-- Nav bar -->
        

        <!-- Page Content -->
        <div class="max-w-7xl mx-auto min-h-screen p-4">
            <slot />
        </div>

        <!-- Footer -->
        <div class="h-24 bg-slate-700 text-white ">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between items-center h-full p-4">
                    <div class="flex items-center gap-4">
                        <Link
                            
                            class="text-slate-200 hover:text-slate-400 transition-colors duration-200"
                            >Home</Link
                        >
                        <Link
                            
                            class="text-slate-200 hover:text-slate-400 transition-colors duration-200"
                            >About</Link
                        >
                        <Link
                            
                            class="text-slate-200 hover:text-slate-400 transition-colors duration-200"
                            >Products</Link
                        >
                        <Link
                            
                            class="text-slate-200 hover:text-slate-400 transition-colors duration-200"
                            >Contact</Link
                        >
                    </div>
                    <p class="text-sm text-slate-100">
                        Copyright © 2023 d-shirts. All rights reserved.
                    </p>
                </div>  

            </div>

        </div>
    </div>
</template>
