<script setup lang="ts">
import { ref } from 'vue';
import Modal from '@/Components/Modal.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import { useForm } from '@inertiajs/vue3';
import TransactionType from '@/Enums/TransactionType'
import TextInput from '@/Components/TextInput.vue';
import InputError from '@/Components/InputError.vue';
import SelectInput from '@/Components/SelectInput.vue';
import InputLabel from '@/Components/InputLabel.vue';
import TextareaInput from '@/Components/TextareaInput.vue';
import Type from '@/Enums/TransactionType';
import dayjs from 'dayjs';
import { formatNumber, getCurrencyOptions } from '@/utils';
import CreateCategory from '@/Pages/Category/Partials/CreateCategory.vue';
import { useCategoriesStore, usePeriodStore } from '@/store';
import { onUpdated } from 'vue';
import { useToast } from "vue-toastification";
import InputCurrency from './InputCurrency.vue';

const openingInput = ref(false);

const categoryStore = useCategoriesStore()
const periodStore = usePeriodStore()
const toast = useToast();

const form = useForm({
    type: Type.Expense as any,
    category_id: "",
    amount: 0,
    time: dayjs().format('HH:mm'),
    date: periodStore.active,
    description: '',
})

const closeModal = () => {
    openingInput.value = false;
    form.reset();
}

const submitTransaction = () => {
    form.post(route('transactions.store'), {
        preserveScroll: true,
        preserveState: false,
        onSuccess: () => {
            form.reset();
            closeModal();
            toast.success('New record added!', {timeout:2000});
        },
    })
}

const currencyOptions = ref(getCurrencyOptions())

const updateCategory = (id: any) => {
    form.category_id = id
}

onUpdated(() => {
    form.date = periodStore.active;
})
</script>
<template>
    <div class="flex items-center justify-center">
        <button @click="openingInput = true" data-tooltip-target="tooltip-new" type="button" class="inline-flex items-center justify-center w-10 h-10 font-medium bg-primary-600 rounded-full hover:bg-primary-700 group focus:ring-4 focus:ring-primary-300 focus:outline-none dark:focus:ring-primary-800">
            <svg class="w-4 h-4 text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 18 18">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 1v16M1 9h16"/>
            </svg>
            <span class="sr-only">New item</span>
        </button>

        <Modal :show="openingInput">
            <div class="py-8 px-6">
                <form @submit.prevent="submitTransaction" class="mx-auto">
                    <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                        Add new transaction
                    </h2>

                    <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                        Capture your transaction details by completing the form below.
                    </p>

                    <div class="mt-6">

                        <div class="py-2">
                            <div class="flex justify-between">
                                <InputLabel class="mb-2" for="date">Date <span class="text-red-500">*</span></InputLabel>
                            </div>
                            <TextInput id="date" type="date" class="w-full text-sm" required v-model="form.date"/>
                            <InputError :message="form.errors.date" class="mt-2" />
                        </div>

                        <div class="py-2">
                            <span for="type" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Type</span>
                            <ul class="items-center w-full text-sm font-medium text-gray-900 bg-white border border-gray-200 rounded-lg sm:flex dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                                <li class="w-full border-b border-gray-200 sm:border-b-0 sm:border-r dark:border-gray-600">
                                    <div class="flex items-center ps-3">
                                        <input id="horizontal-list-expense" v-model="form.type" @change.capture="form.category_id = ''" type="radio" :value="TransactionType.Expense" class="w-4 h-4 text-primary-600 bg-gray-100 border-gray-300 focus:ring-primary-500 dark:focus:ring-primary-600 dark:ring-offset-gray-700 dark:focus:ring-offset-gray-700 focus:ring-2 dark:bg-gray-600 dark:border-gray-500">
                                        <label for="horizontal-list-expense" class="w-full py-3 ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">Expense</label>
                                    </div>
                                </li>
                                <li class="w-full dark:border-gray-600">
                                    <div class="flex items-center ps-3">
                                        <input id="horizontal-list-income" v-model="form.type" @change.capture="form.category_id = ''" type="radio" :value="TransactionType.Income" class="w-4 h-4 text-primary-600 bg-gray-100 border-gray-300 focus:ring-primary-500 dark:focus:ring-primary-600 dark:ring-offset-gray-700 dark:focus:ring-offset-gray-700 focus:ring-2 dark:bg-gray-600 dark:border-gray-500">
                                        <label for="horizontal-list-income" class="w-full py-3 ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">Income</label>
                                    </div>
                                </li>
                            </ul>
                            <InputError :message="form.errors.type" class="mt-2" />
                        </div>

                        <div class="py-2">
                            <div class="mb-2 flex justify-between">
                                <InputLabel for="category">Category <span class="text-red-500">*</span></InputLabel>
                                <CreateCategory :ajax="true" :default="form.type" @new-category-added="updateCategory" />
                            </div>
                            <SelectInput required v-model="form.category_id" id="category" placeholder="please choose">
                                <option value="" disabled selected>Select category...</option>
                                <template v-for="(category) in categoryStore.list[form.type]">
                                    <option class="dark:text-gray-300 my-1" :value="category.id">{{ category.name }}</option>
                                </template>
                            </SelectInput>
                            <InputError :message="form.errors.category_id" class="mt-2" />
                        </div>

                        <div class="py-2">
                            <div class="flex mb-2 justify-between">
                                <InputLabel for="amount">Amount <span class="text-red-500">*</span></InputLabel>
                                <span class="text-primary-600 dark:text-primary-500 font-bold" v-if="form.type === Type.Income">{{ formatNumber(form.amount) }}</span>
                                <span class="text-red-600 dark:text-red-500 font-bold" v-else>{{ formatNumber(form.amount) }}</span>
                            </div>
                            <InputCurrency id="amount" v-model="form.amount" :options="currencyOptions"/>
                            <InputError :message="form.errors.amount" class="mt-2" />
                        </div>

                        <div class="py-2">
                            <InputLabel class="mb-2" for="description">Description <span class="font-thin">(optional)</span></InputLabel>
                            <TextareaInput id="description" v-model="form.description" rows="4" placeholder="Add a quick note about this transaction..." maxlength="200"/>
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
    </div>
</template>