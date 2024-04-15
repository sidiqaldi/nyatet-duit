<script setup lang="ts">
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';

defineProps<{
    total_balance: number,
    news: any,
}>();

const formatNumber = (number: number|null): string => {
    if (number === null) {
        number = 0;
    }
    let currency = new Intl.NumberFormat('id-ID', {
        style: 'currency',
        currency: 'IDR',
    });
    return currency.format(number);
}
</script>

<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">Dashboard</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="p-6 bg-white dark:bg-gray-800 overflow-hidden shadow-sm rounded-lg">
                    <div class="text-gray-900 dark:text-gray-100 ">Welcome <span class="font-bold">{{ $page.props.auth.user.name }}!</span></div>
                    <div class="text-gray-900 dark:text-gray-100 font-thin">Let's get started on your financial journey.</div>
                </div>
            </div>

            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="w-full mt-5 p-4 bg-white border border-gray-200 rounded-lg shadow sm:p-8 dark:bg-gray-800 dark:border-gray-700">
                    <h5 class="mb-4 text-xl font-medium text-gray-500 dark:text-gray-400">Your Balance</h5>
                    <div class="flex items-baseline text-gray-900 dark:text-white">
                        <span class="text-5xl font-extrabold tracking-tight">{{ formatNumber(total_balance) }}</span>
                    </div>
                    <ul role="list" class="space-y-5 my-5">
                        <li class="flex items-center">
                            <svg class="flex-shrink-0 w-4 h-4 text-blue-700 dark:text-blue-500" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5Zm3.707 8.207-4 4a1 1 0 0 1-1.414 0l-2-2a1 1 0 0 1 1.414-1.414L9 10.586l3.293-3.293a1 1 0 0 1 1.414 1.414Z"/>
                            </svg>
                            <span class="text-base font-normal leading-tight text-gray-500 dark:text-gray-400 ms-3">2 team members</span>
                        </li>
                        <li class="flex">
                            <svg class="flex-shrink-0 w-4 h-4 text-blue-700 dark:text-blue-500" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5Zm3.707 8.207-4 4a1 1 0 0 1-1.414 0l-2-2a1 1 0 0 1 1.414-1.414L9 10.586l3.293-3.293a1 1 0 0 1 1.414 1.414Z"/>
                            </svg>
                            <span class="text-base font-normal leading-tight text-gray-500 dark:text-gray-400 ms-3">20GB Cloud storage</span>
                        </li>
                    </ul>
                </div>
            </div>

            <!-- Container for demo purpose -->
            <div class="container my-24 mx-auto md:px-6">
                <!-- Section: Design Block -->
                <section class="mb-32">
                    <h2 class="mb-12 text-center text-3xl font-bold dark:text-white">Latest articles</h2>

                    <div class="grid gap-3 lg:grid-cols-3">
                        <div v-for="newsItem in news.results"
                            class="zoom relative overflow-hidden rounded-lg bg-cover bg-no-repeat shadow-lg dark:shadow-black/20"
                            data-te-ripple-init
                            data-te-ripple-color="light"
                        >
                            <img
                                :src="newsItem.image_url"
                                class="w-full align-middle transition duration-300 ease-linear"
                            />
                            <a target="_blank" :href="newsItem.link">
                                <div
                                    class="absolute top-0 right-0 bottom-0 left-0 h-full w-full overflow-hidden bg-fixed transition duration-300 ease-in-out hover:bg-[hsla(0,0%,99%,0.15)]">
                                </div>
                                <div class="flex flex-col p-2 justify-between dark:text-white">
                                    <div class="mb-3 text-sm font-bold text-wrap">{{ newsItem.title }}</div>

                                    <div class="text-xs line-clamp-2">
                                        {{ newsItem.description }}
                                    </div>
                                    <div>
                                        <small>Published {{ newsItem.pubDate }}<br /> source: {{ newsItem.source_id }}</small>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>
                </section>
                <!-- Section: Design Block -->
            </div>
            <!-- Container for demo purpose -->
        </div>
    </AuthenticatedLayout>
</template>
