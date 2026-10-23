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
            <span class="text-slate-700">Edit #{{ $department->dept_id }}</span>
        </div>
        <h1 class="text-2xl font-bold tracking-tight text-slate-900">Edit Department</h1>
        <p class="text-xs text-slate-500">Update academic department details (Primary Key ID: {{ $department->dept_id }})</p>
    </div>

    <!-- Form Card -->
    <div class="glass-card rounded-2xl p-6 sm:p-8">
        <form method="POST" action="{{ route('departments.update', $department) }}" class="space-y-6">
            @csrf
            @method('PUT')

            <!-- Department Name -->
            <div>
                <label for="dept_name" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">
                    Department Name <span class="text-rose-500">*</span>
                </label>
                <input type="text" name="dept_name" id="dept_name" value="{{ old('dept_name', $department->dept_name) }}" required
                    class="w-full px-4 py-2.5 rounded-xl border {{ $errors->has('dept_name') ? 'border-rose-400 focus:ring-rose-200' : 'border-slate-200 focus:ring-indigo-100 focus:border-indigo-500' }} text-sm focus:outline-none focus:ring-4 transition">
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
                    <input type="text" name="manager_id" id="manager_id" value="{{ old('manager_id', $department->manager_id) }}"
                        class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:ring-indigo-100 focus:border-indigo-500 text-sm focus:outline-none focus:ring-4 transition">
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
                    <input type="text" name="location_id" id="location_id" value="{{ old('location_id', $department->location_id) }}"
                        class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:ring-indigo-100 focus:border-indigo-500 text-sm focus:outline-none focus:ring-4 transition">
                    <p class="text-[11px] text-slate-400 mt-1">Campus building or room allocation</p>
                    @error('location_id')
                        <p class="mt-1.5 text-xs text-rose-600 font-medium">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Actions -->
            @php $studentsCount = $department->students()->count(); @endphp
            <div class="pt-4 border-t border-slate-100 flex flex-col sm:flex-row items-center justify-between gap-3">
                <button type="button"
                    data-delete-url="{{ route('departments.destroy', $department) }}"
                    data-delete-name="{{ $department->dept_name }}"
                    data-delete-type="Department"
                    data-delete-details="ID: #{{ $department->dept_id }} &bull; {{ $studentsCount }} {{ Str::plural('Student', $studentsCount) }}"
                    data-delete-title="Delete Department"
                    data-delete-warning="{{ $studentsCount > 0 ? 'Caution: This department currently has ' . $studentsCount . ' enrolled ' . Str::plural('student', $studentsCount) . '. Deleting this department will permanently delete all associated students as well.' : 'Are you sure you want to permanently delete this department?' }}"
                    class="w-full sm:w-auto inline-flex items-center justify-center space-x-1.5 px-4 py-2.5 rounded-xl text-xs font-semibold text-rose-600 hover:text-rose-700 hover:bg-rose-50 border border-rose-200 transition cursor-pointer">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                    <span>Delete Department</span>
                </button>

                <div class="flex items-center space-x-3 w-full sm:w-auto justify-end">
                    <a href="{{ route('departments.index') }}" class="px-5 py-2.5 rounded-xl text-sm font-semibold text-slate-600 hover:text-slate-900 hover:bg-slate-100 transition">
                        Cancel
                    </a>
                    <button type="submit" class="px-6 py-2.5 rounded-xl text-sm font-semibold text-white gradient-brand shadow-lg shadow-indigo-500/25 hover:shadow-indigo-500/40 hover:opacity-95 transition cursor-pointer">
                        Update Department
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
