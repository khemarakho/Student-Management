@extends('layouts.guest')

@section('content')
<div class="mb-6">
    <h2 class="text-xl font-bold text-slate-900">Sign in to your account</h2>
    <p class="text-sm text-slate-500 mt-0.5">Enter your academic portal credentials below</p>
</div>

<form method="POST" action="{{ route('login.attempt') }}" class="space-y-4">
    @csrf

    <!-- Email Address -->
    <div>
        <label for="email" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1">Email Address</label>
        <div class="relative">
            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate-400">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207"/></svg>
            </div>
            <input id="email" type="email" name="email" value="{{ old('email', ) }}" required autofocus
                class="w-full pl-9 pr-3.5 py-2.5 rounded-xl border {{ $errors->has('email') ? 'border-rose-400 focus:ring-rose-200' : 'border-slate-200 focus:ring-indigo-100 focus:border-indigo-500' }} text-sm focus:outline-none focus:ring-4 transition duration-150"
                placeholder="Enter your email address">
        </div>
        @error('email')
            <p class="mt-1.5 text-xs text-rose-600 font-medium">{{ $message }}</p>
        @enderror
    </div>

    <!-- Password -->
    <div>
        <div class="flex items-center justify-between mb-1">
            <label for="password" class="block text-xs font-bold uppercase tracking-wider text-slate-700">Password</label>
        </div>
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

    <!-- Remember Me -->
    <div class="flex items-center justify-between pt-1">
        <label class="flex items-center space-x-2 cursor-pointer">
            <input type="checkbox" name="remember" class="w-4 h-4 text-indigo-600 border-slate-300 rounded focus:ring-indigo-500">
            <span class="text-xs text-slate-600 select-none">Remember this device</span>
        </label>
    </div>

    <!-- Submit Button -->
    <button type="submit"
        class="w-full py-2.5 px-4 rounded-xl font-semibold text-sm text-white gradient-brand shadow-lg shadow-indigo-500/25 hover:shadow-indigo-500/40 hover:opacity-95 focus:outline-none focus:ring-4 focus:ring-indigo-200 transition-all duration-200 cursor-pointer">
        Sign In
    </button>
</form>

<div class="mt-6 text-center text-xs text-slate-500">
    Don't have an account yet?
    <a href="{{ route('register') }}" class="font-bold text-indigo-600 hover:text-indigo-700 ml-1">Create an account</a>
</div>
@endsection
