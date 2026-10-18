<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full bg-slate-50">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $title ?? 'Student Management System' }} | Hok Khemarak</title>

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Vite Assets -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-full font-sans antialiased text-slate-800 flex flex-col bg-slate-50/80">
    <!-- Top Navigation Bar -->
    <header class="sticky top-0 z-40 bg-white/90 backdrop-blur-md border-b border-slate-200/80 shadow-xs">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-16">
                <!-- Brand / Logo -->
                <div class="flex items-center space-x-3">
                    <a href="{{ route('dashboard') }}" class="flex items-center space-x-3 group">
                        <div class="w-10 h-10 rounded-xl gradient-brand flex items-center justify-center text-white shadow-md shadow-indigo-500/20 group-hover:scale-105 transition-transform duration-200">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5zm0 0l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14zm-4 6v-7.5l4-2.222" />
                            </svg>
                        </div>
                        <div>
                            <span class="text-lg font-bold tracking-tight text-slate-900 group-hover:text-indigo-600 transition-colors">
                                SMS <span class="text-indigo-600 font-extrabold">Final</span>
                            </span>
                            <span class="block text-xs font-medium text-slate-400 -mt-1">Student Management System</span>
                        </div>
                    </a>

                    <!-- Navigation Links -->
                    <nav class="hidden md:flex items-center space-x-1 ml-8">
                        <a href="{{ route('dashboard') }}" class="px-3 py-2 rounded-lg text-sm font-semibold transition-colors {{ request()->routeIs('dashboard') ? 'bg-indigo-50 text-indigo-700' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-100' }}">
                            <div class="flex items-center space-x-1.5">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                                <span>Dashboard</span>
                            </div>
                        </a>
                        <a href="{{ route('students.index') }}" class="px-3 py-2 rounded-lg text-sm font-semibold transition-colors {{ request()->routeIs('students.*') ? 'bg-indigo-50 text-indigo-700' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-100' }}">
                            <div class="flex items-center space-x-1.5">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                                <span>Students</span>
                            </div>
                        </a>
                        <a href="{{ route('departments.index') }}" class="px-3 py-2 rounded-lg text-sm font-semibold transition-colors {{ request()->routeIs('departments.*') ? 'bg-indigo-50 text-indigo-700' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-100' }}">
                            <div class="flex items-center space-x-1.5">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                                <span>Departments</span>
                            </div>
                        </a>
                    </nav>
                </div>

                <!-- Right Side: User Profile & Actions -->
                <div class="flex items-center space-x-3">
                    @auth
                        <div class="flex items-center space-x-3 pl-3 border-l border-slate-200">
                            <div class="hidden sm:flex flex-col text-right">
                                <span class="text-sm font-bold text-slate-800 leading-tight">{{ Auth::user()->name }}</span>
                                <span class="text-xs text-slate-500">{{ Auth::user()->email }}</span>
                            </div>
                            <div class="w-9 h-9 rounded-full bg-linear-to-tr from-indigo-500 to-purple-600 text-white font-bold flex items-center justify-center text-sm shadow-xs">
                                {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                            </div>

                            <!-- Logout Form -->
                            <form method="POST" action="{{ route('logout') }}" class="inline">
                                @csrf
                                <button type="submit" title="Sign out" class="inline-flex items-center justify-center p-2 rounded-lg text-slate-400 hover:text-rose-600 hover:bg-rose-50 transition-colors">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                                    </svg>
                                </button>
                            </form>
                        </div>
                    @else
                        <a href="{{ route('login') }}" class="text-sm font-semibold text-slate-600 hover:text-slate-900">Sign in</a>
                        <a href="{{ route('register') }}" class="text-sm font-semibold bg-indigo-600 hover:bg-indigo-700 text-white px-3.5 py-1.5 rounded-lg shadow-xs">Register</a>
                    @endauth
                </div>
            </div>
        </div>

        <!-- Mobile Navigation Menu -->
        <div class="md:hidden border-t border-slate-100 bg-white px-4 py-2 flex items-center justify-around text-xs font-semibold">
            <a href="{{ route('dashboard') }}" class="py-1 px-3 rounded-md {{ request()->routeIs('dashboard') ? 'bg-indigo-50 text-indigo-600' : 'text-slate-600' }}">Dashboard</a>
            <a href="{{ route('students.index') }}" class="py-1 px-3 rounded-md {{ request()->routeIs('students.*') ? 'bg-indigo-50 text-indigo-600' : 'text-slate-600' }}">Students</a>
            <a href="{{ route('departments.index') }}" class="py-1 px-3 rounded-md {{ request()->routeIs('departments.*') ? 'bg-indigo-50 text-indigo-600' : 'text-slate-600' }}">Departments</a>
        </div>
    </header>

    <!-- Flash Notifications / Alerts -->
    <main class="flex-1 max-w-7xl w-full mx-auto px-4 sm:px-6 lg:px-8 py-8">
        @if (session('success'))
            <div id="flash-success" class="mb-6 rounded-xl bg-emerald-50 border border-emerald-200 p-4 shadow-xs flex items-start space-x-3 transition-all duration-300">
                <div class="shrink-0 text-emerald-500">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
                <div class="flex-1 text-sm font-medium text-emerald-800">
                    {{ session('success') }}
                </div>
                <button onclick="document.getElementById('flash-success').remove()" class="text-emerald-400 hover:text-emerald-600">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>
        @endif

        @if (session('error'))
            <div id="flash-error" class="mb-6 rounded-xl bg-rose-50 border border-rose-200 p-4 shadow-xs flex items-start space-x-3 transition-all duration-300">
                <div class="shrink-0 text-rose-500">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
                <div class="flex-1 text-sm font-medium text-rose-800">
                    {{ session('error') }}
                </div>
                <button onclick="document.getElementById('flash-error').remove()" class="text-rose-400 hover:text-rose-600">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>
        @endif

        @if (session('info'))
            <div id="flash-info" class="mb-6 rounded-xl bg-blue-50 border border-blue-200 p-4 shadow-xs flex items-start space-x-3 transition-all duration-300">
                <div class="shrink-0 text-blue-500">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
                <div class="flex-1 text-sm font-medium text-blue-800">
                    {{ session('info') }}
                </div>
                <button onclick="document.getElementById('flash-info').remove()" class="text-blue-400 hover:text-blue-600">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>
        @endif

        <!-- Main Content -->
        {{ $slot ?? '' }}
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="mt-auto border-t border-slate-200/80 bg-white py-6 text-center text-xs text-slate-500">
        <div class="max-w-7xl mx-auto px-4 flex flex-col sm:flex-row items-center justify-between gap-2">
            <div>
                <span class="font-semibold text-slate-700">Ho Khemarak_Final Project</span> &bull; Student Management System
            </div>
    </footer>
</body>
</html>
