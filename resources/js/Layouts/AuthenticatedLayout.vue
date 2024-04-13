<script setup lang="ts">
import { ref } from 'vue';
import { initFlowbite } from 'flowbite'
import NavBar from '@/Components/NavBar.vue';
import NavBottom from '@/Components/NavBottom.vue';
import { onMounted } from 'vue';

const showingNavigationDropdown = ref(false);

onMounted(() => {
    initFlowbite();
})
</script>

<template>
    <div class="antialiased bg-gray-50 dark:bg-gray-900">
        <NavBar />

        <main class="p-4 min-h-screen h-auto pt-20 pb-24">
            <div>
                <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
                    <slot />
                </div>
            </div>
        </main>

        <NavBottom />
    </div>
</template>
