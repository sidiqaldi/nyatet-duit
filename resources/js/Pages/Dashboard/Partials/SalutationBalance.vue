<script setup lang="ts">
import { formatNumber } from '@/utils';

defineProps<{
    username: string;
    totalBalance: number;
}>();
</script>

<template>
    <div class="flex-none rounded-lg max-w-7xl mx-auto bg-gradient-to-b sm:p-5 from-transparent via-white from-10% to-white dark:from-transparent dark:to-gray-800">
        <div class="p-6 overflow-hidden rounded-lg">
            <div class="text-gray-900 dark:text-gray-100 ">Welcome <span class="font-bold">{{ username }}!</span></div>
            <div class="bg-gradient-to-r from-primary-600 via-indigo-400 to-blue-500 inline-block text-transparent bg-clip-text">Let's get started on your financial journey.</div>
        </div>

        <div class="w-full mt-5 lg:mt-0 p-4 bg-white border border-gray-200 rounded-lg shadow sm:p-8 dark:bg-gray-800 dark:border-gray-700">
            <h5 class="mb-4 text-xl font-medium text-gray-500 dark:text-gray-400">Your Balance</h5>
            <div class="flex items-baseline text-gray-900 dark:text-white">
                <span class="display-nominal text-2xl sm:text-2xl md:text-3xl font-extrabold">{{ formatNumber(totalBalance) }}</span>
            </div>
        </div>
    </div>
</template>