<script setup>
import Admin from "@/Layouts/Admin.vue";
import { Head, router, Link } from "@inertiajs/vue3";
import { debounce } from "lodash";
import { ref, watch, onMounted } from "vue";
import { useTextHelpers } from "@/plugins/textHelpers";
import Status from "@/Components/Status.vue";

defineOptions({ layout: Admin });

const props = defineProps({
    orders: {
        type: Object,
        required: true,
    },
    searchTerm: String,
});

// This is the immediate search input value
const search = ref(props.searchTerm);
// This is the debounced search value that will be used for highlighting
const debouncedSearch = ref(props.searchTerm);

watch(
    search,
    debounce((query) => {
        // Update the table
        router.get(
            route("orders"),
            {
                search: query,
            },
            {
                preserveState: true,
                preserveScroll: true,
            }
        );
        // Update the debounced search value
        debouncedSearch.value = query;
    }, 300)
);

onMounted(() => {
    console.log(props.orders);
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

const textHelpers = useTextHelpers();
</script>

<template>
    <!-- Table -->
    <div class="pb-12">
        <Head title="Orders" />
        <!-- Search -->
        <div class="flex items-center justify-end my-3">
            <input
                v-model="search"
                type="search"
                name="search"
                placeholder="Search"
                class="w-64 h-10 px-3 border-b-2 border-gray-200 focus:border-gray-300 rounded-lg text-sm outline-none focus:ring-0"
            />
        </div>

        <!-- Table -->
        <div class="max-w-7xl overflow-x-auto table-container">
            <table
                class="min-w-full divide-y divide-gray-200 bg-white shadow-md"
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
                            class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase"
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
                            Status
                        </th>
                        <th
                            scope="col"
                            class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase"
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
                            class="px-6 py-3 text-xs font-medium text-gray-500 uppercase text-start"
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
                            class="hover:bg-gray-50 cursor-pointer"
                            :class="{
                                'bg-slate-300 hover:bg-slate-300 smooth':
                                    expandedRows.has(order.id),
                            }"
                        >
                            <td
                                class="px-6 py-4 whitespace-nowrap text-sm text-gray-800"
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
                                class="px-6 py-4 whitespace-nowrap text-sm text-gray-800"
                            >
                                <p class="font-bold">
                                    {{ order.customer.name }}
                                </p>
                                <p class="text-sm">
                                    {{ order.customer.email }}
                                </p>
                            </td>
                            <td
                                class="px-6 py-4 whitespace-nowrap text-sm text-gray-800"
                            >
                                {{ order.tshirts.length }}
                            </td>
                            <td
                                class="px-6 py-4 whitespace-nowrap text-sm text-green-600 font-bold"
                            >
                                {{ order.total_price + " $" ?? 0 }}
                            </td>
                            <td
                                class="px-6 py-4 whitespace-nowrap text-sm text-gray-800"
                            >
                                <Status :type="order.status" />
                            </td>
                            <td
                                class="px-6 py-4 whitespace-nowrap text-sm text-gray-800"
                            >
                                <p class="font-bold underline">
                                    {{ order.tracking_number || "--" }}
                                </p>
                            </td>
                            <td
                                class="px-6 py-4 whitespace-nowrap text-sm text-gray-800"
                            >
                                {{ order.created_at }}
                            </td>
                            <td>
                                <p>...</p>
                            </td>
                        </tr>

                        <!-- Expanded T-shirts Details Row -->
                        <tr v-if="expandedRows.has(order.id)">
                            <td colspan="8" class="px-6 py-4 bg-slate-200">
                                <div
                                    class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4"
                                >
                                    <div
                                        v-for="tshirt in order.tshirts"
                                        :key="tshirt.id"
                                        class="border rounded p-3 bg-white shadow-sm"
                                    >
                                        <div
                                            class="flex items-center justify-between"
                                        >
                                            <p>{{ tshirt.title }}</p>
                                            <img
                                                class="w-24 h-24 object-cover"
                                                :src="
                                                    tshirt.images.find(
                                                        (img) => img.order === 1
                                                    ).url
                                                "
                                                alt=""
                                            />
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
