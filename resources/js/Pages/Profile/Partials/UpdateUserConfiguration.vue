<script setup lang="ts">
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import SelectInput from '@/Components/SelectInput.vue';
import { useForm, usePage } from '@inertiajs/vue3';
import CurrencyList from 'currency-list';
import { listOfTimezones, languageLocale } from '@/localeAndTimezone';

defineProps<{
    mustVerifyEmail?: Boolean;
    status?: String;
}>();

const user = usePage().props.auth.user;

const form = useForm({
    currency: user.currency,
    locale: user.locale,
    timezone: user.timezone,
});

const currencies = CurrencyList.getAll('en_US');
</script>

<template>
    <section>
        <header>
            <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">Account configuration</h2>

            <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                Update your account's depend on your personal configuration.
            </p>
        </header>

        <form @submit.prevent="form.patch(route('configuration.update'), {preserveScroll: true})" class="mt-6 space-y-6">

            <div>
                <InputLabel for="locale" value="Locale" />

                <SelectInput
                    id="locale"
                    class="mt-1 block w-full"
                    v-model="form.locale"
                    required
                    autocomplete="locale"
                >
                    <template v-for="name, key in languageLocale">
                        <option :value="key">{{ name }}</option>
                    </template>
                </SelectInput>


                <InputError class="mt-2" :message="form.errors.locale" />
            </div>

            <div>
                <InputLabel for="currency" value="Currency" />

                <SelectInput
                    id="currency"
                    class="mt-1 block w-full"
                    v-model="form.currency"
                    required
                    autocomplete="Currency"
                >
                    <template v-for="currency, code in currencies">
                        <option :value="code">{{ currency.name }}</option>
                    </template>
                </SelectInput>


                <InputError class="mt-2" :message="form.errors.currency" />
            </div>

            <div>
                <InputLabel for="timezone" value="Timezone" />

                <SelectInput
                    id="timezone"
                    class="mt-1 block w-full"
                    v-model="form.timezone"
                    required
                    autocomplete="timezone"
                >
                    <template v-for="country, code in listOfTimezones">
                        <option :value="code">{{ country }}</option>
                    </template>
                </SelectInput>


                <InputError class="mt-2" :message="form.errors.timezone" />
            </div>

            <div class="flex items-center gap-4">
                <PrimaryButton :disabled="form.processing">Save</PrimaryButton>

                <Transition
                    enter-active-class="transition ease-in-out"
                    enter-from-class="opacity-0"
                    leave-active-class="transition ease-in-out"
                    leave-to-class="opacity-0"
                >
                    <p v-if="form.recentlySuccessful" class="text-sm text-gray-600 dark:text-gray-400">Saved.</p>
                </Transition>
            </div>
        </form>
    </section>
</template>
