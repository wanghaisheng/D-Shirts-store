<script setup>
import { ref, onMounted, onUnmounted } from "vue";
const props = defineProps({
    status: { type: String, default: "pending" },
    trackingNumber: { type: [String, null] },
    orderId: { type: Number },
});
const showOptions = ref(false);
const buttonClick = async () => {
    console.log("clicked");
    console.log(props.status, props.trackingNumber, props.orderId);
    showOptions.value = !showOptions.value;
}; // Close options when clicking outside
const handleClickOutside = (event) => {
    if (showOptions.value) {
        showOptions.value = false;
    }
};
onMounted(() => {
    document.addEventListener("click", handleClickOutside);
});
onUnmounted(() => {
    document.removeEventListener("click", handleClickOutside);
});
</script>
<template>
    <div class="relative">
        <div
            @click.stop="buttonClick"
            class="bg-slate-400/50 hover:bg-slate-400 p-2 w-8 h-8 rounded-full flex items-center justify-center cursor-pointer"
        >
            <span class="text-white text-2xl leading-none mb-3">...</span>
        </div>
        <div
            v-if="showOptions"
            class="absolute right-0 top-full mt-1 bg-slate-200 rounded-md shadow-lg py-2 min-w-[100px] z-10 w-44"
        >
            <div @click.stop="">
                <p class="text-sm text-slate-500 px-3">change status</p>
                <div class="w-full h-[1.5px] bg-slate-300 rounded-full"></div>
                <ul class="px-2 py-2 flex flex-col gap-2">
                    <li class="bg-gray-50 hover:bg-white p-1 rounded-md">
                        pending
                    </li>
                    <li class="bg-gray-50 hover:bg-white p-1 rounded-md">
                        in progress
                    </li>
                    <li class="bg-gray-50 hover:bg-white p-1 rounded-md">
                        delivered
                    </li>
                    <li class="bg-gray-50 hover:bg-white p-1 rounded-md">
                        cancelled
                    </li>
                </ul>
                <p class="text-sm text-slate-500 px-3">Tracking number</p>
                <div class="w-full h-[1.5px] bg-slate-300 rounded-full"></div>
                <div class="flex justify-center items-center gap-2 p-2">
                    <button
                        class="bg-green-500 md:bg-green-600 text-white w-full mx-1 rounded-md text-base"
                    >
                        Add
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>
