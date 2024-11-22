<script setup>
import { Head, Link } from "@inertiajs/vue3";
import Customer from "@/Layouts/Customer.vue";

defineOptions({ layout: Customer });
</script>

<template>
    <div class="">
        <Head title="Cart" />
        <div class="max-w-7xl mx-auto pt-8 px-8 space-y-6">
            <h1 class="font-secondary font-semibold text-xl">Shopping cart</h1>
            <div class="w-full h-[1px] bg-slate-500"></div>

            <!-- Cart Items -->
            <div class="flex gap-4">
                <div class="w-2/3 bg-teal-70r0 h-[80vh]">
                    <div class="w-full h-44 bg-slate-400 rounded-xl shadow-xl p-4 flex justify-start items-start gap-2">
                        <div class="w-1/6 h-full bg-slate-500 border border-white rounded-md">
                        </div>
                        <div class="w-2/6">
                            <p class="font-main text-lg">T-shirt title here...</p>
                            <p>Price: ₹100</p>
                        </div>
                        <div class="w-2/6">
                            <input type="number" class="w-full">
                            <select class="w-full" name="" id="">
                                <option value="">Size</option>
                                <option value="">XS</option>
                                <option value="">S</option>
                                <option value="">M</option>
                                <option value="">L</option> 
                                <option value="">XL</option>
                            </select>
                        </div>
                        <div class="flex flex-col gap-2 w-1/6">
                            <p>Total</p>
                            <p class="font-bold">₹200</p>
                        </div>

                    </div>

                </div>
                <div class="w-1/3 bg-slate-50 border border-slate-300 rounded-xl shadow-xl  h-[80vh] ">
                </div>
            </div>

            <!-- Empty Cart -->
            <!-- <div class=" h-[80vh] flex flex-col justify-center items-center">
                <img
                    src="../../../../public/assets/empty-cart.png"
                    alt=""
                    class="w-64"
                />
                <div class="place-items-center">
                    <p class="font-main mb-4">You don’t have any items in your cart.</p>
                    <Link :href="route('home')" class="btn">Continue Shopping</Link>
                </div>
            </div> -->
        </div>
    </div>
</template>

<style scoped></style>
