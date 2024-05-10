<script setup lang="ts">
import ApplicationLogo from '@/Components/ApplicationLogo.vue';
import IconUser from '@/Components/IconUser.vue';
import ResponsiveNavLink from '@/Components/ResponsiveNavLink.vue';
import ThemeToggle from '@/Components/ThemeToggle.vue';
import { Link } from '@inertiajs/vue3';
</script>
<template>
    <nav class="bg-white border-b border-gray-200 px-4 py-2.5 dark:bg-gray-800 dark:border-gray-700 fixed left-0 right-0 top-0 z-50">
        <div class="flex flex-wrap justify-between items-center max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="flex justify-start items-center">
                <Link :href="route('dashboard')" class="flex items-center justify-between mr-4">
                    <ApplicationLogo class="size-6 me-2"/>
                    <span class="self-center text-xl font-semibold whitespace-nowrap dark:text-white">NyatetDuit</span>
                </Link>
            </div>
            <div class="flex items-center lg:order-2">
                <ThemeToggle />

                <button
                    type="button"
                    class="flex mx-3 text-sm rounded-full md:mr-0 focus:ring-4 focus:ring-gray-300 dark:focus:ring-gray-600"
                    id="user-menu-button"
                    aria-expanded="false"
                    data-dropdown-toggle="dropdown"
                >
                    <span class="sr-only">Open user menu</span>
                    <IconUser />
                </button>
                <!-- Dropdown menu -->
                <div
                    class="hidden z-50 my-4 w-56 text-base list-none bg-white rounded divide-y divide-gray-100 shadow dark:bg-gray-700 dark:divide-gray-600"
                    id="dropdown"
                >
                    <div class="py-3 px-4">
                    <span
                        class="block text-sm font-semibold text-gray-900 dark:text-white"
                        >{{ $page.props.auth.user.name }}</span
                    >
                    <span
                        class="block text-sm text-gray-900 truncate dark:text-white"
                        >{{ $page.props.auth.user.email }}</span
                    >
                    </div>
                    <ul
                    class="py-1 text-gray-700 dark:text-gray-300"
                    aria-labelledby="dropdown"
                    >
                    <li>
                        <ResponsiveNavLink :href="route('profile.index')"> My Profile </ResponsiveNavLink>
                    </li>
                    <li>
                        <ResponsiveNavLink :href="route('backups.index')">Backup Management</ResponsiveNavLink>
                    </li>
                    </ul>
                    <ul
                        class="py-1 text-gray-700 dark:text-gray-300"
                        aria-labelledby="dropdown"
                    >
                        <li>
                            <ResponsiveNavLink :href="route('logout')" method="post" as="button">
                                Sign out
                            </ResponsiveNavLink>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </nav>
</template>