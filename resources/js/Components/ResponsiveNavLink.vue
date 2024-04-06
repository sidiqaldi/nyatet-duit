<script setup lang="ts">
import { Link } from '@inertiajs/vue3';

defineProps<{
    href: string;
}>();

</script>

<template>
    <Link :href="href" class="block w-full text-start py-2 px-4 text-sm hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">
        <slot />
    </Link>
</template>
