<script setup lang="ts">
import ApplicationLogo from '@/Components/ApplicationLogo.vue';
</script>

<template>
    <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gray-50 dark:bg-gray-900">
        <div>
            <a href="/" class="flex flex-col items-center">
                <ApplicationLogo class="size-16 fill-current text-gray-500" />
                <span class="font-semibold p-1 dark:text-white">NyatetDuit</span>
            </a>
        </div>

        <div
            class="w-full sm:max-w-md mt-6 px-6 py-20 bg-white dark:bg-gray-800 shadow-md overflow-hidden sm:rounded-lg"
        >
            <slot />
        </div>
    </div>
</template>
