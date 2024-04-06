<script setup lang="ts">
import { Link } from '@inertiajs/vue3';

defineProps<{
    href: string;
    position: string;
    label: string;
}>();
</script>
<template>
    <Link v-if="position === 'left'"
        :data-tooltip-target="'tooltip-' + label"
        :href="href"
        class="inline-flex flex-col items-center justify-center px-5 rounded-s-full hover:bg-gray-50 dark:hover:bg-gray-800 group"
    >
        <slot />
        <span class="sr-only">{{ label }}</span>
    </Link>

    <Link v-else
        :data-tooltip-target="'tooltip-' + label"
        :href="href"
        class="inline-flex flex-col items-center justify-center px-5 hover:bg-gray-50 dark:hover:bg-gray-800 group"
    >
        <slot />
        <span class="sr-only">{{ label }}</span>
    </Link>

    <div :id="'tooltip-' + label" role="tooltip" class="absolute z-10 invisible inline-block px-3 py-2 text-sm font-medium text-white transition-opacity duration-300 bg-gray-900 rounded-lg shadow-sm opacity-0 tooltip dark:bg-gray-700">
        {{ label }}
        <div class="tooltip-arrow" data-popper-arrow></div>
    </div>
</template>