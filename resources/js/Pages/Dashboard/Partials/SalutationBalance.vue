<script setup lang="ts">
import IconCaretUp from '@/Components/IconCaretUp.vue';
import IconCaretDown from '@/Components/IconCaretDown.vue';

defineProps<{
    username: string;
    totalBalance: number;
    totalExpense: number;
    totalIncome: number;
}>();

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
</script>

<template>
    <div class="rounded-lg max-w-7xl mx-auto bg-gradient-to-b sm:p-5 from-gray-50 to-white dark:from-gray-900 dark:to-gray-800">
        <div class="p-6 overflow-hidden rounded-lg">
            <div class="text-gray-900 dark:text-gray-100 ">Welcome <span class="font-bold">{{ username }}!</span></div>
            <div class="bg-gradient-to-r from-primary-600 via-indigo-400 to-blue-500 inline-block text-transparent bg-clip-text">Let's get started on your financial journey.</div>
        </div>

        <div class="w-full mt-5 p-4 bg-white border border-gray-200 rounded-lg shadow sm:p-8 dark:bg-gray-800 dark:border-gray-700">
            <h5 class="mb-4 text-xl font-medium text-gray-500 dark:text-gray-400">Your Balance</h5>
            <div class="flex items-baseline text-gray-900 dark:text-white">
                <span class="text-2xl sm:text-3xl md:text-5xl font-extrabold tracking-tight">{{ formatNumber(totalBalance) }}</span>
            </div>


            <h4 class="mt-10 font-thin text-gray-500 dark:text-gray-400">Income & Expense this month</h4>
            <div role="list" class="flex my-5 justify-between max-w-sm">
                <div class="flex items-center align-middle">
                    <IconCaretUp class="h-3 text-primary-500 dark:text-primary-400"/>

                    <span class="text-base font-normal leading-tight text-gray-500 dark:text-gray-400 sm:ms-3">{{ formatNumber(totalIncome) }}</span>
                </div>
                <div class="flex items-center align-middle">
                    <IconCaretDown class="h-3 text-red-600 dark:text-red-500"/>

                    <span class="text-base font-normal leading-tight text-gray-500 dark:text-gray-400 sm:ms-3">{{ formatNumber(totalExpense) }}</span>
                </div>
            </div>
        </div>
    </div>
</template>