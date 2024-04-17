<script setup lang="ts">
import Type from '@/Enums/TransactionType';
import { useForm, usePage } from '@inertiajs/vue3';
import { ref } from 'vue';

const categories = usePage().props.auth.categories;

const props = defineProps<{
    date_between: Array<String>;
}>();

const dateStart = ref(props.date_between[0]);

const dateEnd = ref(props.date_between[1]);

const form = useForm({
    filter: {
        type: null,
        category_id: [] as number[],
        search: '',
    },
})

const handleSelectType = () => {
    form.filter.category_id = [],

    handleFilter();
}

const handleSearch = () => {

    handleFilter();
};

const handleDateBetween = () => {
}

const handleFilter = () => {
    handleDateBetween();

    form.get(route('transactions.index'), { preserveScroll: true, preserveState: true });
};

const toggleCategorySelection = (categoryId: number) => {
    const index = form.filter.category_id.indexOf(categoryId);

    if (index === -1) {
        form.filter.category_id.push(categoryId);
    } else {
        form.filter.category_id.splice(index, 1);
    }

    handleFilter();
}

const isCategorySelected = (categoryId: number) => {
    return form.filter.category_id.includes(categoryId);
}
</script>
<template>
    <div class="relative bg-white dark:bg-gray-800 rounded-lg">
        <div class="flex flex-col items-center justify-between p-4 space-y-3 md:flex-row md:space-y-0 md:space-x-4">
            <div class="w-full md:w-1/2">

                <div class="flex items-center">
                    <div class="relative w-full md:w-auto">
                        <input
                            @change="handleFilter"
                            v-model="dateStart"
                            name="start"
                            type="date"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                            placeholder="Select date start"
                        >
                    </div>
                    <span class="mx-2 text-gray-500">to</span>
                    <div class="relative w-full md:w-auto">
                        <input
                            @change="handleFilter"
                            v-model="dateEnd"
                            name="end"
                            type="date"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                            placeholder="Select date end"
                        >
                    </div>
                </div>
            </div>
            <div class="flex flex-col items-stretch justify-end flex-shrink-0 w-full space-y-2 md:w-auto md:flex-row md:space-y-0 md:items-center md:space-x-3">
                <div class="flex items-center w-full space-x-3 md:w-auto">
                    <form @submit.prevent="handleSearch" class="flex items-center w-full">
                        <label for="simple-search" class="sr-only">Search</label>
                        <div class="relative w-full">
                            <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                <svg aria-hidden="true" class="w-5 h-5 text-gray-500 dark:text-gray-400" fill="currentColor" viewbox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd" />
                                </svg>
                            </div>
                            <input v-debounce:500ms="handleSearch" type="text" v-model="form.filter.search" name="search" id="simple-search" class="block w-full p-2 pl-10 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-primary-500 focus:border-primary-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" placeholder="Search">
                        </div>
                    </form>
                    <button id="filterDropdownButton" data-dropdown-toggle="filterDropdown" class="flex items-center justify-center w-full px-4 py-2 text-sm font-medium text-gray-900 bg-white border border-gray-200 rounded-lg md:w-auto focus:outline-none hover:bg-gray-100 hover:text-primary-700 focus:z-10 focus:ring-4 focus:ring-gray-200 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700" type="button">
                        <svg xmlns="http://www.w3.org/2000/svg" aria-hidden="true" class="w-4 h-4 mr-2 text-gray-400" viewbox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M3 3a1 1 0 011-1h12a1 1 0 011 1v3a1 1 0 01-.293.707L12 11.414V15a1 1 0 01-.293.707l-2 2A1 1 0 018 17v-5.586L3.293 6.707A1 1 0 013 6V3z" clip-rule="evenodd" />
                        </svg>
                        Filter
                        <svg class="-mr-1 ml-1.5 w-5 h-5" fill="currentColor" viewbox="0 0 20 20" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                            <path clip-rule="evenodd" fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" />
                        </svg>
                    </button>
                    <!-- Dropdown menu -->
                    <div id="filterDropdown" class="z-10 hidden w-48 p-3 divide-y space-y-4 gap-3 bg-white rounded-lg shadow dark:bg-gray-700">
                        <div>
                            <h6 class="mb-3 text-sm font-medium text-gray-900 dark:text-white">
                                Type
                            </h6>
                            <ul class="space-y-2 text-sm" aria-labelledby="dropdownDefault">
                                <li class="flex items-center">
                                    <input @change="handleSelectType" :id="'type-all'" type="radio" :value="null" v-model="form.filter.type"
                                        class="w-4 h-4 bg-gray-100 border-gray-300 rounded text-primary-600 focus:ring-primary-500 dark:focus:ring-primary-600 dark:ring-offset-gray-700 focus:ring-2 dark:bg-gray-600 dark:border-gray-500" />
                                    <label :for="'type-all'" class="ml-2 text-sm font-medium text-gray-900 dark:text-gray-100">
                                        All
                                    </label>
                                </li>
                                <li class="flex items-center" v-for="(value, name) in Type">
                                    <input @change="handleSelectType" :id="'type-'+name" type="radio" :value="value" v-model="form.filter.type"
                                        class="w-4 h-4 bg-gray-100 border-gray-300 rounded text-primary-600 focus:ring-primary-500 dark:focus:ring-primary-600 dark:ring-offset-gray-700 focus:ring-2 dark:bg-gray-600 dark:border-gray-500" />
                                    <label :for="'type-'+name" class="ml-2 text-sm font-medium text-gray-900 dark:text-gray-100">
                                        {{ name }}
                                    </label>
                                </li>
                            </ul>
                        </div>
                        <div v-if="form.filter.type != null">
                            <h6 class="mb-3 mt-2 text-sm font-medium text-gray-900 dark:text-white">
                                Category
                            </h6>
                            <ul class="space-y-2 text-sm" aria-labelledby="dropdownDefault">
                                <template v-for="category in categories[form.filter.type]">
                                    <li class="flex items-center">
                                        <input
                                            type="checkbox"
                                            :id="'category'+category.id"
                                            :value="category.id"
                                            :checked="isCategorySelected(category.id)"
                                            @change="toggleCategorySelection(category.id)"
                                            class="w-4 h-4 bg-gray-100 border-gray-300 rounded text-primary-600 focus:ring-primary-500 dark:focus:ring-primary-600 dark:ring-offset-gray-700 focus:ring-2 dark:bg-gray-600 dark:border-gray-500"
                                        />
                                        <label :for="'category'+category.id" class="ml-2 text-sm font-medium text-gray-900 dark:text-gray-100">
                                            {{ category.name }}
                                        </label>
                                    </li>
                                </template>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>