<script setup>
import { ref, computed } from "vue";

const props = defineProps({
    images: {
        type: Array,
        required: true,
    },
});

const currentImageIndex = ref(0);
const direction = ref("right");

const navigateNext = () => {
    direction.value = "right";
    currentImageIndex.value =
        (currentImageIndex.value + 1) % props.images.length;
};

const navigatePrev = () => {
    direction.value = "left";
    currentImageIndex.value =
        (currentImageIndex.value - 1 + props.images.length) %
        props.images.length;
};

const selectImage = (index) => {
    direction.value = index > currentImageIndex.value ? "right" : "left";
    currentImageIndex.value = index;
};
</script>

<template>
    <div class="relative w-full max-w-lg mx-auto overflow-hidden">
        <!-- Main Image with Slide Transition -->
        <div class="relative w-full aspect-square overflow-hidden">
            <transition
                :name="direction === 'right' ? 'slide-right' : 'slide-left'"
                mode="out-in"
            >
                <img
                    :src="images[currentImageIndex]"
                    :key="currentImageIndex"
                    class="absolute w-full h-full object-cover"
                />
            </transition>
        </div>

        <!-- Navigation Arrows -->
        <button
            @click="navigatePrev"
            class="absolute left-0 top-1/2 -translate-y-1/2 p-2 bg-black/50 text-white"
        >
            ←
        </button>
        <button
            @click="navigateNext"
            class="absolute right-0 top-1/2 -translate-y-1/2 p-2 bg-black/50 text-white"
        >
            →
        </button>

        <!-- Thumbnail Navigation -->
        <div class="flex justify-center mt-4 space-x-2">
            <div
                v-for="(image, index) in images"
                :key="index"
                @click="selectImage(index)"
                class="w-16 h-16 cursor-pointer border-2 transition-all"
                :class="{
                    'border-blue-500': index === currentImageIndex,
                    'border-gray-300': index !== currentImageIndex,
                }"
            >
                <img :src="image" class="w-full h-full object-cover" />
            </div>
        </div>
    </div>
</template>

<style scoped>
/* Slide Transitions */
.slide-right-enter-active,
.slide-right-leave-active,
.slide-left-enter-active,
.slide-left-leave-active {
    transition: all 0.3s ease;
}

.slide-right-enter-from {
    opacity: 0;
    transform: translateX(100%);
}
.slide-right-leave-to {
    opacity: 0;
    transform: translateX(-100%);
}

.slide-left-enter-from {
    opacity: 0;
    transform: translateX(-100%);
}
.slide-left-leave-to {
    opacity: 0;
    transform: translateX(100%);
}

/* Optional additional styling */
button {
    transition: background-color 0.1s ease;
}
button:hover {
    background-color: rgba(0, 0, 0, 0.7);
}
</style>
