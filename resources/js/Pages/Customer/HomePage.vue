<template>
    <div
        class="relative min-h-screen overflow-x-hidden bg-gradient-to-b from-emerald-50 to-white"
    >
        <!-- Background Effects -->
        <div class="fixed inset-0 w-full h-screen opacity-30">
            <div
                class="absolute top-20 left-20 w-72 h-72 bg-emerald-200 rounded-full mix-blend-multiply filter blur-xl animate-blob"
            ></div>
            <div
                class="absolute top-40 right-20 w-72 h-72 bg-teal-200 rounded-full mix-blend-multiply filter blur-xl animate-blob animation-delay-2000"
            ></div>
            <div
                class="absolute bottom-40 left-1/2 w-72 h-72 bg-green-200 rounded-full mix-blend-multiply filter blur-xl animate-blob animation-delay-4000"
            ></div>
        </div>

        <!-- Code background effect -->
        <!-- Code background effect -->
        <div
            class="fixed inset-0 opacity-5 font-mono text-xs overflow-hidden pointer-events-none"
        >
            <div class="absolute inset-0 flex">
                <!-- Multiple columns of animated code -->
                <div
                    v-for="column in 12"
                    :key="column"
                    class="flex-1 animate-matrix"
                    :style="`animation-delay: -${column * 2}s`"
                >
                    <div
                        v-for="i in 100"
                        :key="i"
                        class="whitespace-nowrap px-1"
                    >
                        {{ generateRandomCode() }}
                    </div>
                </div>
            </div>
        </div>

        <!-- First Layer (Fixed) -->
        <div class="fixed inset-0 w-full h-screen">
            <!-- Title Section -->
            <div
                class="absolute top-[15%] md:top-1/4 left-1/2 -translate-x-1/2 text-center z-10 px-4"
            >
                <h1
                    class="text-3xl md:text-4xl lg:text-6xl font-bold text-transparent bg-clip-text bg-gradient-to-r from-emerald-600 to-teal-600 drop-shadow-sm"
                >
                    Wear What You Code
                </h1>
                <p
                    class="mt-2 md:mt-4 text-base md:text-xl text-gray-600 animate-fade-in"
                >
                    Premium dev shirts, bug-free guarantee
                </p>
            </div>

            <!-- Desktop T-shirts Layout -->
            <div
                class="hidden md:flex absolute bottom-0 w-full justify-center items-end"
            >
                <img
                    src="../../../../public/assets/home_images/left.png"
                    alt="T-shirt Left"
                    class="w-1/4 object-contain transform -translate-x-8 rotate-[-15deg] origin-bottom relative z-0 hover:scale-105 transition-transform duration-300 filter drop-shadow-lg animate-fade-slide-left"
                />
                <img
                    src="../../../../public/assets/home_images/middle.png"
                    alt="T-shirt Middle"
                    class="w-1/4 object-contain transform scale-110 relative z-0 hover:scale-125 transition-transform duration-300 filter drop-shadow-xl animate-fade-slide-up"
                />
                <img
                    src="../../../../public/assets/home_images/right.png"
                    alt="T-shirt Right"
                    class="w-1/4 object-contain transform translate-x-8 rotate-[15deg] origin-bottom relative z-0 hover:scale-105 transition-transform duration-300 filter drop-shadow-lg animate-fade-slide-right"
                />
            </div>

            <!-- Mobile T-shirts Layout -->
            <div
                class="md:hidden absolute bottom-0 w-full flex flex-col items-center gap-4 pb-20"
            >
                <img
                    src="../../../../public/assets/home_images/middle.png"
                    alt="T-shirt Middle"
                    class="w-3/4 max-w-[300px] object-contain relative z-0 hover:scale-110 transition-transform duration-300 filter drop-shadow-xl animate-fade-slide-up"
                />
                <div class="flex w-full justify-center gap-4">
                    <img
                        src="../../../../public/assets/home_images/left.png"
                        alt="T-shirt Left"
                        class="w-1/3 max-w-[200px] object-contain transform rotate-[-15deg] origin-bottom relative z-0 hover:scale-105 transition-transform duration-300 filter drop-shadow-lg animate-fade-slide-left"
                    />
                    <img
                        src="../../../../public/assets/home_images/right.png"
                        alt="T-shirt Right"
                        class="w-1/3 max-w-[200px] object-contain transform rotate-[15deg] origin-bottom relative z-0 hover:scale-105 transition-transform duration-300 filter drop-shadow-lg animate-fade-slide-right"
                    />
                </div>
            </div>
        </div>

        <!-- Second Layer (Curved) -->
        <div class="relative min-h-screen mt-[90vh]">
            <div
                class="absolute top-0 w-full h-[200vh] bg-white z-20 curved-section"
                style="
                    border-top-left-radius: 100% 15%;
                    border-top-right-radius: 100% 15%;
                    transform: translateY(-120px);
                "
            >
                <!-- Curve border effect -->
                <div
                    class="absolute inset-x-0 top-0 h-1 bg-gradient-to-r from-transparent via-emerald-200 to-transparent opacity-50"
                ></div>
            </div>
        </div>
    </div>
</template>

<script setup>
const generateRandomCode = () => {
    const characters = "{}[]()<>/*-+=!@#$%^&*";
    // Calculate characters based on viewport width
    const minChars = 20; // Minimum characters per column
    return Array(minChars)
        .fill(0)
        .map(() => characters[Math.floor(Math.random() * characters.length)])
        .join("");
};
</script>

<style scoped>
@keyframes blob {
    0% {
        transform: translate(0px, 0px) scale(1);
    }
    33% {
        transform: translate(30px, -50px) scale(1.1);
    }
    66% {
        transform: translate(-20px, 20px) scale(0.9);
    }
    100% {
        transform: translate(0px, 0px) scale(1);
    }
}

@keyframes matrix {
    0% {
        transform: translateY(-50%);
    }
    100% {
        transform: translateY(0);
    }
}

@keyframes fadeSlideUp {
    0% {
        opacity: 0;
        transform: translateY(30px) scale(110%);
    }
    100% {
        opacity: 1;
        transform: translateY(0) scale(110%);
    }
}

@keyframes fadeSlideLeft {
    0% {
        opacity: 0;
        transform: translate(30px, 0) rotate(-15deg);
    }
    100% {
        opacity: 1;
        transform: translate(-2rem, 0) rotate(-15deg);
    }
}

@keyframes fadeSlideRight {
    0% {
        opacity: 0;
        transform: translate(-30px, 0) rotate(15deg);
    }
    100% {
        opacity: 1;
        transform: translate(2rem, 0) rotate(15deg);
    }
}

.animate-blob {
    animation: blob 7s infinite;
}

.animation-delay-2000 {
    animation-delay: 2s;
}

.animation-delay-4000 {
    animation-delay: 4s;
}

.animate-matrix {
    animation: matrix 20s linear infinite;
    will-change: transform;
}
.flex-1 {
    min-width: 0; /* Ensures flex items can shrink below their content size */
}

.animate-fade-slide-up {
    animation: fadeSlideUp 1s ease-out forwards;
}

.animate-fade-slide-left {
    animation: fadeSlideLeft 1s ease-out forwards;
    animation-delay: 0.3s;
    opacity: 0;
}

.animate-fade-slide-right {
    animation: fadeSlideRight 1s ease-out forwards;
    animation-delay: 0.3s;
    opacity: 0;
}

.curved-section {
    position: relative;
    &::after {
        content: "";
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 1px;
        background: linear-gradient(
            90deg,
            transparent,
            rgba(16, 185, 129, 0.2),
            transparent
        );
    }
}

@media (max-width: 640px) {
    .animate-matrix {
        font-size: 0.5rem; /* Smaller text on mobile */
    }
}

/* Add soft hover effect to images */
img {
    transition: all 0.3s ease;
}
</style>
