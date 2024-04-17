<script setup>
import AddTransaction from '@/Components/AddTransaction.vue';
import IconTransaction from '@/Components/IconTransaction.vue';
import IconWallet from '@/Components/IconWallet.vue';
import IconTag from '@/Components/IconTag.vue';
import NavBottomLink from '@/Components/NavBottomLink.vue';
</script>
<template>
    <div class="fixed z-50 w-full h-16 max-w-lg -translate-x-1/2 bg-white border border-gray-200 rounded-full bottom-4 left-1/2 dark:bg-gray-700 dark:border-gray-600">
        <div class="grid h-full max-w-lg grid-cols-5 mx-auto">
            <NavBottomLink position="left" label="Wallet" :href="route('dashboard')">
                <IconWallet class="size-5 icon-bottom"/>
            </NavBottomLink>
            <NavBottomLink position="center" label="Transactions" :href="route('transactions.index')">
                <IconTransaction class="icon-bottom" />
            </NavBottomLink>
            <AddTransaction />
            <div id="tooltip-new" role="tooltip" class="absolute z-10 invisible inline-block px-3 py-2 text-sm font-medium text-white transition-opacity duration-300 bg-gray-900 rounded-lg shadow-sm opacity-0 tooltip dark:bg-gray-700">
                Create new item
                <div class="tooltip-arrow" data-popper-arrow></div>
            </div>
            <NavBottomLink position="center" label="Categories" :href="route('categories.index')">
                <IconTag class="icon-bottom" />
            </NavBottomLink>
            <button data-tooltip-target="tooltip-profile" type="button" class="inline-flex flex-col items-center justify-center px-5 rounded-e-full hover:bg-gray-50 dark:hover:bg-gray-800 group">
                <svg class="icon-bottom" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M10 0a10 10 0 1 0 10 10A10.011 10.011 0 0 0 10 0Zm0 5a3 3 0 1 1 0 6 3 3 0 0 1 0-6Zm0 13a8.949 8.949 0 0 1-4.951-1.488A3.987 3.987 0 0 1 9 13h2a3.987 3.987 0 0 1 3.951 3.512A8.949 8.949 0 0 1 10 18Z"/>
                </svg>
                <span class="sr-only">Profile</span>
            </button>
            <div id="tooltip-profile" role="tooltip" class="absolute z-10 invisible inline-block px-3 py-2 text-sm font-medium text-white transition-opacity duration-300 bg-gray-900 rounded-lg shadow-sm opacity-0 tooltip dark:bg-gray-700">
                Profile
                <div class="tooltip-arrow" data-popper-arrow></div>
            </div>
        </div>
    </div>
</template>