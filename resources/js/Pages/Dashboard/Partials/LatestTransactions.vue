<script setup lang="ts">
import IconCaretUp from '@/Components/IconCaretUp.vue';
import IconCaretDown from '@/Components/IconCaretDown.vue';
import { Link } from '@inertiajs/vue3';
import Type from '@/Enums/TransactionType';
defineProps<{
    transactions: any;
}>();

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
</script>
<template>
    <div class="container mt-8 mx-auto md:px-6">

        <div class="w-full p-4 bg-white border border-gray-200 rounded-lg shadow sm:p-8 dark:bg-gray-800 dark:border-gray-700">
            <div class="flex items-center justify-between mb-4">
                <h5 class="text-xl font-bold leading-none text-gray-900 dark:text-white">Latest transaction</h5>
                <Link :href="route('transactions.index')" class="text-sm font-medium text-primary-600 hover:underline dark:text-primary-500">
                    View all
                </Link>
            </div>
            <div class="flow-root">
                <ul role="list" class="divide-y divide-gray-200 dark:divide-gray-700">
                    <template v-for="transaction in transactions">
                        <li class="py-3 sm:py-4 divide-gray-300">
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
                                    <p class="ms-10 text-sm text-gray-500 truncate dark:text-gray-400 font-normal">{{ transaction.description }}</p>
                                </div>
                                <div class="inline-flex items-center text-base font-semibold text-gray-900 dark:text-white">
                                    {{ formatNumber(transaction.amount) }}
                                </div>
                            </div>
                        </li>
                    </template>
                </ul>
            </div>
        </div>

    </div>
</template>