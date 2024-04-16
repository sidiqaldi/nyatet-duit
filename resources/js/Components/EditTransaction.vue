<script setup lang="ts">
import { ref } from 'vue';
import { TransactionModel } from '@/types';
import Modal from '@/Components/Modal.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import { useForm, usePage } from '@inertiajs/vue3';
import TransactionType from '@/Enums/TransactionType'
import TextInput from './TextInput.vue';
import InputError from './InputError.vue';
import SelectInput from './SelectInput.vue';
import InputLabel from './InputLabel.vue';
import TextareaInput from './TextareaInput.vue';
import Type from '@/Enums/TransactionType';
import { onMounted } from 'vue';
import DangerButton from './DangerButton.vue';

const emit = defineEmits<{
    (e: 'close', id: number): void
}>()

const categories = usePage().props.auth.categories;
const props = defineProps<{
    transaction: TransactionModel
}>();

const form = useForm({
    type: Type.Expense as any,
    category_id: null as any,
    amount: null as any,
    date: '' as any,
    description: '' as any,
});

const modalOpened = ref(false);

const showDeleteConfirmation = ref(false);

const closeModal = () => {
    modalOpened.value = false;

    setTimeout(() => emit('close', props.transaction.id), 500);
};

onMounted(() => {
    if (props.transaction) {
        modalOpened.value = true;
    }

    form.type = props.transaction.type_id;
    form.category_id = props.transaction.category_id;
    form.amount = props.transaction.amount;
    form.date = props.transaction.date;
    form.description = props.transaction.description;
})

const formatNumber = (number: number|null): string => {
    if (number === null) {
        number = 0;
    }
    let currency = new Intl.NumberFormat('id-ID', {
        style: 'currency',
        currency: 'IDR',
    });
    return currency.format(number);
}

const submitTransaction = () => {
    form.put(route('transactions.update', props.transaction.id), {
        preserveScroll: true,
        onSuccess: () => {
            form.reset();
            closeModal();
        },
        onFinish: () => form.reset(),
    })
}

const confirmDeletion = () => {
    showDeleteConfirmation.value = true;
}

const cancelDeletion = () => {
    showDeleteConfirmation.value = false;
}

const deleteTransaction = () => {
    form.delete(route('transactions.destroy', props.transaction.id), {
        preserveScroll: true,
        onSuccess: () => {
            form.reset();
            closeModal();
        },
        onFinish: () => form.reset(),
    })
}

</script>
<template>
    <div class="flex items-center justify-center">

        <Modal :show="modalOpened">
            <div class="py-8 px-6">
                <form @submit.prevent="submitTransaction" class="mx-auto">
                    <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                        Edit Transaction
                    </h2>

                    <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                        Capture your transaction details by completing the form below.
                    </p>

                    <div class="mt-6">

                        <div class="py-2">
                            <div class="flex justify-between">
                                <InputLabel class="mb-2" for="date">Date</InputLabel>
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
                            <InputLabel class="mb-2" for="category">Category</InputLabel>
                            <SelectInput required v-model="form.category_id" id="category" placeholder="please choose">
                                <option value="" disabled selected>Select category...</option>
                                <template v-for="(category) in categories[form.type]">
                                    <option :value="category.id">{{ category.name }}</option>
                                </template>
                            </SelectInput>
                            <InputError :message="form.errors.category_id" class="mt-2" />
                        </div>

                        <div class="py-2">
                            <div class="flex justify-between">
                                <InputLabel class="mb-2" for="amount">Amount</InputLabel>
                                <span class="text-primary-600 dark:text-primary-500 font-bold" v-if="form.type === Type.Income">{{ formatNumber(form.amount) }}</span>
                                <span class="text-red-600 dark:text-red-500 font-bold" v-else>{{ formatNumber(form.amount) }}</span>
                            </div>
                            <TextInput id="amount" class="w-full text-sm" type="number" required v-model="form.amount" min="0" max="10000000000" :placeholder="formatNumber(1000)" />
                            <InputError :message="form.errors.amount" class="mt-2" />
                        </div>

                        <div class="py-2">
                            <InputLabel class="mb-2" for="description">Description</InputLabel>
                            <TextareaInput id="description" v-model="form.description" rows="4" placeholder="Add a quick note about this transaction..." />
                            <InputError :message="form.errors.description" class="mt-2" />
                        </div>

                    </div>

                    <div class="mt-6 flex justify-between">
                        <div class="flex justify-start">
                            <DangerButton v-if="!showDeleteConfirmation" class="mr-2" type="button" @click.prevent="confirmDeletion">Delete</DangerButton>
                            <div v-else>
                                <p class="text-gray-600 dark:text-gray-400 mb-2">Are you sure?</p>
                                <div class="flex justify-end">
                            <SecondaryButton class="mr-2" type="button" @click.prevent="cancelDeletion">cancel</SecondaryButton>
                            <DangerButton type="button" @click.prevent="deleteTransaction">Delete</DangerButton>
                        </div>
                            </div>
                        </div>
                        <div class="flex justify-end"  v-if="!showDeleteConfirmation" >
                            <SecondaryButton class="mr-2" type="button" @click.prevent="closeModal">cancel</SecondaryButton>
                            <PrimaryButton type="submit">Submit</PrimaryButton>
                        </div>
                    </div>
                </form>
            </div>
        </Modal>
    </div>
</template>