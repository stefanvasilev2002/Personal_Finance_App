<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Finance Tracker</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    @production
        @php
            $manifest = json_decode(file_get_contents(public_path('build/manifest.json')), true);
        @endphp
        <link rel="stylesheet" href="{{ asset('build/' . $manifest['resources/css/app.css']['file']) }}">
        <script type="module" src="{{ asset('build/' . $manifest['resources/js/app.js']['file']) }}"></script>
    @else
         @vite(['resources/css/app.css', 'resources/js/app.js'])
    @endproduction
</head>
<body class="antialiased bg-gray-900">
<!-- Navigation -->
<nav class="border-b border-gray-800">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex items-center">
                <span class="text-2xl font-bold text-white">Finance Tracker</span>
            </div>
            @if (Route::has('login'))
                <div class="flex items-center space-x-4">
                    @auth
                        <a href="{{ url('/dashboard') }}"
                           class="text-white hover:text-gray-300 px-3 py-2 rounded-md text-sm font-medium">
                            Dashboard
                        </a>
                    @else
                        <a href="{{ route('login') }}"
                           class="text-white hover:text-gray-300 px-3 py-2 rounded-md text-sm font-medium">
                            Log in
                        </a>
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}"
                               class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md text-sm font-medium">
                                Get Started
                            </a>
                        @endif
                    @endauth
                </div>
            @endif
        </div>
    </div>
</nav>

<!-- Hero Section -->
<div class="relative overflow-hidden">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-24">
        <div class="text-center">
            <h1 class="text-4xl font-bold tracking-tight text-white sm:text-6xl">
                Take Control of Your Financial Journey
            </h1>
            <p class="mt-6 text-lg text-gray-300 max-w-3xl mx-auto">
                Track expenses, set budgets, manage accounts, and achieve your financial goals with our comprehensive personal finance management platform.
            </p>
            <div class="mt-10">
                <a href="{{ route('register') }}"
                   class="bg-blue-600 hover:bg-blue-700 text-white px-8 py-3 rounded-md text-lg font-semibold">
                    Start For Free
                </a>
            </div>
        </div>
    </div>
</div>

<!-- Features Grid -->
<div class="bg-gray-800 py-24">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center">
            <h2 class="text-3xl font-bold text-white">Everything you need to manage your finances</h2>
        </div>
        <div class="mt-20 grid grid-cols-1 gap-8 sm:grid-cols-2 lg:grid-cols-3">
            <!-- Account Management -->
            <div class="bg-gray-900 rounded-lg p-6">
                <div class="bg-blue-600/10 rounded-lg p-3 inline-block">
                    <svg class="h-6 w-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 6l3 1m0 0l-3 9a5.002 5.002 0 006.001 0M6 7l3 9M6 7l6-2m6 2l3-1m-3 1l-3 9a5.002 5.002 0 006.001 0M18 7l3 9m-3-9l-6-2m0-2v2m0 16V5m0 16H9m3 0h3"/>
                    </svg>
                </div>
                <h3 class="mt-4 text-xl font-semibold text-white">Account Management</h3>
                <p class="mt-2 text-gray-400">
                    Track multiple accounts in one place. Support for checking, savings, and credit card accounts.
                </p>
            </div>

            <!-- Transaction Tracking -->
            <div class="bg-gray-900 rounded-lg p-6">
                <div class="bg-green-600/10 rounded-lg p-3 inline-block">
                    <svg class="h-6 w-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/>
                    </svg>
                </div>
                <h3 class="mt-4 text-xl font-semibold text-white">Transaction Tracking</h3>
                <p class="mt-2 text-gray-400">
                    Record and categorize all your transactions with detailed insights and reporting.
                </p>
            </div>

            <!-- Budget Planning -->
            <div class="bg-gray-900 rounded-lg p-6">
                <div class="bg-purple-600/10 rounded-lg p-3 inline-block">
                    <svg class="h-6 w-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 3.055A9.001 9.001 0 1020.945 13H11V3.055z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.488 9H15V3.512A9.025 9.025 0 0120.488 9z"/>
                    </svg>
                </div>
                <h3 class="mt-4 text-xl font-semibold text-white">Budget Planning</h3>
                <p class="mt-2 text-gray-400">
                    Set and monitor budgets by category with visual progress tracking and alerts.
                </p>
            </div>

            <!-- Financial Goals -->
            <div class="bg-gray-900 rounded-lg p-6">
                <div class="bg-yellow-600/10 rounded-lg p-3 inline-block">
                    <svg class="h-6 w-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/>
                    </svg>
                </div>
                <h3 class="mt-4 text-xl font-semibold text-white">Financial Goals</h3>
                <p class="mt-2 text-gray-400">
                    Set and track financial goals with progress monitoring and milestone celebrations.
                </p>
            </div>

            <!-- Reports & Analytics -->
            <div class="bg-gray-900 rounded-lg p-6">
                <div class="bg-red-600/10 rounded-lg p-3 inline-block">
                    <svg class="h-6 w-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                    </svg>
                </div>
                <h3 class="mt-4 text-xl font-semibold text-white">Reports & Analytics</h3>
                <p class="mt-2 text-gray-400">
                    Gain insights with detailed financial reports and spending analysis.
                </p>
            </div>

            <!-- Security -->
            <div class="bg-gray-900 rounded-lg p-6">
                <div class="bg-indigo-600/10 rounded-lg p-3 inline-block">
                    <svg class="h-6 w-6 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                    </svg>
                </div>
                <h3 class="mt-4 text-xl font-semibold text-white">Bank-Level Security</h3>
                <p class="mt-2 text-gray-400">
                    Your data is protected with industry-standard encryption and security measures.
                </p>
            </div>
        </div>
    </div>
</div>

<!-- CTA Section -->
<div class="bg-gray-900 py-24">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center">
            <h2 class="text-3xl font-bold text-white">Ready to start your financial journey?</h2>
            <p class="mt-4 text-xl text-gray-300">
                Join thousands of users who are taking control of their finances.
            </p>
            <div class="mt-8">
                <a href="{{ route('register') }}"
                   class="bg-blue-600 hover:bg-blue-700 text-white px-8 py-3 rounded-md text-lg font-semibold">
                    Create Free Account
                </a>
            </div>
        </div>
    </div>
</div>

<!-- Footer -->
<footer class="bg-gray-800">
    <div class="max-w-7xl mx-auto py-12 px-4 sm:px-6 lg:px-8">
        <div class="text-center text-gray-400 text-sm">
            © {{ date('Y') }} Finance Tracker. All rights reserved.
        </div>
    </div>
</footer>
</body>
</html>
