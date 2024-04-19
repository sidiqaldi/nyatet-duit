<script setup lang="ts">
import IconCaretUp from '@/Components/IconCaretUp.vue';
import IconCaretDown from '@/Components/IconCaretDown.vue';
import IconWallet from '@/Components/IconWallet.vue';
import { formatNumber } from '@/utils';
import dayjs from 'dayjs';
import { onMounted } from 'vue';
import { ref } from 'vue';
import { onUpdated } from 'vue';

const props = defineProps<{
    totalIncome: any;
    totalExpense: any;
    balancePeriod: any;
    datePeriod: any;
}>()

const displayDate = ref('');

onMounted(() => {
    displayDate.value = dayjs().month(props.datePeriod.month).year(props.datePeriod.year).format('MMMM, YYYY')
})

onUpdated(() => {
    displayDate.value = dayjs().month(props.datePeriod.month).year(props.datePeriod.year).format('MMMM, YYYY')
})

</script>
<template>
    <div class="mb-5 px-4 lg:flex lg:gap-2 lg:justify-between border-b">
        <div>
            <div class="font-thin text-gray-500 dark:text-gray-400">Income & Expense <span class="font-normal text-primary-600 dark:text-primary-500">{{ displayDate }}</span></div>
            <div role="list" class="flex flex-col sm:flex-row my-5 justify-center lg:justify-start gap-5 lg:gap-2">
                <div class="flex items-center align-middle">
                    <IconCaretUp class="h-3 text-primary-500 dark:text-primary-400"/>
                    <span class="display-nominal text-base font-normal leading-tight text-gray-500 dark:text-gray-400 ">
                        {{ formatNumber(totalIncome) }}
                    </span>
                </div>
                <div class="flex items-center align-middle">
                    <IconCaretDown class="h-3 text-red-600 dark:text-red-500"/>
                    <span class="display-nominal text-base font-normal leading-tight text-gray-500 dark:text-gray-400 ">
                        {{ formatNumber(totalExpense) }}
                    </span>
                </div>
            </div>
        </div>
        <div class="items-center align-middle mb-5">
            <div class="font-thin mb-4 text-gray-500 dark:text-gray-400">Balance left</div>
            <div class="flex items-center align-middle justify-start sm:justify-center">
                <IconWallet class="h-3 text-gray-500 dark:text-gray-400"/>
                <div class="display-nominal text-base font-normal leading-tight text-gray-500 dark:text-gray-400 ">{{ formatNumber(balancePeriod) }}</div>
            </div>
        </div>
    </div>
</template>