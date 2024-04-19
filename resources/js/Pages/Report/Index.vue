<script setup lang="ts">
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import Card from './Partials/Card.vue';
import Chart from 'chart.js/auto'
import VueDatePicker from '@vuepic/vue-datepicker';
import { Head, useForm } from '@inertiajs/vue3';
import { dark, activeTheme } from '@/themeVariables';
import { formatNumber } from '@/utils';
import { onMounted, ref } from 'vue';
import type { DatePickerInstance } from "@vuepic/vue-datepicker"

import '@vuepic/vue-datepicker/dist/main.css';
import '@/../css/datepicker.css';
import { onBeforeMount } from 'vue';
import dayjs from 'dayjs';

const props = defineProps<{
    expensePieData?: any;
    incomePieData?: any;
    expenseLineData?: any;
    period: any;
}>();

const datePeriod = ref({
    month: props.period.month - 1,
    year: props.period.year,
});

const datepicker = ref<DatePickerInstance>(null);

const darkMode = ref(false);

onBeforeMount(() => {
    darkMode.value = activeTheme.value === dark
})

const form = useForm({
    period : props.period.year + '-' + props.period.month,
})

const instaceExpensePie = ref(null) as any;

const instaceIncomePie = ref(null) as any;

const instanceLine = ref(null) as any;

const changePeriod = (modelData: any) => {

    let month = modelData.month + 1;

    month = month < 10 ? '0' + month : month;

    form.period = modelData.year + '-' + month;

    form.get(route('reports.index'), {
        preserveScroll: true,
        onFinish: () => {
            instaceExpensePie.value.destroy();
            instaceIncomePie.value.destroy();
            instanceLine.value.destroy();
        }
    });
}

const configExpensePie = ref({
    type: 'pie',
    data: props.expensePieData,
    options: {
        plugins: {
            tooltip: {
                callbacks: {
                    label: function(context:any) {
                        let label = context.dataset.label || '';

                        if (label) {
                            label += ': ';
                        }
                        if (context.parsed !== null) {
                            label += formatNumber(context.parsed);
                        }
                        return label;
                    }
                }
            }
        }
    }
});

const configIncomePie = ref({
    type: 'pie',
    data: props.incomePieData,
    options: {
        plugins: {
            tooltip: {
                callbacks: {
                    label: function(context:any) {
                        let label = context.dataset.label || '';

                        if (label) {
                            label += ': ';
                        }
                        if (context.parsed !== null) {
                            label += formatNumber(context.parsed);
                        }
                        return label;
                    }
                }
            }
        }
    }
});

const configExpenseLine = ref({
    type: 'line',
    data: props.expenseLineData,
    options: {
        plugins: {
            tooltip: {
                callbacks: {
                    label: function(context:any) {
                        let label = context.dataset.label || '';

                        if (label) {
                            label += ': ';
                        }
                        if (context.parsed.y !== null) {
                            label += formatNumber(context.parsed.y);
                        }
                        return label;
                    }
                }
            }
        }
    }
});

const expensePieChart = ref(null) as any;
const incomePieChart = ref(null) as any;
const expenseLineChart = ref(null) as any;

onMounted(() => {
    handlePieChartExpense();
    handlePieChartIncome();
    handleLineChartExpense();
});

const handlePieChartExpense = () => {
    instaceExpensePie.value = new Chart(
        expensePieChart.value,
        configExpensePie.value,
    );
}

const handlePieChartIncome = () => {
    instaceIncomePie.value = new Chart(
        incomePieChart.value,
        configIncomePie.value,
    );
}

const handleLineChartExpense = () => {
    instanceLine.value = new Chart(
        expenseLineChart.value,
        configExpenseLine.value,
    );
}
</script>

<template>
    <Head title="Reports" />

    <AuthenticatedLayout>
        <div class="container max-w-7xl mx-auto">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-y-2 lg:gap-4">
                <div class="grid col-span-2 gap-4 mb-2">
                    <div class="flex-col gap-2">

                        <div class="bg-component p-4 rounded-lg mb-5 border-color">
                            <h1 class="text-2xl font-extrabold dark:text-white">Report Analysis
                                <small class="ms-2 font-semibold text-gray-500 dark:text-gray-400">
                                    {{ dayjs().month(props.period.month-1).year(props.period.year).format('MMMM, YYYY')  }}
                                </small>
                            </h1>

                            <div class="mt-3">
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
                        </div>

                        <Card label="Expense & Income Flow">
                            <div class="py-5 w-11/12 mx-auto">
                                <canvas id="expenseLine" ref="expenseLineChart" ></canvas>
                            </div>
                        </Card>
                    </div>
                </div>
                <div class="grid gap-4">
                    <div>
                        <Card label="Expense Overview">
                            <div class="py-5 w-11/12 mx-auto">
                                <canvas id="expensePie" ref="expensePieChart" ></canvas>
                            </div>
                        </Card>
                    </div>
                    <div>
                        <Card label="Income Overview">
                            <div class="py-5 w-11/12 mx-auto">
                                <canvas id="incomePie" ref="incomePieChart" ></canvas>
                            </div>
                        </Card>

                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
