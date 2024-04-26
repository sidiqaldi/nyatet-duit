<script setup lang="ts">
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import DangerButton from '@/Components/DangerButton.vue';
import dayjs from 'dayjs';
import InputError from '@/Components/InputError.vue';
import Modal from '@/Components/Modal.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { Head, useForm } from '@inertiajs/vue3';
import { formatNumber } from '@/utils';
import { ref } from 'vue';
import axios from 'axios';

const props = defineProps<{
    date: {year: number, month: number};
    categories: any;
    budgets: any;
    canCreate: boolean;
}>();

const submitBudget = () => {
    formInsertBudget.post(route('budgets.store'), {
        onSuccess: () => { formInsertBudget.amount = 0}
    })
};

const submitDeleteBudget = () => {
    let budetID = formDeleteBudget.budget_id;
    formDeleteBudget.delete(route('budgets.destroy', {budget: budetID}))
}

const modalSetBudgetOpen = ref(false);

const formInsertBudget = useForm({
    year: props.date.year,
    month: props.date.month,
    amount: 0,
    category_id: null,
})

const formDeleteBudget = useForm({
    budget_id: null
})

const navigationForm = useForm({
    period: dayjs().year(props.date.year).month(props.date.month - 1).format('YYYY-MM')
})

const nextPeriod = () => {
    navigationForm.period = (dayjs().year(props.date.year).month(props.date.month).format('YYYY-MM'))

    navigationForm.get(route('budgets.index'));
}

const prevPeriod = () => {
    navigationForm.period = (dayjs().year(props.date.year).month(props.date.month - 2).format('YYYY-MM'))

    navigationForm.get(route('budgets.index'));
}

const getPercentage = (amount: number, transaction: number) : any => {
    let percentage = (transaction ?? 0)/amount * 100;

    if (percentage >= 100) return percentage.toPrecision(5);

    return percentage.toPrecision(3);
}

const maxPercentage = (amount: number) => {
    if (amount > 100) return 100;

    return amount;
}

const getLabelClass = (amount: number) => {
    if (amount >= 100) {
        return 'bg-red-600';

    } else if (amount >= 80) {
        return 'bg-amber-600';

    } else {
        return 'bg-primary-600';
    }
}

const openModalSetBudget = () => {

    modalSetBudgetOpen.value = true;

    getBudgetPeriod.value = currentPeriod.value.subtract(1, 'month')

    parseBudget();
}
const getBudgetPeriod = ref(dayjs()) as any

const currentPeriod = ref(dayjs().year(props.date.year).month(props.date.month - 1));

const listBudget = ref([]) as any;

const parseBudget = () => {

    axios.get(route('budgets.index'), {
        params: {
            requestNonInertia: true,
            period: getBudgetPeriod.value.format('YYYY-MM')
        }
    }).then((resp) => {
        listBudget.value = resp.data.data;
    })
}

const getPrevBudgetPeriod = () => {
    getBudgetPeriod.value = getBudgetPeriod.value.subtract(1, 'month');

    parseBudget();
}

const getNextBudgetPeriod = () => {

    if (currentPeriod.value.subtract(1, 'month').format('YYYY-MM') === getBudgetPeriod.value.format('YYYY-MM')) return;

    getBudgetPeriod.value = getBudgetPeriod.value.add(1, 'month');

    parseBudget();
}

const budgetSetLoading = ref(false)

const closeSetBudget = () => {
    setTimeout(() => {
        budgetSetLoading.value = false;

        modalSetBudgetOpen.value = false;

        navigationForm.get(route('budgets.index'));
    }, 1000)
}

const submitSetBudget = () => {

    budgetSetLoading.value = true;

    (listBudget.value).forEach((budget: any) => {

        if (budget.checked) {
            axios.post(route('budgets.store'), {
                requestNonInertia: true,
                amount: budget.amount,
                category_id: budget.category_id,
                year: formInsertBudget.year,
                month: formInsertBudget.month,
            }).then((resp) => {
                listBudget.value = resp.data.data;
            })
        }

    });

    closeSetBudget();
}

</script>
<template>
    <Head title="Budgets" />

    <AuthenticatedLayout>
        <div class="relative overflow-x-auto">

            <div class="w-full p-5 text-lg font-semibold text-left rtl:text-right text-gray-900 bg-white dark:text-white dark:bg-gray-800">
                <div>
                    Budget Management
                    <p class="mt-1 max-w-4xl text-sm font-normal text-gray-500 dark:text-gray-400">
                        Categories help you classify transactions, like income, expenses, or specific spending areas such as groceries or entertainment. Organizing transactions makes tracking spending easier and clearer.
                    </p>
                </div>
            </div>

            <nav class="flex flex-col sm:flex-row justify-between px-5 pb-5 bg-white dark:text-white dark:bg-gray-800" aria-label="Page navigation example">
                <div class="flex mb-2 sm:mb-0 justify-center">
                    <PrimaryButton v-if="canCreate" @click="openModalSetBudget">Set from past</PrimaryButton>
                </div>

                <ul class="flex items-center justify-center -space-x-px h-10 text-base">
                    <li>
                        <a href="#" @click="prevPeriod" class="flex items-center justify-center px-4 h-10 ms-0 leading-tight text-gray-500 bg-white border border-e-0 border-gray-300 rounded-s-lg hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">
                            <span class="sr-only">Previous</span>
                            <svg class="w-3 h-3 rtl:rotate-180" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 1 1 5l4 4"/>
                            </svg>
                        </a>
                    </li>
                    <li>
                        <span class="flex items-center justify-center px-4 h-10 leading-tight text-gray-500 bg-white border border-gray-300 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400">
                            {{ dayjs().year(date.year).month(date.month - 1).format('MMMM, YYYY') }}
                        </span>
                    </li>
                    <li>
                    <a href="#" @click="nextPeriod" class="flex items-center justify-center px-4 h-10 leading-tight text-gray-500 bg-white border border-gray-300 rounded-e-lg hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">
                        <span class="sr-only">Next</span>
                        <svg class="w-3 h-3 rtl:rotate-180" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 9 4-4-4-4"/>
                        </svg>
                    </a>
                    </li>
                </ul>
            </nav>
        </div>

        <div class="relative overflow-x-auto">
            <table class="mt-4 w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">

                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                    <tr>
                        <th scope="col" class="px-6 py-3">
                            Category
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Amount
                        </th>
                        <th scope="col" class="px-6 py-3">
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <template v-for="budget in budgets.data">
                        <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                            <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                {{ budget.category_name }}
                            </th>
                            <td class="px-6 py-4">
                                <div class="mb-2 text-nowrap">{{ formatNumber(budget.transaction) }} / <span class="font-semibold">{{ formatNumber(budget.amount) }}</span></div>
                                <div class="w-full bg-gray-400 rounded-full dark:bg-gray-700">
                                    <div :class="getLabelClass(getPercentage(budget.amount, budget.transaction))" class="text-xs font-medium text-white text-center px-2 py-1 leading-none rounded-full" :style="'width: ' + maxPercentage(getPercentage(budget.amount, budget.transaction)) +'%'">
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 flex justify-end">
                                <form class="max-w-1/2" @submit.prevent="submitDeleteBudget" v-if="formDeleteBudget.budget_id === budget.id">
                                    <div class="flex gap-2 flex-wrap align-middle">
                                        <span>Are you sure?</span>
                                        <PrimaryButton type="submit">confirm</PrimaryButton>
                                        <SecondaryButton @click="formDeleteBudget.budget_id = null">cancel</SecondaryButton>
                                    </div>
                                    <InputError class="mt-2" :message="formDeleteBudget.errors.budget_id" />
                                </form>
                                <DangerButton v-else @click="formDeleteBudget.budget_id = budget.id">Delete</DangerButton>
                            </td>
                        </tr>
                    </template>
                    <template v-if="!budgets.data.length && canCreate">
                        <tr class="bg-white dark:bg-gray-800 dark:border-gray-700">
                            <td class="p-10 text-center text-gray-400" colspan="4">
                                It looks like you haven't created any budgets for this periods yet.
                                <br/> Budgeting help you organize your spending and track your expenses more effectively.
                            </td>
                        </tr>
                    </template>
                    <template v-if="!canCreate">
                        <tr class="bg-white dark:bg-gray-800 dark:border-gray-700">
                            <td class="p-10 text-center text-gray-400" colspan="4">
                                Can't set budgeting for past periods.
                            </td>
                        </tr>
                    </template>
                </tbody>
            </table>
        </div>
        <div class="relative overflow-x-auto">
            <table v-if="categories.data.length && canCreate" class="mt-4 w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">

                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                    <tr>
                        <th scope="col" class="px-6 py-3">
                            Category name
                        </th>
                        <th scope="col" class="px-6 py-3">
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <template v-for="category in categories.data">
                        <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                            <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                {{ category.name }}
                            </th>
                            <td class="px-6 py-4 flex justify-end">
                                <form @submit.prevent="submitBudget" v-if="formInsertBudget.category_id === category.id">
                                    <div class="flex gap-2 flex-wrap">
                                        <TextInput type="number" v-model="formInsertBudget.amount" />
                                        <PrimaryButton type="submit">save</PrimaryButton>
                                        <SecondaryButton @click="formInsertBudget.category_id = null">cancel</SecondaryButton>
                                    </div>
                                    <InputError class="mt-2" :message="formInsertBudget.errors.amount" />
                                </form>
                                <SecondaryButton v-else @click="formInsertBudget.category_id = category.id">Set Budget</SecondaryButton>
                            </td>
                        </tr>
                    </template>
                </tbody>
            </table>
        </div>
    </AuthenticatedLayout>

    <Modal :show="modalSetBudgetOpen">
        <div v-if="!budgetSetLoading" class="w-full flex items-center justify-center h-56 border border-gray-200 rounded-lg bg-gray-50 dark:bg-gray-800 dark:border-gray-700">
            <div role="status">
                <svg aria-hidden="true" class="w-8 h-8 text-gray-200 animate-spin dark:text-gray-600 fill-primary-600" viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z" fill="currentColor"/><path d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z" fill="currentFill"/></svg>
                <span class="sr-only">Loading...</span>
            </div>
            <div class="ms-3 text-lg">Plese wait...</div>
        </div>


        <div v-else class="py-8 px-6">
            <form @submit.prevent="submitSetBudget" class="mx-auto">
                <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                    Select Budget
                </h2>

                <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                    Please check budget by each categories.
                </p>

                <ul class="mt-4 flex items-center justify-center -space-x-px h-10 text-base">
                    <li>
                        <a href="#" @click="getPrevBudgetPeriod" class="flex items-center justify-center px-4 h-10 ms-0 leading-tight text-gray-500 bg-white border border-e-0 border-gray-300 rounded-s-lg hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">
                            <span class="sr-only">Previous</span>
                            <svg class="w-3 h-3 rtl:rotate-180" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 1 1 5l4 4"/>
                            </svg>
                        </a>
                    </li>
                    <li>
                        <span class="flex items-center justify-center px-4 h-10 leading-tight text-gray-500 bg-white border border-gray-300 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400">
                            {{ getBudgetPeriod.format('MMMM, YYYY') }}
                        </span>
                    </li>
                    <li>
                    <a href="#" @click="getNextBudgetPeriod" class="flex items-center justify-center px-4 h-10 leading-tight text-gray-500 bg-white border border-gray-300 rounded-e-lg hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">
                        <span class="sr-only">Next</span>
                        <svg class="w-3 h-3 rtl:rotate-180" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 9 4-4-4-4"/>
                        </svg>
                    </a>
                    </li>
                </ul>

                <div v-if="listBudget.length" class="mt-3 relative overflow-x-auto">
                    <table v-if="canCreate" class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">

                        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                            <tr>
                                <th scope="col" class="px-6 py-3">
                                    Category
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Amount
                                </th>
                                <th scope="col" class="px-6 py-3">
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <template v-for="budget in listBudget">
                                <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                                    <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                        {{ budget.category_name }}
                                    </th>
                                    <td class="px-6 py-4">
                                        {{ formatNumber(budget.amount) }}
                                    </td>
                                    <td class="px-6 py-4 flex justify-end">
                                        <input type="checkbox" v-model="budget.checked" :checked="budget.checked" />
                                    </td>
                                </tr>
                            </template>
                        </tbody>
                    </table>
                </div>

                <div v-else>
                    <p class="p-10 text-center text-gray-400" colspan="4">
                        No budgeting for this periods.
                    </p>
                </div>

                <div class="mt-6 flex justify-end">
                    <SecondaryButton class="mr-2" type="button" @click.prevent="modalSetBudgetOpen = false">cancel</SecondaryButton>
                    <PrimaryButton type="submit">Submit</PrimaryButton>
                </div>
            </form>
        </div>
    </Modal>
</template>