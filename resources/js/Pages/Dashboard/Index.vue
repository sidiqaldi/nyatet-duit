<script setup lang="ts">
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import SalutationBalance from './Partials/SalutationBalance.vue';
import RecordTransactions from './Partials/RecordTransactions.vue';
import { Head } from '@inertiajs/vue3';

defineProps<{
    totalBalance: number,
    totalExpense: number,
    totalIncome: number,
    balancePeriod: number,
    transactions: any,
    period: any,
}>();


</script>

<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">Dashboard</h2>
        </template>

        <div class="lg:flex">

            <SalutationBalance
                :total-balance="totalBalance"
                :username="$page.props.auth.user.name"
            />

            <RecordTransactions
                :transactions="transactions"
                :total-expense="totalExpense"
                :total-income="totalIncome"
                :balance-period="balancePeriod"
                :period="period"
            />
        </div>
    </AuthenticatedLayout>
</template>
