<script setup lang="ts">
defineProps<{
    label: string;
}>()
</script>

<template>
    <div class="w-full bg-component border-color rounded-lg shadow p-4 md:p-6">

        <div class="flex justify-between items-start w-full">
            <div class="flex-col items-center">
                <div class="flex items-center mb-1">
                    <h5 class="text-xl font-bold leading-none text-gray-900 dark:text-white me-1">{{ label }}</h5>
                </div>
            </div>
        </div>

        <slot />

    </div>

</template>