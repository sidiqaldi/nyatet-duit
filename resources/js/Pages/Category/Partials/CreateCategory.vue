<script setup lang="ts">
import { ref } from 'vue';
import Modal from '@/Components/Modal.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import { useForm } from '@inertiajs/vue3';
import TransactionType from '@/Enums/TransactionType'
import TextInput from '@/Components//TextInput.vue';
import TextareaInput from '@/Components/TextareaInput.vue';
import InputError from '@/Components//InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import Type from '@/Enums/TransactionType';
import axios from 'axios';
import { useCategoriesStore } from '@/store';
import { useToast } from "vue-toastification";
import { onUpdated } from 'vue';

const categoryStore = useCategoriesStore();

const props = defineProps<{
    default?: Number;
    ajax?: Boolean;
    type?: String;
}>()

const toast = useToast();

const emit = defineEmits<{
    (e: 'newCategoryAdded', id: number): void
}>()

const form = useForm({
    type: (props.default ?? Type.Expense) as any,
    name: '' as any,
    description: '' as any,
});

const modalOpened = ref(false);

const openModal = () => {
    modalOpened.value = true;
}

const closeModal = () => {
    modalOpened.value = false;
};

onUpdated(() => {
    form.type = props.default;
})

const submitCategory = () => {
    if (props.ajax) {
        axios.post(route('categories.store'), {
            requestNonInertia: true,
            type: form.type,
            name: form.name,
            description: form.description,
        }).then((resp) => {
            let category = resp.data.data;

            categoryStore.add(category.type, category);

            form.reset();

            emit('newCategoryAdded', category.id);

            toast.success('New category added!', {timeout:2000});

            closeModal();

        }).catch((err) => {

            callInertiaForm();
        })

    } else {
        callInertiaForm();
    }
}

const callInertiaForm  = () => {
    form.post(route('categories.store'), {
        preserveScroll: true,
        onSuccess: () => {
            form.reset();
            closeModal();
            toast.success('New category added!', {timeout:2000});
        },
    })
}
</script>
<template>
    <button v-if="props.type == 'button'"
        @click="openModal"
        type="button"
        class="flex items-center justify-center px-4 py-2 text-sm font-medium text-white rounded-lg bg-primary-700 hover:bg-primary-800 focus:ring-4 focus:ring-primary-300 dark:bg-primary-600 dark:hover:bg-primary-700 focus:outline-none dark:focus:ring-primary-800"
    >
        Add new category
    </button>
    <button v-else
        @click="openModal"
        type="button"
        class="text-xs underline text-primary-700 dark:text-primary-500"
    >
        Add new category
    </button>

    <Modal :show="modalOpened">
        <div class="py-8 px-6">
            <form @submit.prevent="submitCategory" class="mx-auto">
                <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                    New Category
                </h2>

                <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                    Manage your categories name.
                </p>

                <div class="mt-6">

                    <div class="py-2">
                        <span for="type" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Type</span>
                        <ul class="items-center w-full text-sm font-medium text-gray-900 bg-white border border-gray-200 rounded-lg sm:flex dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                            <li class="w-full border-b border-gray-200 sm:border-b-0 sm:border-r dark:border-gray-600">
                                <div class="flex items-center ps-3">
                                    <input id="category-expense" v-model="form.type" type="radio" :value="TransactionType.Expense" class="w-4 h-4 text-primary-600 bg-gray-100 border-gray-300 focus:ring-primary-500 dark:focus:ring-primary-600 dark:ring-offset-gray-700 dark:focus:ring-offset-gray-700 focus:ring-2 dark:bg-gray-600 dark:border-gray-500">
                                    <label for="category-expense" class="w-full py-3 ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">Expense</label>
                                </div>
                            </li>
                            <li class="w-full dark:border-gray-600">
                                <div class="flex items-center ps-3">
                                    <input id="category-income" v-model="form.type" type="radio" :value="TransactionType.Income" class="w-4 h-4 text-primary-600 bg-gray-100 border-gray-300 focus:ring-primary-500 dark:focus:ring-primary-600 dark:ring-offset-gray-700 dark:focus:ring-offset-gray-700 focus:ring-2 dark:bg-gray-600 dark:border-gray-500">
                                    <label for="category-income" class="w-full py-3 ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">Income</label>
                                </div>
                            </li>
                        </ul>
                        <InputError :message="form.errors.type" class="mt-2" />
                    </div>


                    <div class="py-2">
                        <div class="flex justify-between">
                            <InputLabel class="mb-2" for="name">Name <span class="text-red-500">*</span></InputLabel>
                        </div>
                        <TextInput id="name" class="w-full text-sm" type="text" required v-model="form.name" maxlength="100" placeholder="ex: Food" />
                        <InputError :message="form.errors.name" class="mt-2" />
                    </div>

                    <div class="py-2">
                        <InputLabel class="mb-2" for="description">Description <span class="font-thin">(optional)</span></InputLabel>
                        <TextareaInput id="description" v-model="form.description" rows="4" placeholder="Add a quick note about this category..." maxlength="200"/>
                        <InputError :message="form.errors.description" class="mt-2" />
                    </div>

                </div>

                <div class="mt-6 flex justify-end">
                    <SecondaryButton class="mr-2" type="button" @click.prevent="closeModal">cancel</SecondaryButton>
                    <PrimaryButton type="submit">Submit</PrimaryButton>
                </div>
            </form>
        </div>
    </Modal>
</template>