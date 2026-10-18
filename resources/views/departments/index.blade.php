@extends('layouts.app')

@section('content')
<div class="space-y-6">
    <!-- Header with Breadcrumbs & Action -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <div class="flex items-center space-x-2 text-xs font-semibold text-slate-400 mb-1">
                <a href="{{ route('dashboard') }}" class="hover:text-indigo-600">Dashboard</a>
                <span>/</span>
                <span class="text-slate-700">Departments</span>
            </div>
            <h1 class="text-2xl font-bold tracking-tight text-slate-900">Academic Departments</h1>
            <p class="text-xs text-slate-500">Manage academic departments, faculty leaders, and office locations</p>
        </div>

        <a href="{{ route('departments.create') }}" class="inline-flex items-center space-x-2 px-4 py-2.5 rounded-xl font-semibold text-sm text-white gradient-brand shadow-lg shadow-indigo-500/20 hover:shadow-indigo-500/35 hover:opacity-95 transition-all self-start sm:self-auto cursor-pointer">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/></svg>
            <span>Add Department</span>
        </a>
    </div>

    <!-- Search & Filter Bar -->
    <div class="glass-card rounded-2xl p-4">
        <form method="GET" action="{{ route('departments.index') }}" class="flex flex-col sm:flex-row items-center gap-3">
            <div class="relative flex-1 w-full">
                <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                </div>
                <input type="text" name="search" value="{{ $search ?? '' }}"
                    class="w-full pl-10 pr-4 py-2 rounded-xl border border-slate-200 text-sm focus:outline-none focus:ring-4 focus:ring-indigo-100 focus:border-indigo-500 transition"
                    placeholder="Search department name, manager ID, or building location...">
            </div>

            <div class="flex items-center gap-2 w-full sm:w-auto">
                <button type="submit" class="w-full sm:w-auto px-4 py-2 rounded-xl bg-slate-900 hover:bg-slate-800 text-white text-sm font-semibold transition cursor-pointer">
                    Search
                </button>
                @if ($search)
                    <a href="{{ route('departments.index') }}" class="px-3.5 py-2 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 text-sm font-semibold transition">
                        Clear
                    </a>
                @endif
            </div>
        </form>
    </div>

    <!-- HTML Table for Departments -->
    <div class="glass-card rounded-2xl overflow-hidden shadow-xs">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm">
                <thead>
                    <tr class="bg-slate-50/80 border-b border-slate-200/80 text-xs font-bold uppercase tracking-wider text-slate-500">
                        <th class="py-3.5 px-4">Dept ID (PK)</th>
                        <th class="py-3.5 px-4">Department Name</th>
                        <th class="py-3.5 px-4">Manager ID</th>
                        <th class="py-3.5 px-4">Location</th>
                        <th class="py-3.5 px-4 text-center">Enrolled Students</th>
                        <th class="py-3.5 px-4 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 bg-white">
                    @forelse ($departments as $dept)
                        <tr class="hover:bg-indigo-50/40 transition-colors">
                            <td class="py-3.5 px-4 font-mono font-bold text-xs text-indigo-600">
                                #{{ $dept->dept_id }}
                            </td>
                            <td class="py-3.5 px-4">
                                <a href="{{ route('departments.show', $dept) }}" class="font-bold text-slate-900 hover:text-indigo-600 transition-colors">
                                    {{ $dept->dept_name }}
                                </a>
                            </td>
                            <td class="py-3.5 px-4">
                                <span class="font-mono text-xs px-2 py-0.5 rounded bg-slate-100 text-slate-700 border border-slate-200">
                                    {{ $dept->manager_id ?? 'N/A' }}
                                </span>
                            </td>
                            <td class="py-3.5 px-4 text-slate-600 text-xs font-medium">
                                {{ $dept->location_id ?? 'Not specified' }}
                            </td>
                            <td class="py-3.5 px-4 text-center">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold bg-indigo-50 text-indigo-700 border border-indigo-200">
                                    {{ $dept->students_count }} {{ Str::plural('student', $dept->students_count) }}
                                </span>
                            </td>
                            <td class="py-3.5 px-4 text-right">
                                <div class="inline-flex items-center space-x-1">
                                    <a href="{{ route('departments.show', $dept) }}" title="View details & students"
                                        class="p-1.5 rounded-lg text-slate-500 hover:text-indigo-600 hover:bg-indigo-50 transition">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                    </a>
                                    <a href="{{ route('departments.edit', $dept) }}" title="Edit Department"
                                        class="p-1.5 rounded-lg text-slate-500 hover:text-amber-600 hover:bg-amber-50 transition">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                    </a>
                                    <form method="POST" action="{{ route('departments.destroy', $dept) }}" class="inline"
                                        onsubmit="return confirm('Are you sure you want to delete this department? Related students may also be removed.');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" title="Delete Department"
                                            class="p-1.5 rounded-lg text-slate-500 hover:text-rose-600 hover:bg-rose-50 transition cursor-pointer">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="py-12 text-center">
                                <div class="max-w-sm mx-auto text-center">
                                    <div class="w-12 h-12 rounded-xl bg-slate-100 text-slate-400 mx-auto flex items-center justify-center mb-3">
                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                                    </div>
                                    <h3 class="text-sm font-bold text-slate-800">No departments found</h3>
                                    <p class="text-xs text-slate-500 mt-1">Try adjusting your search criteria or create a new department.</p>
                                    <a href="{{ route('departments.create') }}" class="mt-4 inline-flex items-center text-xs font-semibold text-indigo-600 hover:text-indigo-800">
                                        + Create Department
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if ($departments->hasPages())
            <div class="p-4 border-t border-slate-100 bg-slate-50/50">
                {{ $departments->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
