<script setup lang="ts">
import { ref } from 'vue';
import Modal from '@/Components/Modal.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import { useForm } from '@inertiajs/vue3';
import TransactionType from '@/Enums/TransactionType'
import TextInput from '@/Components//TextInput.vue';
import TextareaInput from '@/Components//TextareaInput.vue';
import InputError from '@/Components//InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import DangerButton from '@/Components/DangerButton.vue';
import Type from '@/Enums/TransactionType';
import { onMounted } from 'vue';

const emit = defineEmits<{
    (e: 'close', id: number): void
}>()

const props = defineProps<{
    category: any
}>();

const form = useForm({
    type: Type.Expense as any,
    name: '' as any,
    description: '' as any,
});

const modalOpened = ref(false);

const showDeleteConfirmation = ref(false);

const closeModal = () => {
    modalOpened.value = false;

    setTimeout(() => emit('close', props.category.id), 600);
};

onMounted(() => {
    if (props.category) {
        modalOpened.value = true;
    }

    form.type = props.category.type_id;
    form.name = props.category.name;
    form.description = props.category.description;
})

const submitCategory = () => {
    form.put(route('categories.update', props.category.id), {
        preserveScroll: true,
        onSuccess: () => {
            form.reset();
            closeModal();
        },
    })
}

const confirmDeletion = () => {
    showDeleteConfirmation.value = true;
}

const cancelDeletion = () => {
    showDeleteConfirmation.value = false;
}

const deleteCategory = () => {
    form.delete(route('categories.destroy', props.category.id), {
        preserveScroll: true,
        onSuccess: () => {
            form.reset();
            closeModal();
        },
    })
}

</script>
<template>
    <div class="flex items-center justify-center">

        <Modal :show="modalOpened">
            <div class="py-8 px-6">
                <form @submit.prevent="submitCategory" class="mx-auto">
                    <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                        Edit Category
                    </h2>

                    <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                        Manage your categories name.
                    </p>

                    <div class="mt-6">

                        <div class="py-2">
                            <span for="type" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Type</span>
                            <ul class="items-center w-full text-sm font-medium text-gray-900 bg-white border border-gray-200 rounded-lg sm:flex dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                                <li class="w-full border-b border-gray-200 sm:border-b-0 sm:border-r dark:border-gray-600">
                                    <div class="flex items-center ps-3">
                                        <input id="horizontal-list-expense" v-model="form.type" type="radio" :value="TransactionType.Expense" class="w-4 h-4 text-primary-600 bg-gray-100 border-gray-300 focus:ring-primary-500 dark:focus:ring-primary-600 dark:ring-offset-gray-700 dark:focus:ring-offset-gray-700 focus:ring-2 dark:bg-gray-600 dark:border-gray-500">
                                        <label for="horizontal-list-expense" class="w-full py-3 ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">Expense</label>
                                    </div>
                                </li>
                                <li class="w-full dark:border-gray-600">
                                    <div class="flex items-center ps-3">
                                        <input id="horizontal-list-income" v-model="form.type" type="radio" :value="TransactionType.Income" class="w-4 h-4 text-primary-600 bg-gray-100 border-gray-300 focus:ring-primary-500 dark:focus:ring-primary-600 dark:ring-offset-gray-700 dark:focus:ring-offset-gray-700 focus:ring-2 dark:bg-gray-600 dark:border-gray-500">
                                        <label for="horizontal-list-income" class="w-full py-3 ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">Income</label>
                                    </div>
                                </li>
                            </ul>
                            <InputError :message="form.errors.type" class="mt-2" />
                        </div>

                        <div class="py-2">
                            <div class="flex justify-between">
                                <InputLabel class="mb-2" for="name">Name <span class="text-red-500">*</span></InputLabel>
                            </div>
                            <TextInput id="name" class="w-full text-sm" type="text" required v-model="form.name" maxlength="100" />
                            <InputError :message="form.errors.name" class="mt-2" />
                        </div>

                        <div class="py-2">
                            <InputLabel class="mb-2" for="description">Description <span class="font-thin">(optional)</span></InputLabel>
                            <TextareaInput id="description" v-model="form.description" rows="4" placeholder="Add a quick note about this category..." maxlength="200"/>
                            <InputError :message="form.errors.description" class="mt-2" />
                        </div>

                    </div>

                    <div class="mt-6 flex justify-between">
                        <div class="flex justify-start">
                            <DangerButton v-if="!showDeleteConfirmation" class="mr-2" type="button" @click.prevent="confirmDeletion">Delete</DangerButton>
                            <div v-else>
                                <p class="text-gray-600 dark:text-gray-400 mb-2">Are you sure?</p>
                                <div class="flex justify-end">
                            <SecondaryButton class="mr-2" type="button" @click.prevent="cancelDeletion">cancel</SecondaryButton>
                            <DangerButton type="button" @click.prevent="deleteCategory">Delete</DangerButton>
                        </div>
                            </div>
                        </div>
                        <div class="flex justify-end"  v-if="!showDeleteConfirmation" >
                            <SecondaryButton class="mr-2" type="button" @click.prevent="closeModal">cancel</SecondaryButton>
                            <PrimaryButton type="submit">Submit</PrimaryButton>
                        </div>
                    </div>
                </form>
            </div>
        </Modal>
    </div>
</template>