<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}">

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
<body class="antialiased bg-gradient-to-b from-gray-900 via-gray-800 to-gray-900">
<!-- Navigation -->
<nav class="bg-gray-900/50 backdrop-blur-lg border-b border-gray-800 sticky top-0 z-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex items-center">
                <span class="text-2xl font-bold text-white">Finance Tracker</span>
            </div>
            @if (Route::has('login'))
                <div class="flex items-center space-x-4">
                    @auth
                        <a href="{{ url('/dashboard') }}" class="text-gray-300 hover:text-white transition px-3 py-2 rounded-md text-sm font-medium">
                            Dashboard
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="text-gray-300 hover:text-white transition px-3 py-2 rounded-md text-sm font-medium">
                            Log in
                        </a>
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="bg-blue-600 hover:bg-blue-500 transition text-white px-4 py-2 rounded-md text-sm font-medium">
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
<div class="relative min-h-[600px] flex items-center justify-center overflow-hidden">
    <!-- Background Effects -->
    <div class="absolute inset-0">
        <div class="absolute inset-0 bg-gradient-to-b from-blue-600/10 via-blue-900/5 to-transparent"></div>
    </div>

    <!-- Content -->
    <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-32">
        <div class="text-center">
            <h1 class="text-5xl md:text-6xl lg:text-7xl font-bold text-white mb-8">
                Smart Money Management
            </h1>
            <p class="text-xl text-gray-300 max-w-3xl mx-auto leading-relaxed mb-12">
                Track expenses, set budgets, and achieve your financial goals with our comprehensive personal finance management platform. Simple, intuitive, and designed for your success.
            </p>
            <a href="{{ route('register') }}"
               class="inline-flex items-center justify-center bg-blue-600 hover:bg-blue-500 text-white px-8 py-4 rounded-lg text-lg font-medium transition-colors duration-150 ease-in-out group">
                <span>Start Your Journey</span>
                <svg class="w-5 h-5 ml-2 group-hover:translate-x-1 transition-transform duration-150 ease-in-out"
                     fill="none"
                     stroke="currentColor"
                     viewBox="0 0 24 24">
                    <path stroke-linecap="round"
                          stroke-linejoin="round"
                          stroke-width="2"
                          d="M13 7l5 5m0 0l-5 5m5-5H6" />
                </svg>
            </a>
        </div>
    </div>
</div>
<!-- Features Grid -->
<div class="py-32 relative">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center">
            <h2 class="text-4xl font-bold text-white">Everything you need to succeed</h2>
            <p class="mt-4 text-xl text-gray-400">Powerful features to help you manage your money better</p>
        </div>
        <div class="mt-24 grid grid-cols-1 gap-8 sm:grid-cols-2 lg:grid-cols-3">
            <!-- Smart Categories -->
            <div class="bg-gray-800/50 backdrop-blur-lg rounded-xl p-8 border border-gray-700/50 hover:border-blue-500/50 transition-colors group">
                <div class="bg-blue-500/10 rounded-lg p-3 inline-block group-hover:bg-blue-500/20 transition-colors">
                    <svg class="h-7 w-7 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                    </svg>
                </div>
                <h3 class="mt-6 text-xl font-semibold text-white">Smart Categories</h3>
                <p class="mt-4 text-gray-400 leading-relaxed">
                    Organize your transactions with customizable categories. Track spending patterns and identify areas for improvement.
                </p>
            </div>

            <!-- Transaction Tracking -->
            <div class="bg-gray-800/50 backdrop-blur-lg rounded-xl p-8 border border-gray-700/50 hover:border-green-500/50 transition-colors group">
                <div class="bg-green-500/10 rounded-lg p-3 inline-block group-hover:bg-green-500/20 transition-colors">
                    <svg class="h-7 w-7 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/>
                    </svg>
                </div>
                <h3 class="mt-6 text-xl font-semibold text-white">Transaction Tracking</h3>
                <p class="mt-4 text-gray-400 leading-relaxed">
                    Record and categorize all your transactions. Get insights into your spending patterns.
                </p>
            </div>

            <!-- Budget Planning -->
            <div class="bg-gray-800/50 backdrop-blur-lg rounded-xl p-8 border border-gray-700/50 hover:border-purple-500/50 transition-colors group">
                <div class="bg-purple-500/10 rounded-lg p-3 inline-block group-hover:bg-purple-500/20 transition-colors">
                    <svg class="h-7 w-7 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 3.055A9.001 9.001 0 1020.945 13H11V3.055z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.488 9H15V3.512A9.025 9.025 0 0120.488 9z"/>
                    </svg>
                </div>
                <h3 class="mt-6 text-xl font-semibold text-white">Budget Planning</h3>
                <p class="mt-4 text-gray-400 leading-relaxed">
                    Set and monitor budgets by category with visual progress tracking and alerts.
                </p>
            </div>

            <!-- Financial Goals -->
            <div class="bg-gray-800/50 backdrop-blur-lg rounded-xl p-8 border border-gray-700/50 hover:border-yellow-500/50 transition-colors group">
                <div class="bg-yellow-500/10 rounded-lg p-3 inline-block group-hover:bg-yellow-500/20 transition-colors">
                    <svg class="h-7 w-7 text-yellow-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/>
                    </svg>
                </div>
                <h3 class="mt-6 text-xl font-semibold text-white">Financial Goals</h3>
                <p class="mt-4 text-gray-400 leading-relaxed">
                    Set and track financial goals. Celebrate milestones on your journey to success.
                </p>
            </div>

            <!-- Reports & Analytics -->
            <div class="bg-gray-800/50 backdrop-blur-lg rounded-xl p-8 border border-gray-700/50 hover:border-red-500/50 transition-colors group">
                <div class="bg-red-500/10 rounded-lg p-3 inline-block group-hover:bg-red-500/20 transition-colors">
                    <svg class="h-7 w-7 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                    </svg>
                </div>
                <h3 class="mt-6 text-xl font-semibold text-white">Reports & Analytics</h3>
                <p class="mt-4 text-gray-400 leading-relaxed">
                    Gain insights with detailed financial reports and spending analysis.
                </p>
            </div>

            <!-- Multi-Account -->
            <div class="bg-gray-800/50 backdrop-blur-lg rounded-xl p-8 border border-gray-700/50 hover:border-indigo-500/50 transition-colors group">
                <div class="bg-indigo-500/10 rounded-lg p-3 inline-block group-hover:bg-indigo-500/20 transition-colors">
                    <svg class="h-7 w-7 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 6l3 1m0 0l-3 9a5.002 5.002 0 006.001 0M6 7l3 9M6 7l6-2m6 2l3-1m-3 1l-3 9a5.002 5.002 0 006.001 0M18 7l3 9m-3-9l-6-2m0-2v2m0 16V5m0 16H9m3 0h3"/>
                    </svg>
                </div>
                <h3 class="mt-6 text-xl font-semibold text-white">Multi-Account Support</h3>
                <p class="mt-4 text-gray-400 leading-relaxed">
                    Manage multiple accounts in one place. Perfect for personal and business finances.
                </p>
            </div>
        </div>
    </div>
</div>

<!-- CTA Section -->
<div class="relative py-32 overflow-hidden">
    <div class="absolute inset-0 bg-blue-500/10 backdrop-blur-3xl"></div>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="relative bg-gray-800/50 backdrop-blur-lg rounded-2xl p-12 border border-gray-700/50">
            <div class="text-center">
                <h2 class="text-4xl font-bold text-white">Ready to take control?</h2>
                <p class="mt-6 text-xl text-gray-300">
                    Join thousands of users who are mastering
                </p>
                <div class="mt-10">
                    <a href="{{ route('register') }}"
                       class="bg-blue-600 hover:bg-blue-500 transition text-white px-8 py-4 rounded-lg text-lg font-semibold inline-flex items-center space-x-2 shadow-lg shadow-blue-500/25">
                        <span>Create Free Account</span>
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                        </svg>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Footer -->
<footer class="bg-gray-900/50 backdrop-blur-lg border-t border-gray-800">
    <div class="max-w-7xl mx-auto py-12 px-4 sm:px-6 lg:px-8">
        <div class="text-center">
            <div class="flex items-center justify-center space-x-2">
                    <svg xmlns="http://www.w3.org/2000/svg" width="128" height="128">
                        <path d="M77.467 38.852s27.483 15.007 28.99 46.906a32.861 32.861 0 0 1-22.449 32.965A64.856 64.856 0 0 1 64 121.693a64.856 64.856 0 0 1-20.008-2.97 32.861 32.861 0 0 1-22.449-32.965c1.507-31.9 28.99-46.906 28.99-46.906z" fill="#64d465"/><circle cx="64" cy="80.272" r="24.199" transform="rotate(-83.909 64 80.273)" fill="#f4dd45"/><circle cx="64" cy="80.272" r="16.6" transform="rotate(-1.644 64.03 80.286)" fill="#fcc101"/><path d="m77.467 31.252 8.488-19.047S78.438 6.307 64 6.307s-21.955 5.9-21.955 5.9l8.488 19.047z" fill="#64d465"/><path fill="#477b9e" d="M50.533 31.252h26.935v7.6H50.533z"/><path d="M65.361 90.271v1.816H62.78v-1.9a11.629 11.629 0 0 1-6.609-3.035l2.043-2.525a9.7 9.7 0 0 0 4.566 2.44v-5.533c-3.489-.907-5.843-2.155-5.843-5.5 0-3.064 2.354-5.418 5.843-5.844v-1.73h2.581v1.759a10.547 10.547 0 0 1 5.957 2.637l-1.928 2.61a9.269 9.269 0 0 0-4.029-2.127v5.331c3.887.879 6.468 2.212 6.468 5.673 0 3.262-2.354 5.645-6.468 5.928zM62.78 77.989V73.28a2.678 2.678 0 0 0-2.269 2.44c0 1.134.738 1.73 2.269 2.269zm5.5 6.694c0-1.305-.907-1.9-2.922-2.5v5.049c1.933-.223 2.925-1.301 2.925-2.549z" fill="#f4dd45"/>
                    </svg>

                <span class="text-xl font-bold text-white">Finance Tracker</span>
            </div>
            <p class="mt-6 text-gray-400 text-sm">
                © {{ date('Y') }} Finance Tracker. All rights reserved.
            </p>
        </div>
    </div>
</footer>
</body>
</html>
