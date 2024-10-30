<script setup>
import { Link } from "@inertiajs/vue3";
import ApexCharts from "apexcharts";
import { onMounted, ref } from "vue";

const props = defineProps({
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
    chartData: {
        type: Array,
        default() {
            return [30, 40, 35, 50, 49, 60, 70, 91, 25];
        },
    },
});

onMounted(() => {
    const options = {
        chart: {
            Animations: {enabled: false},
            type: "area",
            height: "80%",
            width: "100%",
            sparkline: {
                enabled: true,
            },
            toolbar: {
                show: false,
            },
        },
        series: [
            {
                name: "last 9 months",
                data: props.chartData,
            },
        ],

        yaxis: {
            labels: {
                show: false,
            },
        },
        grid: {
            show: false,
        },
        stroke: {
            curve: "smooth",
            width: 2,
        },
        colors: ["#10B981"],
        tooltip: {
            enabled: false,
        },
    };

    const chart = new ApexCharts(
        document.querySelector(`#${props.title.toLowerCase()}`),
        options
    );
    chart.render();
});
</script>

<template>
    <Link :href="route(routeName)" preserve-scroll>
        <div
            class="py-4 bg-slate-800 rounded-lg h-32 smooth overflow-hidden"
            :class="[
                $page.component.startsWith(activeComponent)
                    ? 'bg-slate-800'
                    : 'bg-slate-700 hover:bg-slate-700',
            ]"
        >
            <div class="w-full flex justify-between px-4">
                <!-- Title/Icon -->
                <div class="w-1/2 flex gap-1">
                    <p
                        class="font-bold text-2xl transition-colors duration-200"
                        :class="[
                            $page.component.startsWith(activeComponent)
                                ? 'text-green-500'
                                : 'text-slate-400',
                        ]"
                    >
                        {{ title }}
                    </p>
                </div>

                <!-- Revenue -->
                <div class="w-1/2 text-end">
                    <p
                        class="font-bold text-3xl transition-colors duration-200"
                        :class="[
                            $page.component.startsWith(activeComponent)
                                ? 'text-slate-100'
                                : 'text-slate-400',
                        ]"
                    >
                        {{ count }} $
                    </p>
                </div>
            </div>

            <!-- Chart -->
            <div :id="props.title.toLowerCase()"></div>
        </div>
    </Link>
</template>
