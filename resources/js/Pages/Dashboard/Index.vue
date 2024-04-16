<script setup lang="ts">
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import SalutationBalance from './Partials/SalutationBalance.vue';
import LatestTransactions from './Partials/LatestTransactions.vue';
import { Head } from '@inertiajs/vue3';

defineProps<{
    totalBalance: number,
    totalExpense: number,
    totalIncome: number,
    latestTransactions: any,
    news: any,
}>();


</script>

<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">Dashboard</h2>
        </template>

        <div class="md:flex">

            <SalutationBalance
                :total-balance="totalBalance"
                :total-expense="totalExpense"
                :total-income="totalIncome"
                :username="$page.props.auth.user.name"
            />

            <LatestTransactions :transactions="latestTransactions.data"/>
        </div>

        <div>
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
