<script setup lang="ts">
import Type from '@/Enums/TransactionType';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import CreateCategory from '@/Pages/Category/Partials/CreateCategory.vue';
import EditCategory from '@/Pages/Category/Partials/EditCategory.vue'
import { Head } from '@inertiajs/vue3';
import { ref } from 'vue';

defineProps<{
    categories: any;
}>();

const openEditCategory = ref(null) as any;

const handleEditCategory = (category: any) => {
    openEditCategory.value = category;
}

const closeEditCategory = () => {
    openEditCategory.value = null;
}

</script>
<template>
    <Head title="Categories" />

    <AuthenticatedLayout>
        <div class="relative overflow-x-auto">
            <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                <caption class="w-full p-5 text-lg font-semibold text-left rtl:text-right text-gray-900 bg-white dark:text-white dark:bg-gray-800">
                    <div class="mb-4">
                        Categories Management
                        <p class="mt-1 max-w-4xl text-sm font-normal text-gray-500 dark:text-gray-400">
                            Categories help you classify transactions, like income, expenses, or specific spending areas such as groceries or entertainment. Organizing transactions makes tracking spending easier and clearer.
                        </p>
                    </div>
                    <CreateCategory type="button" :default="Type.Expense"/>
                </caption>
                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                    <tr>
                        <th scope="col" class="px-6 py-3">
                            Category
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Type
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Description
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <template v-for="category in categories.data">
                        <tr @click="handleEditCategory(category)" class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                            <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                {{ category.name }}
                            </th>
                            <td class="px-6 py-4">
                                {{ category.type }}
                            </td>
                            <td class="px-6 py-4" colspan="2">
                                {{ category.description }}
                            </td>
                        </tr>
                    </template>
                    <template v-if="!categories.data.length">
                        <tr class="bg-white dark:bg-gray-800 dark:border-gray-700">
                            <td class="p-10 text-center text-gray-400" colspan="4">
                                It looks like you haven't created any categories for your transactions yet.
                                <br/> Categories help you organize your spending and track your expenses more effectively.
                            </td>
                        </tr>
                    </template>
                </tbody>
            </table>
        </div>

        <EditCategory v-if="openEditCategory" :category="openEditCategory" @close="closeEditCategory" />
    </AuthenticatedLayout>
</template>