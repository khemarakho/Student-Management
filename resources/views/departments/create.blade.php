@extends('layouts.app')

@section('content')
<div class="max-w-2xl mx-auto space-y-6">
    <!-- Breadcrumb & Header -->
    <div>
        <div class="flex items-center space-x-2 text-xs font-semibold text-slate-400 mb-1">
            <a href="{{ route('dashboard') }}" class="hover:text-indigo-600">Dashboard</a>
            <span>/</span>
            <a href="{{ route('departments.index') }}" class="hover:text-indigo-600">Departments</a>
            <span>/</span>
            <span class="text-slate-700">Create</span>
        </div>
        <h1 class="text-2xl font-bold tracking-tight text-slate-900">Add New Department</h1>
        <p class="text-xs text-slate-500">Register a new academic department or faculty into the relational database</p>
    </div>

    <!-- Form Card -->
    <div class="glass-card rounded-2xl p-6 sm:p-8">
        <form method="POST" action="{{ route('departments.store') }}" class="space-y-6">
            @csrf

            <!-- Department Name -->
            <div>
                <label for="dept_name" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">
                    Department Name <span class="text-rose-500">*</span>
                </label>
                <input type="text" name="dept_name" id="dept_name" value="{{ old('dept_name') }}" required
                    class="w-full px-4 py-2.5 rounded-xl border {{ $errors->has('dept_name') ? 'border-rose-400 focus:ring-rose-200' : 'border-slate-200 focus:ring-indigo-100 focus:border-indigo-500' }} text-sm focus:outline-none focus:ring-4 transition"
                    placeholder="e.g. Faculty of Artificial Intelligence & Robotics">
                @error('dept_name')
                    <p class="mt-1.5 text-xs text-rose-600 font-medium">{{ $message }}</p>
                @enderror
            </div>

            <!-- Manager ID & Location ID Grid -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                <!-- Manager ID -->
                <div>
                    <label for="manager_id" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">
                        Manager / Head ID
                    </label>
                    <input type="text" name="manager_id" id="manager_id" value="{{ old('manager_id') }}"
                        class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:ring-indigo-100 focus:border-indigo-500 text-sm focus:outline-none focus:ring-4 transition"
                        placeholder="e.g. MGR-107">
                    <p class="text-[11px] text-slate-400 mt-1">Unique staff identifier for department chair</p>
                    @error('manager_id')
                        <p class="mt-1.5 text-xs text-rose-600 font-medium">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Location ID -->
                <div>
                    <label for="location_id" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">
                        Office Location
                    </label>
                    <input type="text" name="location_id" id="location_id" value="{{ old('location_id') }}"
                        class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:ring-indigo-100 focus:border-indigo-500 text-sm focus:outline-none focus:ring-4 transition"
                        placeholder="e.g. Building D - Floor 3">
                    <p class="text-[11px] text-slate-400 mt-1">Campus building or room allocation</p>
                    @error('location_id')
                        <p class="mt-1.5 text-xs text-rose-600 font-medium">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Actions -->
            <div class="pt-4 border-t border-slate-100 flex items-center justify-end space-x-3">
                <a href="{{ route('departments.index') }}" class="px-5 py-2.5 rounded-xl text-sm font-semibold text-slate-600 hover:text-slate-900 hover:bg-slate-100 transition">
                    Cancel
                </a>
                <button type="submit" class="px-6 py-2.5 rounded-xl text-sm font-semibold text-white gradient-brand shadow-lg shadow-indigo-500/25 hover:shadow-indigo-500/40 hover:opacity-95 transition cursor-pointer">
                    Save Department
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
