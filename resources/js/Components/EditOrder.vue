<script setup>
import { ref } from "vue";
import Dialog from "primevue/dialog";
import Select from "primevue/select";
import InputText from "primevue/inputtext";
import Button from "primevue/button";
import Pen from "@/Icons/Pen.vue";
import { useForm } from '@inertiajs/vue3';


const props = defineProps({
    orderId: {
        type: Number,
        required: true,
    },
    status: {
        type: String,
        required: true,
    },
    trackingNumber: {
        type: [String, null],
        required: true,
    },
});

const showModal = ref(false);

const statuses = ref([
    { name: "⏸️ Pending", value: "pending" },
    { name: "♻️ Processing", value: "processing" },
    { name: "🚚 Delivered", value: "delivered" },
    { name: "⛔ Cancelled", value: "cancelled" },
]);

const selectedStatus = ref(
    statuses.value.find((s) => s.value === props.status) || null
);

const trackingNumber = ref(props.trackingNumber);

const updateOrder = () => {
    const form = useForm({
        status: selectedStatus.value.value,
        tracking_number: trackingNumber.value,
    });

    form.put(route("orders.update", props.orderId), {
        _method: 'put',
        onSuccess: () => {
            showModal.value = false;
            emit("order-updated", form.data);
        },
        onError: (errors) => {
            console.error("Error updating order:", errors);
        },
    });
};
</script>
<template>
    <div class="" @click.stop="showModal = !showModal">
        <Pen
            class="text-slate-500 w-16 h-16 hover:text-slate-600 hover:scale-125 smooth p-6"
        />
    </div>

    <Dialog
        v-model:visible="showModal"
        modal
        header="Update Order"
        :style="{ width: '25rem' }"
    >
        <div class="flex flex-col gap-4">
            <div class="flex flex-col justify-center">
                <p>Status</p>
                <Select
                    v-model="selectedStatus"
                    :options="statuses"
                    optionLabel="name"
                    placeholder="Select a State"
                    class="w-full"
                    checkmark
                />
            </div>
            <div class="flex flex-col justify-center">
                <p>Tracking</p>
                <InputText type="text" v-model="trackingNumber" />
            </div>

            <Button label="Save" @click="updateOrder" />
        </div>
    </Dialog>
</template>
