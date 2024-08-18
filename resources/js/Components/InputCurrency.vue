<template>
    <input
        ref="inputRef"
        type="text"
        class="bg-gray-50 border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300 focus:border-primary-500 dark:focus:border-primary-600 focus:ring-primary-500 dark:focus:ring-primary-600 rounded-md shadow-sm w-full text-sm"
    />
</template>

<script>
import { useCurrencyInput } from "vue-currency-input";

export default {
    name: "CurrencyInput",
    props: {
        modelValue: Number|null,
        options: Object,
    },
    setup(props) {
        const { inputRef } = useCurrencyInput(props.options);

        return { inputRef };
    },
};
</script>
