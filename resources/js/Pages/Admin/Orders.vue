<script setup>
import Admin from "@/Layouts/Admin.vue";
import { Head, Link } from "@inertiajs/vue3";
import { ref } from "vue";
import { useTextHelpers } from "@/plugins/textHelpers";
import Status from "@/Components/Status.vue";
import CopyText from "@/Components/CopyText.vue";
import EditOrder from "@/Components/EditOrder.vue";

defineOptions({ layout: Admin });

const props = defineProps({
    orders: {
        type: Object,
        required: true,
    },
});


// Keep track of expanded rows
const expandedRows = ref(new Set());

// Toggle row expansion
const toggleRow = (orderId) => {
    if (expandedRows.value.has(orderId)) {
        expandedRows.value.delete(orderId);
    } else {
        expandedRows.value.add(orderId);
    }
};

const textHelper = useTextHelpers();
</script>

<template>
    <!-- Table -->
    <div class="pb-12">
        <Head title="Orders" />

        <!-- Table -->
        <div class="max-w-7xl overflow-x-auto table-container">
            <table
                class="min-w-full divide-y divide-gray-200 bg-white shadow-md mt-16 table-auto"
            >
                <thead class="">
                    <tr>
                        <th
                            scope="col"
                            class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase"
                        >
                            #
                        </th>
                        <th
                            scope="col"
                            class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase"
                        >
                            Customer
                        </th>
                        <th
                            scope="col"
                            class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase text-nowrap"
                        >
                            N° of T-shirts
                        </th>
                        <th
                            scope="col"
                            class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase"
                        >
                            Amount
                        </th>
                        <th
                            scope="col"
                            class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase"
                        >
                            <p class="ms-2">Status</p>
                        </th>
                        <th
                            scope="col"
                            class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase text-nowrap"
                        >
                            Tracking Number
                        </th>
                        <th
                            scope="col"
                            class="px-6 py-3 text-xs font-medium text-gray-500 uppercase text-start"
                        >
                            Date
                        </th>
                        <th
                            scope="col"
                            class="w-24 py-3 text-xs font-medium text-gray-500 uppercase text-center"
                        >
                            Actions
                        </th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    <template v-for="order in orders.data" :key="order.id">
                        <!-- Main Order Row -->
                        <tr
                            @click="toggleRow(order.id)"
                            class="cursor-pointer"
                            :class="{
                                ' bg-gray-100 hover:bg-gray-100':
                                    expandedRows.has(order.id),
                                'hover:bg-gray-50 cursor-pointer ':
                                    !expandedRows.has(order.id),
                            }"
                        >
                            <td
                                class="px-6 py-4 whitespace-nowrap text-sm text-gray-800 align-middle"
                            >
                                <div class="flex items-center">
                                    <span class="mr-2">{{ order.id }}</span>
                                    <!-- Expand/Collapse Icon -->
                                    <svg
                                        :class="{
                                            'transform rotate-180':
                                                expandedRows.has(order.id),
                                        }"
                                        class="w-4 h-4 transition-all duration-300 ease-in-out"
                                        fill="none"
                                        stroke="currentColor"
                                        viewBox="0 0 24 24"
                                    >
                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            stroke-width="2"
                                            d="M19 9l-7 7-7-7"
                                        />
                                    </svg>
                                </div>
                            </td>
                            <td
                                class="px-6 py-4 whitespace-nowrap text-sm text-gray-800 align-middle"
                            >
                                <p class="font-bold">
                                    {{
                                        textHelper.limitText(
                                            order.customer.name,
                                            20
                                        )
                                    }}
                                </p>
                                <p class="text-sm">
                                    {{
                                        textHelper.limitText(
                                            order.customer.email,
                                            35
                                        )
                                    }}
                                </p>
                            </td>
                            <td
                                class="px-6 py-4 whitespace-nowrap text-sm text-gray-800 text-center align-middle"
                            >
                                {{ order.tshirts.length }}
                            </td>
                            <td
                                class="px-6 py-4 whitespace-nowrap text-sm text-green-600 font-bold text-center align-middle"
                            >
                                {{ order.total_price + " $" ?? 0 }}
                            </td>
                            <td
                                class="px-6 py-4 whitespace-nowrap text-sm text-gray-800 align-middle"
                            >
                                <Status :type="order.status" />
                            </td>
                            <td
                                class="px-6 py-4 whitespace-nowrap text-sm text-gray-800 flex items-center justify-center h-full"
                            >
                                <CopyText
                                    v-if="order.tracking_number"
                                    :text="order.tracking_number"
                                    message="Text copied!"
                                    class="bg-slate-200 rounded-md text-slate-500 w-fit px-1"
                                />
                                <p
                                    v-else
                                    class="text-gray-500 text-sm text-center"
                                >
                                    N/A
                                </p>
                            </td>
                            <td
                                class="px-6 py-4 whitespace-nowrap text-sm text-gray-800 align-middle"
                            >
                                {{ order.created_at }}
                            </td>
                            <td
                                class="px-6 py-4 whitespace-nowrap text-sm text-gray-800 flex items-center justify-center h-full"
                            >
                                <EditOrder :order-id="order.id" :status="order.status" :tracking-number="order.tracking_number"/>
                            </td>
                        </tr>

                        <!-- Expanded T-shirts Details Row -->
                        <tr v-if="expandedRows.has(order.id)">
                            <td colspan="8" class="bg-slate-200 py-2 px-3">
                                <div class="grid grid-cols-4 gap-3">
                                    <div
                                        v-for="tshirt in order.tshirts"
                                        :key="tshirt.id"
                                        class="border rounded p-3 bg-white shadow-sm hover:shadow-md"
                                    >
                                        <div
                                            class="flex flex-col items-center justify-center"
                                        >
                                            <img
                                                class="w-1/2 object-cover"
                                                :src="
                                                    tshirt.images.find(
                                                        (img) => img.order === 1
                                                    ).url
                                                "
                                                alt=""
                                            />
                                            <div
                                                class="w-full text-center flex flex-col justify-center items-center"
                                            >
                                                <p class="font-bold">
                                                    {{
                                                        textHelper.limitText(
                                                            tshirt.title,
                                                            10
                                                        )
                                                    }}
                                                </p>
                                                <p
                                                    class="text-green-100 font-semibold bg-green-700 p-1 rounded-sm w-fit"
                                                >
                                                    {{ tshirt.price }}$
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    </template>
                </tbody>
            </table>
        </div>

        <!-- table footer -->
        <div class="my-4 flex justify-between items-center w-full">
            <!-- results -->
            <div>
                <p class="text-base">
                    Showing
                    <span class="text-green-600 font-bold text-lg">{{
                        orders.from
                    }}</span>
                    to
                    <span class="text-green-600 font-bold text-lg"
                        >{{ orders.to }}
                    </span>
                    of {{ orders.total }} orders
                </p>
            </div>
            <nav class="">
                <div class="flex items-center -space-x-px h-8 text-sm">
                    <template
                        v-for="(link, index) in orders.links"
                        :key="link.url"
                    >
                        <Link
                            :preserve-scroll="true"
                            v-if="link.url"
                            :href="link.url"
                            v-html="link.label"
                            class="flex items-center justify-center px-3 h-8 leading-tight border border-gray-300 transition-colors"
                            :class="{
                                'text-gray-500 bg-white hover:bg-gray-100 hover:text-gray-700':
                                    !link.active,
                                'bg-green-500 text-white hover:bg-green-600':
                                    link.active,
                                'rounded-l-lg': index === 0,
                                'rounded-r-lg':
                                    index === orders.links.length - 1,
                            }"
                        />
                        <p
                            v-else
                            v-html="link.label"
                            class="flex items-center justify-center px-3 h-8 leading-tight text-gray-500 bg-slate-200 border border-gray-300"
                            :class="{
                                'rounded-l-lg': index === 0,
                                'rounded-r-lg':
                                    index === orders.links.length - 1,
                            }"
                        />
                    </template>
                </div>
            </nav>
        </div>
    </div>
</template>

<style scoped>
/* Scrollbar */
.table-container::-webkit-scrollbar {
    width: 10px;
    height: 10px;
}

.table-container::-webkit-scrollbar-track {
    background-color: #ebebeb;
    -webkit-border-radius: 10px;
    border-radius: 10px;
}

.table-container::-webkit-scrollbar-thumb {
    -webkit-border-radius: 10px;
    border-radius: 10px;
    background: #bdc4d5;
}

.transform {
    transition: transform 0.2s ease-in-out;
}
</style>
