<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="Explore {{ config('app.name') }}, a user-friendly finance management application designed for simplicity and effectiveness. With intuitive budgeting tools, easy expense tracking, and insightful reports, {{ config('app.name') }} empowers users to manage their finances effortlessly. Install {{ config('app.name') }} now and simplify your financial journey!">

        <title>Simplify Finances with {{ config('app.name') }}</title>
        <link rel="icon" href="{{ asset('favicon.svg') }}" sizes="any" type="image/svg+xml">
        @if(app()->isProduction())
        <link rel="manifest" href="/manifest.json">
        @endif

        <!-- Styles -->
        <script>
            if (localStorage.getItem('color-theme') === 'dark' || (!('color-theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
                document.documentElement.classList.add('dark');
            } else {
                document.documentElement.classList.remove('dark')
            }
        </script>
        <!-- Scripts -->
        @vite(['resources/js/static.ts'])
    </head>
    <body class="font-sans antialiased dark:bg-black dark:text-white/50">
        <section class="bg-white dark:bg-gray-900">
            <div class="grid max-w-screen-xl px-4 py-8 mx-auto lg:gap-8 xl:gap-0 lg:py-16 lg:grid-cols-12">
                <div class="mr-auto place-self-center lg:col-span-7">
                    <h1 class="max-w-2xl mb-4 text-4xl font-extrabold tracking-tight leading-none md:text-5xl xl:text-6xl dark:text-white">
                        <x-logo class="size-14 mb-2 inline" /> {{ config('app.name') }} - Manage Your Finances with Ease
                    </h1>
                    <p class="max-w-2xl mb-6 font-light text-gray-500 lg:mb-8 md:text-lg lg:text-xl dark:text-gray-400">
                        Where simplicity meets smart finance management.
                    </p>
                    <a href="{{ route('login') }}" class="inline-flex items-center justify-center px-5 py-3 mr-3 text-base font-medium text-center text-white rounded-lg bg-primary-700 hover:bg-primary-800 focus:ring-4 focus:ring-primary-300 dark:focus:ring-primary-900">
                        Get started
                        <svg class="w-5 h-5 ml-2 -mr-1" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M10.293 3.293a1 1 0 011.414 0l6 6a1 1 0 010 1.414l-6 6a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-4.293-4.293a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                    </a>
                    <a href="https://github.com/sidiqaldi/nyatet-duit" class="inline-flex items-center justify-center px-5 py-3 text-base font-medium text-center text-gray-900 border border-gray-300 rounded-lg hover:bg-gray-100 focus:ring-4 focus:ring-gray-100 dark:text-white dark:border-gray-700 dark:hover:bg-gray-700 dark:focus:ring-gray-800">
                        Github
                    </a>
                </div>
                <div class="lg:mt-0 lg:col-span-5 lg:flex">
                    <img class="block dark:hidden rounded shadow border" src="{{ asset('screenshot-light.png') }}" alt="screenshot">
                    <img class="hidden dark:block rounded shadow border" src="{{ asset('screenshot-dark.png') }}" alt="screenshot">
                </div>
            </div>
        </section>

        <section class="bg-white dark:bg-gray-900">
            <div class="py-8 px-4 mx-auto max-w-screen-xl sm:py-16 lg:px-6">
                <div class="mb-8 max-w-screen-md lg:mb-16">
                    <h2 class="mb-4 text-4xl tracking-tight font-extrabold text-gray-900 dark:text-white">Key Features</h2>
                    <p class="text-gray-500 sm:text-xl dark:text-gray-400">
                        Designed for those who appreciate simplicity and value-focused financial tracking,
                        {{ config('app.name') }} offers an intuitive solution tailored to your needs.
                    </p>
                </div>
                <div class="space-y-8 md:grid md:grid-cols-2 lg:grid-cols-3 md:gap-12 md:space-y-0">
                    <div>
                        <div class="flex justify-center items-center mb-4 w-10 h-10 rounded-full bg-primary-100 lg:h-12 lg:w-12 dark:bg-primary-900">
                            <svg class="w-5 h-5 text-primary-600 lg:w-6 lg:h-6 dark:text-primary-300" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path d="M8.433 7.418c.155-.103.346-.196.567-.267v1.698a2.305 2.305 0 01-.567-.267C8.07 8.34 8 8.114 8 8c0-.114.07-.34.433-.582zM11 12.849v-1.698c.22.071.412.164.567.267.364.243.433.468.433.582 0 .114-.07.34-.433.582a2.305 2.305 0 01-.567.267z"></path><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-13a1 1 0 10-2 0v.092a4.535 4.535 0 00-1.676.662C6.602 6.234 6 7.009 6 8c0 .99.602 1.765 1.324 2.246.48.32 1.054.545 1.676.662v1.941c-.391-.127-.68-.317-.843-.504a1 1 0 10-1.51 1.31c.562.649 1.413 1.076 2.353 1.253V15a1 1 0 102 0v-.092a4.535 4.535 0 001.676-.662C13.398 13.766 14 12.991 14 12c0-.99-.602-1.765-1.324-2.246A4.535 4.535 0 0011 9.092V7.151c.391.127.68.317.843.504a1 1 0 101.511-1.31c-.563-.649-1.413-1.076-2.354-1.253V5z" clip-rule="evenodd"></path></svg>
                        </div>
                        <h3 class="mb-2 text-xl font-bold dark:text-white">Budgeting Made Simple</h3>
                        <p class="text-gray-500 dark:text-gray-400">
                            Easily create and manage budgets tailored to your financial goals. With intuitive tools and customizable categories, budgeting has never been easier. Stay on track and in control of your finances effortlessly.
                        </p>
                    </div>
                    <div>
                        <div class="flex justify-center items-center mb-4 w-10 h-10 rounded-full bg-primary-100 lg:h-12 lg:w-12 dark:bg-primary-900">
                            <svg class="w-5 h-5 text-primary-600 lg:w-6 lg:h-6 dark:text-primary-300" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M6 6V5a3 3 0 013-3h2a3 3 0 013 3v1h2a2 2 0 012 2v3.57A22.952 22.952 0 0110 13a22.95 22.95 0 01-8-1.43V8a2 2 0 012-2h2zm2-1a1 1 0 011-1h2a1 1 0 011 1v1H8V5zm1 5a1 1 0 011-1h.01a1 1 0 110 2H10a1 1 0 01-1-1z" clip-rule="evenodd"></path><path d="M2 13.692V16a2 2 0 002 2h12a2 2 0 002-2v-2.308A24.974 24.974 0 0110 15c-2.796 0-5.487-.46-8-1.308z"></path></svg>
                        </div>
                        <h3 class="mb-2 text-xl font-bold dark:text-white">Expense Tracking on the Go</h3>
                        <p class="text-gray-500 dark:text-gray-400">Track your expenses anytime. Capture transactions on the go, categorize expenses with ease, and keep a close eye on your spending habits—all from the palm of your hand.</p>
                    </div>
                    <div>
                        <div class="flex justify-center items-center mb-4 w-10 h-10 rounded-full bg-primary-100 lg:h-12 lg:w-12 dark:bg-primary-900">
                            <svg class="w-5 h-5 text-primary-600 lg:w-6 lg:h-6 dark:text-primary-300" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M3 3a1 1 0 000 2v8a2 2 0 002 2h2.586l-1.293 1.293a1 1 0 101.414 1.414L10 15.414l2.293 2.293a1 1 0 001.414-1.414L12.414 15H15a2 2 0 002-2V5a1 1 0 100-2H3zm11.707 4.707a1 1 0 00-1.414-1.414L10 9.586 8.707 8.293a1 1 0 00-1.414 0l-2 2a1 1 0 101.414 1.414L8 10.414l1.293 1.293a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
                        </div>
                        <h3 class="mb-2 text-xl font-bold dark:text-white">Insightful Reports and Analytics</h3>
                        <p class="text-gray-500 dark:text-gray-400">Gain valuable insights into your financial with comprehensive reports and analytics. Visualize your spending patterns, identify areas for improvement, and make decisions to optimize your financial. </p>
                    </div>

                </div>
            </div>
        </section>

        <div class="my-10 w-full p-4 text-center bg-white rounded-lg sm:p-8 dark:bg-gray-800 dark:border-gray-700">
            <h5 class="mb-2 text-3xl font-bold text-gray-900 dark:text-white">Want to deploy to your own environment?</h5>
            <p class="mb-10 max-w-screen-md mx-auto text-base text-gray-500 sm:text-lg dark:text-gray-400">
                {{ config('app.name') }} source is open-source and available on GitHub, allowing users to access, modify, and install the application in their own environments. With the source code freely accessible, developers and enthusiasts can customize to their liking or self-host it for personal use.
            </p>
            <div class="items-center justify-center space-y-4 sm:flex sm:space-y-0 sm:space-x-4 rtl:space-x-reverse">
                <a href="https://github.com/sidiqaldi/nyatet-duit" class="w-full sm:w-auto bg-gray-800 hover:bg-gray-700 focus:ring-4 focus:outline-none focus:ring-gray-300 text-white rounded-lg inline-flex items-center justify-center px-4 py-2.5 dark:bg-gray-700 dark:hover:bg-gray-600 dark:focus:ring-gray-700">
                    <x-github-logo class="me-3 w-7 h-7" />
                    <div class="text-left rtl:text-right">
                        <div class="mb-1 text-xs">Source on the</div>
                        <div class="-mt-1 font-sans text-sm font-semibold">GitHub</div>
                    </div>
                </a>
            </div>
        </div>

        <footer class="p-4 bg-white md:p-8 lg:p-10 dark:bg-gray-800">
            <div class="mx-auto max-w-screen-xl text-center">
                <a href="/" class="mb-2 flex justify-center items-center text-2xl font-semibold text-gray-900 dark:text-white">
                    <x-logo class="size-8 me-2" />
                    {{ config('app.name') }}
                </a>
                <span class="text-sm text-gray-500 sm:text-center dark:text-gray-400">© 2024 {{ config('app.name') }} All Rights Reserved.</span>
            </div>
        </footer>
    </body>
</html>
