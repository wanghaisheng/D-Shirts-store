<script setup>
import Admin from "@/Layouts/Admin.vue";
import { Head, router, Link } from "@inertiajs/vue3";
import { debounce } from "lodash";
import { ref, watch } from "vue";

defineOptions({ layout: Admin });

const props = defineProps({
    customers: {
        type: Object,
        required: true,
    },
    searchTerm: String,
});

const search = ref(props.searchTerm);

watch(
    search,
    debounce((query) => {
        router.get(
            route("customers"),
            {
                search: query,
            },
            {
                preserveState: true,
                preserveScroll: true,
            }
        );
    }, 300)
);
</script>

<template>
    <!-- Table -->
    <div class="pb-12">
        <Head title="Customers" />
        <!-- Search -->
        <div class="flex items-center justify-end my-3">
            <input
                v-model="search"
                type="search"
                name="search"
                placeholder="Search"
                class="w-52 h-10 px-3 border-b-2 border-gray-200 focus:border-gray-300 rounded-lg text-sm outline-none focus:ring-0"
            />
        </div>

        <!-- Table -->
        <div class="flex flex-col bg-white scrollbar-thumb-custom scrollbar-track-custom-light">
            <div class="-m-1.5 overflow-x-auto ">
                <div class="p-1.5 min-w-full inline-block align-middle">
                    <div class="overflow-hidden ">
                        <table class="min-w-full divide-y divide-gray-200 ">
                            <thead>
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
                                        Name
                                    </th>
                                    <th
                                        scope="col"
                                        class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase"
                                    >
                                        Email
                                    </th>
                                    <th
                                        scope="col"
                                        class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase"
                                    >
                                        Address
                                    </th>
                                    <th
                                        scope="col"
                                        class="px-6 py-3 text-end text-xs font-medium text-gray-500 uppercase"
                                    >
                                        Number of Orders
                                    </th>
                                    <th
                                        scope="col"
                                        class="px-6 py-3 text-end text-xs font-medium text-gray-500 uppercase"
                                    >
                                        Total Revenue
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200">
                                <tr
                                    v-for="customer in customers.data"
                                    :key="customer.id"
                                    class="hover:bg-gray-50 cursor-pointer"
                                >
                                    <td
                                        class="px-6 py-4 whitespace-nowrap text-sm text-gray-800"
                                    >
                                        {{ customer.id }}
                                    </td>
                                    <td
                                        class="px-6 py-4 whitespace-nowrap text-sm text-gray-800"
                                    >
                                        {{ customer.name }}
                                    </td>
                                    <td
                                        class="px-6 py-4 whitespace-nowrap text-sm text-gray-800"
                                    >
                                        {{ customer.email }}
                                    </td>
                                    <td
                                        class="px-6 py-4 whitespace-nowrap text-sm text-gray-800"
                                    >
                                        {{ customer.country }},
                                        {{ customer.city }},
                                        {{ customer.address }}
                                    </td>
                                    <td
                                        class="px-6 py-4 whitespace-nowrap text-sm text-gray-800"
                                    >
                                        {{ customer.orders_count }}
                                    </td>
                                    <td
                                        class="px-6 py-4 whitespace-nowrap text-sm text-gray-800"
                                    >
                                        {{ customer.orders_sum_total_price }}
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- table footer -->
        <div class="my-4 flex justify-between items-center w-full">
            <!-- results -->
            <div>
                <p class="text-base">
                    Showing
                    <span class="text-green-600 font-bold text-lg">{{
                        customers.from
                    }}</span>
                    to
                    <span class="text-green-600 font-bold text-lg"
                        >{{ customers.to }}
                    </span>
                    of {{ customers.total }} customers
                </p>
            </div>
            <nav class="">
                <div class="flex items-center -space-x-px h-8 text-sm">
                    <template
                        v-for="(link, index) in customers.links"
                        :key="link.url"
                    >
                        <Link
                            preserve-scroll="true"
                            v-if="link.url"
                            :href="link.url"
                            v-html="link.label"
                            class="flex items-center justify-center px-3 h-8 leading-tight text-gray-500 bg-white border border-gray-300 hover:bg-gray-100 hover:text-gray-700"
                            :class="{
                                'bg-green-600 hover:bg-green-500 text-white hover:text-white':
                                    link.active,
                                'rounded-l-lg': index === 0,
                                'rounded-r-lg':
                                    index === customers.links.length - 1,
                            }"
                        />
                        <p
                            v-else
                            v-html="link.label"
                            class="flex items-center justify-center px-3 h-8 leading-tight text-gray-500 bg-slate-200 border border-gray-300"
                            :class="{
                                'rounded-l-lg': index === 0,
                                'rounded-r-lg':
                                    index === customers.links.length - 1,
                            }"
                        />
                    </template>
                </div>
            </nav>
        </div>
    </div>
</template>
