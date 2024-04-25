<script setup>
import AddTransaction from '@/Components/AddTransaction.vue';
import IconPieChart from '@/Components/IconPieChart.vue';
import IconWallet from '@/Components/IconWallet.vue';
import IconCalendar from '@/Components/IconCalendar.vue';
import IconTag from '@/Components/IconTag.vue';
import NavBottomLink from '@/Components/NavBottomLink.vue';
</script>
<template>
    <div class="fixed z-50 w-full h-16 max-w-lg -translate-x-1/2 bg-white border border-gray-200 rounded-full bottom-4 left-1/2 dark:bg-gray-700 dark:border-gray-600">
        <div class="grid h-full max-w-lg grid-cols-5 mx-auto">
            <NavBottomLink position="left" label="Transaction Records" :href="route('dashboard')">
                <IconWallet class="size-5 icon-bottom"/>
            </NavBottomLink>

            <NavBottomLink position="center" label="Reports" :href="route('reports.index')">
                <IconPieChart class="icon-bottom" />
            </NavBottomLink>

            <AddTransaction />
            <div id="tooltip-new" role="tooltip" class="absolute z-10 invisible inline-block px-3 py-2 text-sm font-medium text-white transition-opacity duration-300 bg-gray-900 rounded-lg shadow-sm opacity-0 tooltip dark:bg-gray-700">
                Insert New Record
                <div class="tooltip-arrow" data-popper-arrow></div>
            </div>

            <NavBottomLink position="center" label="Categories" :href="route('categories.index')">
                <IconTag class="icon-bottom" />
            </NavBottomLink>

            <NavBottomLink position="right" label="Budgets" :href="route('budgets.index')">
                <IconCalendar class="icon-bottom" />
            </NavBottomLink>
        </div>
    </div>
</template>