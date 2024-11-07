<script setup>
import Admin from "@/Layouts/Admin.vue";
import { Head } from "@inertiajs/vue3";
import Dialog from "primevue/dialog";
import { ref } from "vue";
import UploadImage from "@/Components/UploadImage.vue";
import { useForm } from "@inertiajs/vue3";
import { useToast } from "primevue/usetoast";
import Toast from "primevue/toast";

defineOptions({ layout: Admin });

const props = defineProps({
    tshirts: {
        type: Array,
    },
});

const toast = useToast();
const showAddTshirtModal = ref(false);

// Initialize form data
const form = useForm({
    title: "",
    price: "",
    description: "",
    mainImage: null,
    secondImage: null,
    thirdImage: null,
    forthImage: null,
    fifthImage: null,
});

function handleSubmit() {
    const formData = new FormData();

    // Append images to formData
    if (form.mainImage) formData.append("mainImage", form.mainImage);
    if (form.secondImage) formData.append("secondImage", form.secondImage);
    if (form.thirdImage) formData.append("thirdImage", form.thirdImage);
    if (form.forthImage) formData.append("forthImage", form.forthImage);
    if (form.fifthImage) formData.append("fifthImage", form.fifthImage);

    // Append other form fields to formData
    formData.append("title", form.title);
    formData.append("price", form.price);
    formData.append("description", form.description);

    // Use Inertia to post the formData
    form.post("/admin/t-shirts", {
        data: formData,
        forceFormData: true, // Needed to ensure multipart/form-data
        preserveState: false,
        onSuccess: () => {
            toast.add({
                severity: "success",
                summary: "Success",
                detail: "T-Shirt added successfully",
                life: 3000,
            });
        },
        onError: () => {
            const errorMessage = Object.values(form.errors)[0];
            toast.add({
                severity: "error",
                summary: "Error",
                detail: errorMessage,
                life: 3000,
            });
        },
    });
}
</script>

<template>
    <div class="">
        <Head title="T-Shirts" />
        <Toast />
        <!-- Add T-Shirt Modal -->
        <Dialog
            v-model:visible="showAddTshirtModal"
            modal
            header="Create New T-Shirt"
            :style="{ width: '70rem' }"
        >
            <form class="p-2" @submit.prevent="handleSubmit">
                <!-- Infos Section -->
                <div class="w-full flex gap-2 my-6">
                    <input
                        type="text"
                        placeholder="Title"
                        v-model="form.title"
                        class="w-4/5"
                    />
                    <input
                        type="text"
                        placeholder="Price"
                        v-model="form.price"
                        class="w-1/5"
                    />
                </div>
                <textarea
                    placeholder="Description"
                    v-model="form.description"
                    class="w-full h-full"
                ></textarea>
                <!-- Images Section -->
                <div
                    class="w-full h-[30rem] flex justify-center items-center gap-4"
                >
                    <!-- Main Image -->
                    <div class="w-1/2 h-full">
                        <UploadImage
                            id="mainImage"
                            width="w-full"
                            height="h-[30rem]"
                            label="Main Image"
                            v-model="form.mainImage"
                        />
                    </div>

                    <!-- Other Images -->
                    <div class="w-1/2 h-[30rem] grid grid-cols-2 gap-4">
                        <UploadImage
                            id="secondImage"
                            width="w-full"
                            height="h-[14.5rem]"
                            label="Second Image"
                            v-model="form.secondImage"
                        />
                        <UploadImage
                            id="thirdImage"
                            width="w-full"
                            height="h-[14.5rem]"
                            label="Third Image"
                            v-model="form.thirdImage"
                        />
                        <UploadImage
                            id="forthImage"
                            width="w-full"
                            height="h-[14.5rem]"
                            label="Forth Image"
                            v-model="form.forthImage"
                        />
                        <UploadImage
                            id="fifthImage"
                            width="w-full"
                            height="h-[14.5rem]"
                            label="Fifth Image"
                            v-model="form.fifthImage"
                        />
                    </div>
                </div>

                <!-- Submit Button -->
                <button type="submit" class="btn w-full mt-3">
                    Add T-Shirt
                </button>
            </form>
        </Dialog>

        <div class="w-full flex justify-end">
            <button
                @click="showAddTshirtModal = !showAddTshirtModal"
                class="btn"
            >
                Add T-Shirt
            </button>
        </div>

        <div class="w-full overflow-x-auto grid grid-cols-4 gap-4 pb-8 pt-2">
            <div
                v-for="tshirt in tshirts"
                :key="tshirt.id"
                class="flex flex-col gap-2 bg-slate-200 w-full h-full p-3 rounded-md shadow-md"
            >
                <img
                    :src="tshirt.mainImage.url"
                    class="w-full h-full object-cover rounded-md"
                />
                <p class="text-lg font-bold">{{ tshirt.title }}</p>
                <p class="text-lg font-bold">{{}}</p>
                <p class="text-sm font-bold text-green-600">
                    ${{ tshirt.price }}
                </p>
                <div class="grid grid-cols-4 gap-2">
                    <template v-for="i in 4" :key="i">
                        <div
                            class="flex flex-col gap-2 bg-white w-full h-full rounded-md shadow-md"
                        >
                            <template v-if="tshirt.otherImages[i]">
                                <img
                                    :src="tshirt.otherImages[i].url"
                                    class="w-full h-full object-cover rounded-md"
                                />
                            </template>
                            <div v-else class="w-12 h-12 rounded-md"></div>
                        </div>
                    </template>
                </div>
                <button class="btn">Edit</button>
            </div>
        </div>
    </div>
</template>
