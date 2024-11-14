<script setup>
import Admin from "@/Layouts/Admin.vue";
import { Head } from "@inertiajs/vue3";
import { onMounted, ref } from "vue";
import ApexCharts from "apexcharts";

defineOptions({ layout: Admin });

const props = defineProps({
    chartData: {
        type: Object,
        required: true,
    },
});

const data = ref(props.chartData);

const selectedFilter = ref('all');

onMounted(() => {
    const maxCumulativeIncome = Math.max(
        ...data.value.map((item) => item.cumulative_income)
    );

    // Round up to the nearest thousand for a cleaner axis
    const yAxisMax = Math.ceil(maxCumulativeIncome / 1000) * 1000;
    const options = {
        chart: {
            height: 500,
            type: "line",
            stacked: false,
            background: "#20293c",
            foreColor: "#fff",
            zoom: {
                enabled: false,
            },
            toolbar: {
                show: false,
            },
        },
        colors: ["#fff", "#f4a300", "#284f6c", "#10B981"],
        dataLabels: {
            enabled: false,
        },
        series: [
            {
                name: "Orders",
                type: "line",
                data: data.value.map((item) => ({
                    x: item.month,
                    y: item.monthly_order,
                })),
            },
            {
                name: "Tshirts",
                type: "line",
                data: data.value.map((item) => ({
                    x: item.month,
                    y: item.monthly_tshirts,
                })),
            },
            {
                name: "Monthly Income",
                type: "column",
                data: data.value.map((item) => ({
                    x: item.month,
                    y: item.monthly_income,
                })),
            },
            {
                name: "Cumulative Income",
                type: "area",
                data: data.value.map((item) => ({
                    x: item.month,
                    y: item.cumulative_income,
                })),
            },
        ],
        stroke: {
            width: [4, 4, 2, 2],
        },
        plotOptions: {
            bar: {
                columnWidth: "20%",
            },
        },
        xaxis: {
            type: "datetime",
        },
        yaxis: [
            {
                seriesName: "Orders", // Links 'Orders' to this axis
                title: {
                    text: "Orders & Tshirts",
                },
                min: 0,
                tickAmount: 6,
                labels: {
                    formatter: function (val) {
                        return val.toFixed(0);
                    },
                },
            },
            {
                seriesName: "Tshirts", // Links 'Tshirts' to this axis
                show: false,
                
            },
            {
                seriesName: "Monthly Income", // Links 'Monthly Income' to the second axis (right)
                opposite: true,
                title: {
                    text: "Monthly and Cumulative Income",
                },
                max: yAxisMax,
                min: 0,
                
            },
            {
                seriesName: "Cumulative Income", // Links 'Cumulative Income' to the second axis (right)
                opposite: true,
                show: false,
            },
        ],
        tooltip: {
            shared: true,
            intersect: false,
            y: {
                formatter: function (y, { seriesIndex }) {
                    if (typeof y !== "undefined") {
                        if (seriesIndex === 0 || seriesIndex === 1) {
                            return y.toFixed(0);
                        }
                        return y.toFixed(2);
                    }
                    return y;
                },
            },
        },
        legend: {
            horizontalAlign: "left",
            offsetX: 40,
        },
    };

    const chart = new ApexCharts(
        document.querySelector(`#incomeChart`),
        options
    );
    chart.render();
});
</script>

<template>
    <div>
        <Head title="Revenue" />
        <!--  Income Chart  -->
          <!-- Filters -->
        <div class="flex gap-2 mb-2 mt-9">
            <div>
                <label
                    class="cursor-pointer p-1 rounded-lg border-2 border-slate-500"
                    :class="
                        selectedFilter === 'all'
                            ? 'bg-slate-700  text-slate-200'
                            : 'bg-white text-slate-600 hover:bg-slate-100'
                    "
                    for="all"
                    >All time</label
                >
                <input
                    class="hidden"
                    type="radio"
                    name="ordersFilter"
                    v-model="selectedFilter"
                    value="all"
                    id="all"
                />
            </div>
            <div>
                <label
                    class="cursor-pointer p-1 rounded-lg border-2 border-slate-500"
                    :class="
                        selectedFilter === 'year'
                            ? 'bg-emerald-500 text-white'
                            : 'bg-white text-slate-600 hover:bg-slate-100'
                    "
                    for="pending"
                    >Last Year</label
                >
                <input
                    class="hidden"
                    type="radio"
                    name="ordersFilter"
                    v-model="selectedFilter"
                    value="pending"
                    id="pending"
                />
            </div>
            <div>
                <label
                    class="cursor-pointer p-1 rounded-lg border-2 border-slate-500"
                    :class="
                        selectedFilter === 'processing'
                            ? 'bg-amber-500 text-white'
                            : 'bg-white text-slate-600 hover:bg-slate-100'
                    "
                    for="processing"
                    >Last Month</label
                >
                <input
                    class="hidden"
                    type="radio"
                    name="ordersFilter"
                    v-model="selectedFilter"
                    value="processing"
                    id="processing"
                />
            </div>
            <div>
                <label
                    class="cursor-pointer p-1 rounded-lg border-2 border-slate-500"
                    :class="
                        selectedFilter === 'delivered'
                            ? 'bg-blue-500 text-white'
                            : 'bg-white text-slate-600 hover:bg-slate-100'
                    "
                    for="delivered"
                    >Last Week</label
                >
                <input
                    class="hidden"
                    type="radio"
                    name="ordersFilter"
                    v-model="selectedFilter"
                    value="delivered"
                    id="delivered"
                />
            </div>
        </div>
        <div class="h-[800px]" id="incomeChart"></div>
    </div>
</template>
