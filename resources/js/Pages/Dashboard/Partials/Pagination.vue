<script setup lang="ts">
import { Link } from '@inertiajs/vue3';

defineProps<{
    transactions: any;
}>();
</script>
<template>
    <div v-if="transactions.meta.total" class="flex justify-between items-center px-4 py-2 mb-2 bg-gray-100 rounded dark:bg-gray-700">
        <div class="text-sm text-gray-700 dark:text-gray-400">
            Showing <span class="font-semibold text-gray-900 dark:text-white">{{ transactions.meta.from }}</span> to
            <span class="font-semibold text-gray-900 dark:text-white">{{ transactions.meta.to }}</span> of
            <span class="font-semibold text-gray-900 dark:text-white">{{ transactions.meta.total }}</span> Entries
        </div>
        <div class="inline-flex xs:mt-0">
            <Link
                as="button"
                v-if="transactions.links.prev"
                :href="transactions.links.prev"
                preserve-state
                preserve-scroll
                class="flex items-center justify-center px-3 py-1 text-sm font-medium text-white bg-gray-400 rounded-s hover:bg-gray-600 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-600 dark:hover:text-white"
            >
                Prev
            </Link>
            <button v-else disabled class="flex items-center justify-center px-3 py-1 text-sm font-medium text-gray-300 bg-gray-400 rounded-s dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400">
                Prev
            </button>
            <Link
                as="button"
                v-if="transactions.links.next"
                :href="transactions.links.next"
                preserve-state
                preserve-scroll
                class="flex items-center justify-center px-3 py-1 text-sm font-medium text-white bg-gray-400 border-0 border-s border-gray-300 rounded-e hover:bg-gray-600 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-600 dark:hover:text-white"
            >
                Next
            </Link>
            <button v-else disabled class="flex items-center justify-center px-3 py-1 text-sm font-medium text-gray-300 bg-gray-400 border-0 border-s border-gray-300 rounded-e dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400">
                Next
            </button>
        </div>
    </div>
</template>