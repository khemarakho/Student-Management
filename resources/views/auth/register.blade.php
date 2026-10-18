@extends('layouts.guest')

@section('content')
<div class="mb-6">
    <h2 class="text-xl font-bold text-slate-900">Create an account</h2>
    <p class="text-sm text-slate-500 mt-0.5">Register for access to the Student Management System</p>
</div>

<form method="POST" action="{{ route('register.attempt') }}" class="space-y-4">
    @csrf

    <!-- Full Name -->
    <div>
        <label for="name" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1">Full Name</label>
        <div class="relative">
            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate-400">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
            </div>
            <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus
                class="w-full pl-9 pr-3.5 py-2.5 rounded-xl border {{ $errors->has('name') ? 'border-rose-400 focus:ring-rose-200' : 'border-slate-200 focus:ring-indigo-100 focus:border-indigo-500' }} text-sm focus:outline-none focus:ring-4 transition duration-150"
                placeholder="Enter your full name">
        </div>
        @error('name')
            <p class="mt-1.5 text-xs text-rose-600 font-medium">{{ $message }}</p>
        @enderror
    </div>

    <!-- Email Address -->
    <div>
        <label for="email" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1">Email Address</label>
        <div class="relative">
            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate-400">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207"/></svg>
            </div>
            <input id="email" type="email" name="email" value="{{ old('email') }}" required
                class="w-full pl-9 pr-3.5 py-2.5 rounded-xl border {{ $errors->has('email') ? 'border-rose-400 focus:ring-rose-200' : 'border-slate-200 focus:ring-indigo-100 focus:border-indigo-500' }} text-sm focus:outline-none focus:ring-4 transition duration-150"
                placeholder="Enter your email address">
        </div>
        @error('email')
            <p class="mt-1.5 text-xs text-rose-600 font-medium">{{ $message }}</p>
        @enderror
    </div>

    <!-- Password -->
    <div>
        <label for="password" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1">Password</label>
        <div class="relative">
            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate-400">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
            </div>
            <input id="password" type="password" name="password" required
                class="w-full pl-9 pr-3.5 py-2.5 rounded-xl border {{ $errors->has('password') ? 'border-rose-400 focus:ring-rose-200' : 'border-slate-200 focus:ring-indigo-100 focus:border-indigo-500' }} text-sm focus:outline-none focus:ring-4 transition duration-150"
                placeholder="••••••••">
        </div>
        @error('password')
            <p class="mt-1.5 text-xs text-rose-600 font-medium">{{ $message }}</p>
        @enderror
    </div>

    <!-- Confirm Password -->
    <div>
        <label for="password_confirmation" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1">Confirm Password</label>
        <div class="relative">
            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate-400">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
            </div>
            <input id="password_confirmation" type="password" name="password_confirmation" required
                class="w-full pl-9 pr-3.5 py-2.5 rounded-xl border border-slate-200 focus:ring-indigo-100 focus:border-indigo-500 text-sm focus:outline-none focus:ring-4 transition duration-150"
                placeholder="••••••••">
        </div>
    </div>

    <!-- Submit Button -->
    <button type="submit"
        class="w-full py-2.5 px-4 rounded-xl font-semibold text-sm text-white gradient-brand shadow-lg shadow-indigo-500/25 hover:shadow-indigo-500/40 hover:opacity-95 focus:outline-none focus:ring-4 focus:ring-indigo-200 transition-all duration-200 cursor-pointer">
        Create Account
    </button>
</form>

<div class="mt-6 text-center text-xs text-slate-500">
    Already registered?
    <a href="{{ route('login') }}" class="font-bold text-indigo-600 hover:text-indigo-700 ml-1">Sign in here</a>
</div>
@endsection
