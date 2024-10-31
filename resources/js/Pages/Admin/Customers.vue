<script setup>
import Admin from "@/Layouts/Admin.vue";
import { Head } from "@inertiajs/vue3";

defineOptions({ layout: Admin });

defineProps({
    customers: {
        type: Object,
        required: true,
    },
});
</script>

<template>
    <Head title="Customers" />

    <!-- Table -->
    <div class="flex flex-col bg-white">
        <div class="-m-1.5 overflow-x-auto">
            <div class="p-1.5 min-w-full inline-block align-middle">
                <div class="overflow-hidden">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead>
                            <tr>
                                <th scope="col" class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase">
                                    #
                                </th>
                                <th scope="col" class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase">
                                    Name
                                </th>
                                <th scope="col" class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase">
                                    Email
                                </th>
                                <th scope="col" class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase">
                                    Address
                                </th>
                                <th scope="col" class="px-6 py-3 text-end text-xs font-medium text-gray-500 uppercase">
                                    Number of Orders
                                </th>
                                <th scope="col" class="px-6 py-3 text-end text-xs font-medium text-gray-500 uppercase">
                                    Total Revenue
                                </th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">

                            <tr v-for="customer in customers" :key="customer.id" class="hover:bg-gray-50 cursor-pointer" >                                
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
                                    {{ customer.country }}, {{ customer.city }}, {{ customer.address }}
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
</template>
