<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full bg-slate-900">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $title ?? 'Portal' }} | Student Management System</title>

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Vite Assets -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-full font-sans antialiased text-slate-800 flex items-center justify-center p-4 bg-gradient-to-br from-slate-950 via-slate-900 to-indigo-950 relative overflow-hidden">
    <!-- Ambient Glow Blobs -->
    <div class="absolute -top-40 -left-40 w-96 h-96 bg-indigo-600/20 rounded-full blur-3xl pointer-events-none"></div>
    <div class="absolute -bottom-40 -right-40 w-96 h-96 bg-purple-600/20 rounded-full blur-3xl pointer-events-none"></div>

    <div class="w-full max-w-md relative z-10 py-8">
        <!-- Logo Header -->
        <div class="text-center mb-8">
            <div class="inline-flex w-16 h-16 rounded-2xl gradient-brand items-center justify-center text-white shadow-xl shadow-indigo-500/25 mb-4 transform hover:scale-105 transition-transform duration-300">
                <svg class="w-9 h-9" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5zm0 0l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14zm-4 6v-7.5l4-2.222" />
                </svg>
            </div>
            <h1 class="text-2xl font-extrabold text-white tracking-tight">Student Management System</h1>
            <p class="text-sm text-slate-400 mt-1">Hok Khemarak Final Project &bull; Laravel 13</p>
        </div>

        <!-- Card Container -->
        <div class="bg-white/95 backdrop-blur-xl rounded-2xl shadow-2xl p-8 border border-white/20 relative">
            <div class="absolute top-0 left-0 right-0 h-1.5 gradient-brand rounded-t-2xl"></div>

            @if (session('success'))
                <div class="mb-5 rounded-xl bg-emerald-50 border border-emerald-200 p-3.5 text-sm text-emerald-800 font-medium">
                    {{ session('success') }}
                </div>
            @endif

            @if (session('info'))
                <div class="mb-5 rounded-xl bg-blue-50 border border-blue-200 p-3.5 text-sm text-blue-800 font-medium">
                    {{ session('info') }}
                </div>
            @endif

            @if (session('error'))
                <div class="mb-5 rounded-xl bg-rose-50 border border-rose-200 p-3.5 text-sm text-rose-800 font-medium">
                    {{ session('error') }}
                </div>
            @endif

            {{ $slot ?? '' }}
            @yield('content')
        </div>

        <p class="text-center text-xs text-slate-500 mt-6">
            &copy; {{ date('Y') }} Hok Khemarak &bull; Built with Laravel & Tailwind CSS
        </p>
    </div>
</body>
</html>
