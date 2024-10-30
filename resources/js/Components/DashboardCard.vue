<script setup>
import { Link } from "@inertiajs/vue3";

defineProps({
    routeName: {
        type: String,
        required: true,
    },
    activeComponent: {
        type: String,
        required: true,
    },
    icon: {
        type: Object,
        required: true,
    },
    title: {
        type: String,
        required: true,
    },
    count: {
        type: [Number, String],
        required: true,
    },
});
</script>

<template>
    <Link :href="route(routeName)" preserve-scroll>
        <div
            class="flex justify-between bg-white p-4 shadow-lg rounded-lg h-32 hover:shadow-md hover:scale-[0.99] smooth"
            :class="{
                'border-green-500 border-2 bg-slate-100 hover:border-green-500 shadow-none scale-[0.99]':
                    $page.component.startsWith(activeComponent),
            }"
        >
            <div
                class="w-1/2 flex flex-col justify-end items-start h-full gap-y-3"
            >
                <component
                    :is="icon"
                    class="text-gray-500"
                    :class="{
                        'text-green-500':
                            $page.component.startsWith(activeComponent),
                    }"
                />
                <p
                    class="text-gray-500 font-bold text-2xl"
                    :class="{
                        'text-green-500':
                            $page.component.startsWith(activeComponent),
                    }"
                >
                    {{ title }}
                </p>
            </div>
            <div
                class="w-1/2 flex flex-col justify-center items-end pe-8 h-full gap-y-3"
            >
                <p
                    class="text-gray-500 font-bold text-4xl"
                    :class="{
                        'text-green-700':
                            $page.component.startsWith(activeComponent),
                    }"
                >
                    {{ count }}
                </p>
            </div>
        </div>
    </Link>
</template>

<style scoped></style>
