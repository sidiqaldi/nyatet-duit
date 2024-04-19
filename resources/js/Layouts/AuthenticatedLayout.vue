<script setup lang="ts">
import { initFlowbite } from 'flowbite'
import NavBar from '@/Components/NavBar.vue';
import NavBottom from '@/Components/NavBottom.vue';
import { onMounted } from 'vue';
import { useCategoriesStore } from '@/store';
import { usePage } from '@inertiajs/vue3';

const categoryStore = useCategoriesStore()

onMounted(() => {
    initFlowbite();

    categoryStore.init(usePage().props.auth.categories)
})

</script>

<template>
    <div class="antialiased">
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
