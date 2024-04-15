
<script setup lang="ts">
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import TableHeader from '@/Pages/Transaction/parts/TableHeader.vue';
import TableContent from '@/Pages/Transaction/parts/TableContent.vue';
import Pagination from '@/Pages/Transaction/parts/Pagination.vue';
import { TransactionCollection } from '@/types';

defineProps<{
    transactions: TransactionCollection;
    date_between: Array<String>;
}>();
</script>

<template>
    <Head title="Transactions" />

    <AuthenticatedLayout>
        <div class="relative shadow-sm sm:rounded-lg border dark:border-gray-600">
            <TableHeader :date_between="date_between"/>
        </div>

        <div class="flex flex-col items-center" v-if="transactions.meta.total">
            <span class="text-sm text-gray-700 dark:text-gray-400">
                Showing <span class="font-semibold text-gray-900 dark:text-white">{{ transactions.meta.from ?? 0 }}</span> to
                <span class="font-semibold text-gray-900 dark:text-white">{{ transactions.meta.to ?? 0 }}</span> of
                <span class="font-semibold text-gray-900 dark:text-white">{{ transactions.meta.total }}</span> Entries
            </span>
        </div>

        <div class="relative overflow-x-auto shadow-sm sm:rounded-lg border dark:border-gray-600">
            <TableContent :transactions="transactions"/>
        </div>

        <div class="flex w-full items-center justify-center">
            <Pagination :links="transactions.links" :meta="transactions.meta"/>
        </div>
    </AuthenticatedLayout>
</template>