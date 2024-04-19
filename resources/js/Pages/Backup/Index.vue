<script setup lang="ts">
import Modal from '@/Components/Modal.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, useForm } from '@inertiajs/vue3';
import { ref, computed } from 'vue';
import VueDatePicker from '@vuepic/vue-datepicker';

import '@vuepic/vue-datepicker/dist/main.css';
import '@/../css/datepicker.css';

const modalExportOpen = ref(false);
const modalExportAllOpen = ref(false);
const modalImportPeriodOpen = ref(false);
const modalImportAllOpen = ref(false);
const darkMode = ref(false);

const inputPeriod = ref({
    month: new Date().getMonth(),
    year: new Date().getFullYear()
});

const formUpload = useForm({
    _method: 'put',
    file: null as any,
});

const exportUrl = computed(() => {
    let month = inputPeriod.value.month + 1;

    let stringMonth = month.toString();

    if (month < 10) {
        stringMonth = '0' + stringMonth;
    }

    let period = inputPeriod.value.year + '-' + stringMonth;

    return route('backups.show', period);
})

const updateValue = (e: Event) => {
    const target = e.target as HTMLInputElement;
    const files = target.files;

    if (!files || !files[0])
        return;

    formUpload.file = files[0];
};

const handleImportPeriode = () => {
    let month = inputPeriod.value.month + 1;

    let stringMonth = month.toString();

    if (month < 10) {
        stringMonth = '0' + stringMonth;
    }

    let period = inputPeriod.value.year + '-' + stringMonth;

    formUpload.post(route('backups.update', period), {
        preserveScroll: true,
        onSuccess: () => {
            formUpload.reset();
            modalImportPeriodOpen.value = false;
        }
    });
}

const handleImportAll = () => {
    formUpload.post(route('backups.update', 'all'), {
        preserveScroll: true,
        onSuccess: () => {
            formUpload.reset();
            modalImportAllOpen.value = false;
        }
    });
}

</script>

<template>
    <Head title="Backups" />

    <AuthenticatedLayout>
        <div class="container max-w-7xl mx-auto">
            <div class="w-full pt-5 px-5 border-b text-lg font-semibold text-left rtl:text-right text-gray-900 bg-white dark:text-white dark:bg-gray-800">
                Backup Management
                <p class="mt-1 max-w-4xl text-sm font-normal text-gray-500 dark:text-gray-400 mb-5">
                    Take control of your financial data with our Backup and Restore feature! Easily export and import your transactions using .xlsx files, ensuring your records are safe and accessible whenever you need them.
                </p>
            </div>

            <div class="w-full p-5 border-b text-lg font-semibold text-left rtl:text-right text-gray-900 bg-white dark:text-white dark:bg-gray-800">
                Backup Your Transactions
                <p class="mt-1 max-w-4xl text-sm font-normal text-gray-500 dark:text-gray-400 mb-5">
                    Export your transaction data to a .xlsx file for safekeeping. Simply select the desired month and click "Export" to download your transactions. Keep your records organized and secure, knowing that your financial history is backed up and easily retrievable.
                </p>
                <div class="flex gap-2">
                    <PrimaryButton type="button" @click="modalExportOpen = true">
                        <svg class="size-4 -ms-1 me-2" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                            <path fill-rule="evenodd" d="M9 7V2.221a2 2 0 0 0-.5.365L4.586 6.5a2 2 0 0 0-.365.5H9Zm2 0V2h7a2 2 0 0 1 2 2v9.293l-2-2a1 1 0 0 0-1.414 1.414l.293.293h-6.586a1 1 0 1 0 0 2h6.586l-.293.293A1 1 0 0 0 18 16.707l2-2V20a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V9h5a2 2 0 0 0 2-2Z" clip-rule="evenodd"/>
                        </svg>
                        By Period
                    </PrimaryButton>

                    <PrimaryButton type="button" @click="modalExportAllOpen = true">
                        <svg class="size-4 -ms-1 me-2" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                            <path fill-rule="evenodd" d="M9 7V2.221a2 2 0 0 0-.5.365L4.586 6.5a2 2 0 0 0-.365.5H9Zm2 0V2h7a2 2 0 0 1 2 2v9.293l-2-2a1 1 0 0 0-1.414 1.414l.293.293h-6.586a1 1 0 1 0 0 2h6.586l-.293.293A1 1 0 0 0 18 16.707l2-2V20a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V9h5a2 2 0 0 0 2-2Z" clip-rule="evenodd"/>
                        </svg>
                        Export All
                    </PrimaryButton>
                </div>
            </div>

            <div class="w-full p-5 border-b px-5 text-lg font-semibold text-left rtl:text-right text-gray-900 bg-white dark:text-white dark:bg-gray-800">
                Restore Transactions:
                <p class="mt-1 max-w-4xl text-sm font-normal text-gray-500 dark:text-gray-400 mb-5">
                    Import your previously exported .xlsx file to restore your transaction data. Whether you're switching devices or need to recover lost data, our import feature makes it simple to restore your transactions and pick up right where you left off.                    </p>
                <div class="flex gap-2">
                    <PrimaryButton type="button" @click="modalImportPeriodOpen = true">
                        <svg class="size-4 -ms-1 me-2" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                            <path fill-rule="evenodd" d="M9 7V2.221a2 2 0 0 0-.5.365L4.586 6.5a2 2 0 0 0-.365.5H9Zm2 0V2h7a2 2 0 0 1 2 2v16a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2v-5h7.586l-.293.293a1 1 0 0 0 1.414 1.414l2-2a1 1 0 0 0 0-1.414l-2-2a1 1 0 0 0-1.414 1.414l.293.293H4V9h5a2 2 0 0 0 2-2Z" clip-rule="evenodd"/>
                        </svg>
                        By Period
                    </PrimaryButton>

                    <PrimaryButton type="button" @click="modalImportAllOpen = true">
                        <svg class="size-4 -ms-1 me-2" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                            <path fill-rule="evenodd" d="M9 7V2.221a2 2 0 0 0-.5.365L4.586 6.5a2 2 0 0 0-.365.5H9Zm2 0V2h7a2 2 0 0 1 2 2v16a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2v-5h7.586l-.293.293a1 1 0 0 0 1.414 1.414l2-2a1 1 0 0 0 0-1.414l-2-2a1 1 0 0 0-1.414 1.414l.293.293H4V9h5a2 2 0 0 0 2-2Z" clip-rule="evenodd"/>
                        </svg>
                        Import All
                    </PrimaryButton>
                </div>
            </div>
        </div>

        <Modal :show="modalExportOpen" @close="modalExportOpen = false">
            <div class="py-8 px-6 min-h-[500px]">
                <form method="post" class="mx-auto">
                    <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                        Export Transaction by Period
                    </h2>

                    <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                        Please note that exporting or importing all your transaction data may take some time, depending on the number of records in your account.
                    </p>

                    <p class="mt-5 mb-2 text-sm font-bold text-gray-600 dark:text-gray-300">
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

                    <blockquote class="p-4 my-4 border-s-4 border-gray-300 bg-gray-50 dark:border-gray-500 dark:bg-gray-600">
                        <p class="text-sm leading-relaxed text-gray-900 dark:text-white">When exporting your transaction data, the process may require additional time to compile and organize all your records into a downloadable .xlsx file. Please be patient while the export completes.</p>
                    </blockquote>

                    <div class="mt-6 flex gap-2 justify-end">
                        <SecondaryButton @click="modalExportOpen = false"> Cancel </SecondaryButton>

                        <a :href="exportUrl" class="primary-button" @click.capture="modalExportOpen = false">Export</a>
                    </div>
                </form>
            </div>
        </Modal>

        <Modal :show="modalExportAllOpen" @close="modalExportAllOpen = false">
            <div class="py-8 px-6">
                <form method="post" class="mx-auto" enctype="multipart/form-data">
                    <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                        Export All Transaction
                    </h2>

                    <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                        Please note that exporting or importing all your transaction data may take some time, depending on the number of records in your account.
                    </p>

                    <blockquote class="p-4 my-4 border-s-4 border-gray-300 bg-gray-50 dark:border-gray-500 dark:bg-gray-600">
                        <p class="text-sm leading-relaxed text-gray-900 dark:text-white">When exporting your transaction data, the process may require additional time to compile and organize all your records into a downloadable .xlsx file. Please be patient while the export completes.</p>
                    </blockquote>

                    <div class="mt-6 flex gap-2 justify-end">
                        <SecondaryButton @click="modalExportAllOpen = false"> Cancel </SecondaryButton>

                        <a :href="route('backups.show', 'all')" class="primary-button" @click.capture="modalExportAllOpen = false">Procced</a>
                    </div>
                </form>
            </div>
        </Modal>

        <Modal :show="modalImportPeriodOpen" @close="modalImportPeriodOpen = false">
            <div class="py-8 px-6">
                <form method="post" @submit.prevent="handleImportPeriode" class="mx-auto" enctype="multipart/form-data">
                    <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                        Restoring Data: Proceed with Caution
                    </h2>

                    <p class="mt-1 text-xs text-red-600 dark:text-red-400">
                        Please note that restoring data will clean up your current data and replace it with the data from the source file. <br/> This action cannot be undone.
                    </p>


                    <div class="mt-3">
                        <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white" for="datepicker">Please select transaction period</label>

                        <VueDatePicker
                            id="datepicker"
                            :dark="darkMode"
                            v-model="inputPeriod"
                            month-picker
                            auto-apply
                        >
                            <template #clear-icon></template>
                        </VueDatePicker>
                    </div>

                    <div class="my-3">
                        <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white" for="file_input_period">Upload file</label>
                        <input
                            class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400"
                            aria-describedby="file_input_help"
                            id="file_input_period"
                            type="file"
                            @input="updateValue"
                            accept="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet"
                        >
                        <p class="mt-1 text-sm text-gray-500 dark:text-gray-300" id="file_input_help">XLSX.</p>
                        <progress v-if="formUpload.progress" :value="formUpload.progress.percentage" max="100">
                            {{ formUpload.progress.percentage }}%
                        </progress>
                    </div>

                    <p class="mt-1 text-xs font-bold text-gray-800 dark:text-gray-300">
                        Important Instructions:
                    </p>
                    <p class="mt-1 text-xs text-gray-600 dark:text-gray-400">
                        Before proceeding with the data restoration process, please review the following instructions carefully:
                    </p>

                    <p class="mt-1 text-xs text-gray-600 dark:text-gray-400 prose">

                        When exporting all your transaction data, the process may require additional time to compile and organize all your records into a downloadable .xlsx file. Please be patient while the export completes.
                        <ul>
                            <li><b>Backup Your Current Data:</b> Before initiating the data restoration, we strongly recommend creating a backup of your current data. This will allow you to revert to your existing data in case you encounter any issues during the restoration process.</li>
                            <li><b>Verify Source File:</b> Ensure that the source file you are importing contains the correct and up-to-date data that you intend to restore to your account. Any discrepancies or errors in the source file may result in data loss or inaccuracies.</li>
                            <li><b>Proceed with Caution:</b> Once you have verified the source file and backed up your current data, proceed with caution to initiate the data restoration process. Be aware that this action will overwrite your existing data with the data from the source file.</li>
                        </ul>
                    </p>



                    <div class="mt-6 flex gap-2 justify-end">
                        <SecondaryButton @click="modalImportPeriodOpen = false"> Cancel </SecondaryButton>

                        <PrimaryButton type="submit">Procced</PrimaryButton>
                    </div>
                </form>
            </div>
        </Modal>

        <Modal :show="modalImportAllOpen" @close="modalImportAllOpen = false">
            <div class="py-8 px-6">
                <form method="post" @submit.prevent="handleImportAll" class="mx-auto" enctype="multipart/form-data">
                    <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                        Restoring All Data: Proceed with Caution
                    </h2>

                    <p class="mt-1 text-xs text-red-600 dark:text-red-400">
                        Please note that restoring data will clean up your current data and replace it with the data from the source file. <br/> This action cannot be undone.
                    </p>

                    <div class="my-3">
                        <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white" for="file_input_period">Upload file</label>
                        <input
                            class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400"
                            aria-describedby="file_input_help"
                            id="file_input_period"
                            type="file"
                            @input="updateValue"
                            accept="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet"
                        >
                        <p class="mt-1 text-sm text-gray-500 dark:text-gray-300" id="file_input_help">XLSX.</p>
                    </div>

                    <p class="mt-1 text-xs font-bold text-gray-800 dark:text-gray-300">
                        Important Instructions:
                    </p>
                    <p class="mt-1 text-xs text-gray-600 dark:text-gray-400">
                        Before proceeding with the data restoration process, please review the following instructions carefully:
                    </p>

                    <p class="mt-1 text-xs text-gray-600 dark:text-gray-400 prose">

                        When exporting all your transaction data, the process may require additional time to compile and organize all your records into a downloadable .xlsx file. Please be patient while the export completes.
                        <ul>
                            <li><b>Backup Your Current Data:</b> Before initiating the data restoration, we strongly recommend creating a backup of your current data. This will allow you to revert to your existing data in case you encounter any issues during the restoration process.</li>
                            <li><b>Verify Source File:</b> Ensure that the source file you are importing contains the correct and up-to-date data that you intend to restore to your account. Any discrepancies or errors in the source file may result in data loss or inaccuracies.</li>
                            <li><b>Proceed with Caution:</b> Once you have verified the source file and backed up your current data, proceed with caution to initiate the data restoration process. Be aware that this action will overwrite your existing data with the data from the source file.</li>
                        </ul>
                    </p>

                    <div class="mt-6 flex gap-2 justify-end">
                        <SecondaryButton @click="modalImportAllOpen = false"> Cancel </SecondaryButton>

                        <PrimaryButton type="submit">Procced</PrimaryButton>
                    </div>
                </form>
            </div>
        </Modal>



    </AuthenticatedLayout>
</template>
