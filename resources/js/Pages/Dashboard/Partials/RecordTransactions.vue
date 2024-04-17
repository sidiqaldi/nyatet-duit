<script setup lang="ts">
import IconCaretUp from '@/Components/IconCaretUp.vue';
import IconCaretDown from '@/Components/IconCaretDown.vue';
import IconFilter from '@/Components/IconFilter.vue';
import Type from '@/Enums/TransactionType';
import VueDatePicker from '@vuepic/vue-datepicker';
import '@vuepic/vue-datepicker/dist/main.css';
import '@/../css/datepicker.css';
import {  dark, activeTheme } from '@/themeVariables';
import { ref } from 'vue';
import type { DatePickerInstance } from "@vuepic/vue-datepicker"
import { onMounted } from 'vue';
import { onBeforeMount } from 'vue';
import { Link, useForm, usePage } from '@inertiajs/vue3';
import dayjs from 'dayjs';
import IconWallet from '@/Components/IconWallet.vue';
import EditTransaction from '@/Components/EditTransaction.vue';

const props = defineProps<{
    transactions: any;
    period: any;
    totalExpense: number;
    totalIncome: number;
    balancePeriod: number;
}>();

const categories = usePage().props.auth.categories;

const datePeriod = ref({
    month: new Date().getMonth(),
    year: new Date().getFullYear()
});

const darkMode = ref(false);

const displayDate = ref('');

const formatNumber = (number: number | null): string => {
    if (number === null) {
        number = 0;
    }
    let currency = new Intl.NumberFormat('id-ID', {
        style: 'currency',
        currency: 'IDR',
    });
    return currency.format(number);
};

onBeforeMount(() => {
    darkMode.value = activeTheme.value === dark
})

onMounted(() => {
    let month = props.period.month - 1;

    let year = props.period.year;

    datePeriod.value = {
        month: month,
        year: year,
    }

    let formMonth = props.period.month < 10 ? '0' + props.period.month : props.period.month;

    form.period = year + '-' + formMonth;

    displayDate.value = dayjs().month(month).year(year).format('MMMM, YYYY')
})

const form = useForm({
    period : props.period.year + '-' + props.period.month,
    filter: {
        type: null,
        category_id: [] as number[],
        search: '',
    },
})

const changePeriod = (modelData: any) => {

    let month = modelData.month + 1;

    month = month < 10 ? '0' + month : month;

    form.period = modelData.year + '-' + month;

    displayDate.value = dayjs().month(modelData.month).year(modelData.year).format('MMMM, YYYY')

    handleFilter();
}

const openEditTransaction = ref(null) as any;

const handleEditTransaction = (transcation: any) => {
    openEditTransaction.value = transcation;
}

const closeEditTransaction = () => {
    openEditTransaction.value = null;
}
const datepicker = ref<DatePickerInstance>(null);

const opendatePicker = () => {
    if (datepicker.value) {
        datepicker.value.openMenu();
    }
}

const handleSelectType = () => {
    form.filter.category_id = [],

    handleFilter();
}

const handleFilter = () => {
    form.get(route('dashboard'), {
        preserveScroll: true,
        preserveState: true
    });
};

const isCategorySelected = (categoryId: number) => {
    return form.filter.category_id.includes(categoryId);
}

const toggleCategorySelection = (categoryId: number) => {
    const index = form.filter.category_id.indexOf(categoryId);

    if (index === -1) {
        form.filter.category_id.push(categoryId);
    } else {
        form.filter.category_id.splice(index, 1);
    }

    handleFilter();
}
</script>
<template>
    <div class="container mt-8 max-w-7xl mx-auto lg:px-6">
        <div class="w-full p-4 sm:py-8 bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700">
            <div class="flex flex-col sm:flex-row items-center justify-between mb-4">
                <div class="mb-2 sm:mb-0">
                    <h5 class="text-xl ml-4 font-bold leading-none text-gray-900 dark:text-white">
                        Transaction Records
                    </h5>
                </div>
                <div class="flex items-center gap-2 cursor-pointer justify-end">
                    <h5 @click="opendatePicker" class="text-sm font-medium text-primary-600 dark:text-primary-500">Change</h5>
                    <div class="flex w-2/3 items-center">
                        <div>
                            <VueDatePicker
                                ref="datepicker"
                                @update:model-value="changePeriod"
                                :dark="darkMode"
                                v-model="datePeriod"
                                month-picker
                                auto-apply
                            >
                                <template #clear-icon></template>
                            </VueDatePicker>
                        </div>
                        <div>
                            <button
                                id="filterDropdownButton"
                                data-dropdown-toggle="filterDropdown"
                                class="max-w-1/3 ms-2 flex items-center justify-center w-full px-2 py-2 text-sm font-medium text-gray-900 bg-white rounded-lg md:w-auto focus:outline-none hover:bg-gray-100 hover:text-primary-700 focus:z-10 focus:ring-4 focus:ring-gray-200 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700"
                                type="button"
                            >
                                <IconFilter class="size-5 text-gray-400" />
                            </button>
                            <div id="filterDropdown" class="z-10 hidden w-48 p-3 divide-y space-y-4 gap-3 bg-white rounded-lg shadow dark:bg-gray-700">
                                <div>
                                    <h6 class="mb-3 text-sm font-medium text-gray-900 dark:text-white">
                                        Type
                                    </h6>
                                    <ul class="space-y-2 text-sm" aria-labelledby="dropdownDefault">
                                        <li class="flex items-center">
                                            <input @change="handleSelectType" :id="'type-all'" type="radio" :value="null" v-model="form.filter.type"
                                                class="w-4 h-4 bg-gray-100 border-gray-300 rounded text-primary-600 focus:ring-primary-500 dark:focus:ring-primary-600 dark:ring-offset-gray-700 focus:ring-2 dark:bg-gray-600 dark:border-gray-500" />
                                            <label :for="'type-all'" class="ml-2 text-sm font-medium text-gray-900 dark:text-gray-100">
                                                All
                                            </label>
                                        </li>
                                        <li class="flex items-center" v-for="(value, name) in Type">
                                            <input @change="handleSelectType" :id="'type-'+name" type="radio" :value="value" v-model="form.filter.type"
                                                class="w-4 h-4 bg-gray-100 border-gray-300 rounded text-primary-600 focus:ring-primary-500 dark:focus:ring-primary-600 dark:ring-offset-gray-700 focus:ring-2 dark:bg-gray-600 dark:border-gray-500" />
                                            <label :for="'type-'+name" class="ml-2 text-sm font-medium text-gray-900 dark:text-gray-100">
                                                {{ name }}
                                            </label>
                                        </li>
                                    </ul>
                                </div>
                                <div v-if="form.filter.type != null">
                                    <h6 class="mb-3 mt-2 text-sm font-medium text-gray-900 dark:text-white">
                                        Category
                                    </h6>
                                    <ul class="space-y-2 text-sm" aria-labelledby="dropdownDefault">
                                        <template v-for="category in categories[form.filter.type]">
                                            <li class="flex items-center">
                                                <input
                                                    type="checkbox"
                                                    :id="'category'+category.id"
                                                    :value="category.id"
                                                    :checked="isCategorySelected(category.id)"
                                                    @change="toggleCategorySelection(category.id)"
                                                    class="w-4 h-4 bg-gray-100 border-gray-300 rounded text-primary-600 focus:ring-primary-500 dark:focus:ring-primary-600 dark:ring-offset-gray-700 focus:ring-2 dark:bg-gray-600 dark:border-gray-500"
                                                />
                                                <label :for="'category'+category.id" class="ml-2 text-sm font-medium text-gray-900 dark:text-gray-100">
                                                    {{ category.name }}
                                                </label>
                                            </li>
                                        </template>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="mb-5 px-4 lg:flex lg:gap-2 lg:justify-between border-b">
                <div>
                    <div class="font-thin text-gray-500 dark:text-gray-400">Income & Expense <span class="font-normal text-primary-600 dark:text-primary-500">{{ displayDate }}</span></div>
                    <div role="list" class="flex flex-col sm:flex-row my-5 justify-center lg:justify-start gap-5 lg:gap-2">
                        <div class="flex items-center align-middle">
                            <IconCaretUp class="h-3 text-primary-500 dark:text-primary-400"/>
                            <span class="text-base font-normal leading-tight text-gray-500 dark:text-gray-400 ">{{ formatNumber(totalIncome) }}</span>
                        </div>
                        <div class="flex items-center align-middle">
                            <IconCaretDown class="h-3 text-red-600 dark:text-red-500"/>
                            <span class="text-base font-normal leading-tight text-gray-500 dark:text-gray-400 ">{{ formatNumber(totalExpense) }}</span>
                        </div>
                    </div>
                </div>
                <div class="items-center align-middle mb-5">
                    <div class="font-thin mb-4 text-gray-500 dark:text-gray-400">Balance left</div>
                    <div class="flex items-center align-middle justify-start sm:justify-center">
                        <IconWallet class="h-3 text-gray-500 dark:text-gray-400"/>
                        <div class="text-base font-normal leading-tight text-gray-500 dark:text-gray-400 ">{{ formatNumber(balancePeriod) }}</div>
                    </div>
                </div>
            </div>

            <div v-if="transactions.meta.total" class="flex justify-between items-center px-4 py-2 mb-2 bg-gray-100 rounded dark:bg-gray-900">
                <div class="text-sm text-gray-700 dark:text-gray-400">
                    Showing <span class="font-semibold text-gray-900 dark:text-white">{{ transactions.meta.from }}</span> to
                    <span class="font-semibold text-gray-900 dark:text-white">{{ transactions.meta.to }}</span> of
                    <span class="font-semibold text-gray-900 dark:text-white">{{ transactions.meta.total }}</span> Entries
                </div>
                <div class="inline-flex xs:mt-0">
                    <Link
                        as="button"
                        v-if="transactions.links.prev"
                        :href="transactions.links.prev"
                        preserve-state
                        preserve-scroll
                        class="flex items-center justify-center px-3 py-1 text-sm font-medium text-white bg-gray-400 rounded-s hover:bg-gray-600 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white"
                    >
                        Prev
                    </Link>
                    <button v-else disabled class="flex items-center justify-center px-3 py-1 text-sm font-medium text-gray-300 bg-gray-400 rounded-s dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400">
                        Prev
                    </button>
                    <Link
                        as="button"
                        v-if="transactions.links.next"
                        :href="transactions.links.next"
                        preserve-state
                        preserve-scroll
                        class="flex items-center justify-center px-3 py-1 text-sm font-medium text-white bg-gray-400 border-0 border-s border-gray-300 rounded-e hover:bg-gray-600 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white"
                    >
                        Next
                    </Link>
                    <button v-else disabled class="flex items-center justify-center px-3 py-1 text-sm font-medium text-gray-300 bg-gray-400 border-0 border-s border-gray-300 rounded-e dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400">
                        Next
                    </button>
                </div>
            </div>

            <div class="flow-root">
                <ul role="list" class="divide-y divide-gray-200 dark:divide-gray-700 overflow-auto">
                    <template v-for="transaction in transactions.data">
                        <li @click="handleEditTransaction(transaction)" class="pr-2 py-2 sm:py-4 divide-gray-300 hover:bg-gray-50 dark:hover:bg-gray-600 hover:rounded-lg cursor-pointer">
                            <div class="flex items-center w-full justify-between">
                                <div class="flex items-center">
                                    <IconCaretUp v-if="transaction.type_id === Type.Income" class="text-primary-500 dark:text-primary-400"/>
                                    <IconCaretDown v-else class="text-red-600 dark:text-red-500 "/>
                                    <div class="flex-1 min-w-0 ms-4">
                                        <p class="text-sm font-medium text-gray-900 truncate dark:text-white">
                                            {{ transaction.category }}
                                        </p>
                                        <p class="text-xs text-gray-500 truncate dark:text-gray-400">
                                            {{ transaction.date }}
                                        </p>
                                    </div>
                                    <p :title="transaction.description"
                                        class="hidden sm:block ms-10 max-w-40 lg:max-w-60 text-sm text-gray-500 truncate dark:text-gray-400 font-normal overflow-clip"
                                    >
                                        {{ transaction.description }}
                                    </p>
                                </div>
                                <div class="inline-flex items-center text-base font-semibold text-gray-900 dark:text-white">
                                    {{ formatNumber(transaction.amount) }}
                                </div>
                            </div>
                        </li>
                    </template>
                    <template v-if="transactions.meta.total == 0">
                        <div class="bg-white dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                            <div class="px-3 pt-3 text-center text-gray-400" colspan="4">
                                Oops! It looks like there are no transactions recorded for the selected period. <br/> Start adding transactions to track your finances.
                            </div>
                        </div>
                    </template>
                </ul>
            </div>
        </div>
    </div>

    <EditTransaction v-if="openEditTransaction" :transaction="openEditTransaction" @close="closeEditTransaction" />
</template>
