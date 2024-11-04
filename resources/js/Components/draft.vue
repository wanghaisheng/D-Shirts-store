<script setup></script>

<template>
    <tbody class="divide-y divide-gray-200">
        <template v-for="order in orders.data" :key="order.id">
            <tr class="cursor-pointer">
                <td
                    class="px-6 py-4 whitespace-nowrap text-sm text-gray-800 text-center align-middle"
                >
                    {{ order.tshirts.length }}
                </td>
                <td
                    class="px-6 py-4 whitespace-nowrap text-sm text-gray-800 align-middle"
                >
                    <Status :type="order.status" />
                </td>

                <td
                    class="px-6 py-4 whitespace-nowrap text-sm text-gray-800 align-middle"
                >
                    {{ order.created_at }}
                </td>
                <td
                    class="px-6 py-4 whitespace-nowrap text-sm text-gray-800 flex items-center justify-center h-full"
                >
                    <EditOrder
                        :order-id="order.id"
                        :status="order.status"
                        :tracking-number="order.tracking_number"
                    />
                </td>
            </tr>
        </template>
    </tbody>
</template>
