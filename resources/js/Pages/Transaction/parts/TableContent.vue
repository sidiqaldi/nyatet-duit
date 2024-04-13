<script setup lang="ts">
import { TransactionCollection } from '@/types';
import Type from '@/Enums/TransactionType';
import IconCaretUp from '@/Components/IconCaretUp.vue';
import IconCaretDown from '@/Components/IconCaretDown.vue';
import IconVerDots from '@/Components/IconVerDots.vue';

defineProps<{
    transactions: TransactionCollection;
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
    <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
            <tr>
                <th scope="col" class="px-3 py-4">
                    Date
                </th>
                <th scope="col" class="px-3 py-4">
                    Category
                </th>
                <th scope="col" class="px-3 py-4">
                    Amount
                </th>
                <th scope="col" class="px-3 py-4">
                    Description
                </th>
                <th scope="col" class="sr-only" >
                    Action
                </th>
            </tr>
        </thead>
        <tbody>
            <template v-for="transaction in transactions.data">
                <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                    <td class="px-3 py-3">
                        {{ transaction.date }}
                    </td>
                    <td class="px-3 py-3">
                        {{ transaction.category }}
                    </td>
                    <td class="px-3 py-3">
                        <span class="flex gap-1 items-center">
                            <template v-if="transaction.type_id === Type.Income">
                                <IconCaretUp class="h-3 text-emerald-600"/>
                                <div class="text-emerald-600 text-xs">{{ formatNumber(transaction.amount) }}</div>
                            </template>
                            <template v-else>
                                <IconCaretDown class="h-3 text-red-800"/>
                                <div class="text-red-800 text-xs">{{ formatNumber(transaction.amount) }}</div>
                            </template>
                        </span>
                    </td>
                    <td class="px-3 py-3">
                        {{ transaction.description }}
                    </td>
                    <td class="flex items-center justify-end px-3 py-3">
                        <IconVerDots />
                    </td>
                </tr>
            </template>
            <template v-if="transactions.meta.total == 0">
                <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                    <td class="px-3 py-3 text-center text-gray-400" colspan="4">
                        Oops! It looks like there are no transactions recorded for the selected period. Start adding transactions to track your finances.
                    </td>
                </tr>
            </template>
        </tbody>
    </table>
</template>