<script setup lang="ts">
import Modal from '@/Components/Modal.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, router } from '@inertiajs/vue3';
import { ref, computed } from 'vue';
import VueDatePicker from '@vuepic/vue-datepicker';
import { dark, activeTheme } from '@/themeVariables';

import '@vuepic/vue-datepicker/dist/main.css';
import '@/../css/datepicker.css';

const modalExportOpen = ref(false);
const darkMode = ref(false);

const inputPeriod = ref({
    month: new Date().getMonth(),
    year: new Date().getFullYear()
});

const exportUrl = computed(() => {
    let month = inputPeriod.value.month + 1;

    let stringMonth = month.toString();

    if (month < 10) {
        stringMonth = '0' + stringMonth;
    }

    let period = inputPeriod.value.year + '-' + stringMonth;

    console.log(period);

    return route('backups.show', period);
})

</script>

<template>
    <Head title="Backups" />

    <AuthenticatedLayout>
        <div class="container max-w-7xl mx-auto">
            <div class="w-full p-5 text-lg font-semibold text-left rtl:text-right text-gray-900 bg-white dark:text-white dark:bg-gray-800">
                <div class="mb-4">
                    Backup Management
                    <p class="mt-1 max-w-4xl text-sm font-normal text-gray-500 dark:text-gray-400 mb-5">
                        Take control of your financial data with our Backup and Restore feature! Easily export and import your transactions using .xlsx files, ensuring your records are safe and accessible whenever you need them.
                    </p>
                    <div class="flex gap-2">
                        <PrimaryButton type="button" @click="modalExportOpen = true">Export</PrimaryButton>

                        <PrimaryButton>Import</PrimaryButton>
                    </div>
                </div>
            </div>
        </div>

        <Modal :show="modalExportOpen" @close="modalExportOpen = false">
            <div class="py-8 px-6 min-h-[500px]">
                <form method="post" class="mx-auto">
                    <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                        Export Transaction
                    </h2>

                    <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                        Please select transaction period
                    </p>

                    <VueDatePicker
                        :dark="darkMode"
                        v-model="inputPeriod"
                        month-picker
                        auto-apply
                    >
                        <template #clear-icon></template>
                    </VueDatePicker>

                    <a :href="exportUrl" type="submit" @click.capture="modalExportOpen = false">Export</a>
                </form>
            </div>
        </Modal>
    </AuthenticatedLayout>
</template>
