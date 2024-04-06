
<script setup lang="ts">
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import TableHeader from '@/Pages/Transaction/parts/TableHeader.vue';
import TableContent from '@/Pages/Transaction/parts/TableContent.vue';
import { TransactionCollection } from '@/types';

defineProps<{
    transactions: TransactionCollection;
}>();
</script>

<template>
    <Head title="Transactions" />

    <AuthenticatedLayout>
        <div class="relative shadow-md sm:rounded-lg">
            <TableHeader />
        </div>
        <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
            <TableContent :transactions="transactions"/>
        </div>
    </AuthenticatedLayout>
</template>