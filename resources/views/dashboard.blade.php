@extends('layouts.app')

@section('content')
<div class="space-y-8">
    <!-- Welcome Header / Hero Banner -->
    <div class="relative overflow-hidden rounded-2xl bg-gradient-to-r from-slate-900 via-indigo-950 to-slate-900 p-8 text-white shadow-xl">
        <div class="absolute -right-10 -bottom-10 w-80 h-80 rounded-full bg-indigo-500/20 blur-3xl pointer-events-none"></div>
        <div class="relative z-10 flex flex-col md:flex-row md:items-center justify-between gap-6">
            <div>
                <div class="inline-flex items-center space-x-2 px-3 py-1 rounded-full bg-white/10 backdrop-blur-md text-xs font-semibold text-indigo-200 mb-3 border border-white/10">
                    <span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span>
                    <span>System Live &bull; Ho Khemarak Final Project</span>
                </div>
                <h1 class="text-2xl sm:text-3xl font-extrabold tracking-tight">
                    Welcome back, <span class="gradient-text bg-gradient-to-r from-indigo-200 via-purple-200 to-pink-200">{{ Auth::user()->name }}</span>
                </h1>
                <p class="text-sm text-slate-300 mt-2 max-w-xl">
                    Student Management System .
                </p>
            </div>

            <!-- Action Buttons -->
            <div class="flex flex-wrap items-center gap-3">
                <a href="{{ route('students.create') }}" class="inline-flex items-center space-x-2 px-4 py-2.5 rounded-xl font-semibold text-sm text-white gradient-brand shadow-lg shadow-indigo-500/25 hover:shadow-indigo-500/40 hover:opacity-95 transition-all">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/></svg>
                    <span>Register Student</span>
                </a>
                <a href="{{ route('departments.create') }}" class="inline-flex items-center space-x-2 px-4 py-2.5 rounded-xl font-semibold text-sm text-slate-200 bg-white/10 hover:bg-white/20 backdrop-blur-md border border-white/10 transition-all">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/></svg>
                    <span>Add Department</span>
                </a>
            </div>
        </div>
    </div>

    <!-- Analytics Stat Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
        <!-- Total Students -->
        <div class="glass-card rounded-2xl p-6 relative overflow-hidden group hover:border-indigo-300 transition-colors">
            <div class="flex items-center justify-between">
                <div>
                    <span class="text-xs font-bold uppercase tracking-wider text-slate-400">Total Students</span>
                    <h3 class="text-3xl font-extrabold text-slate-900 mt-1">{{ number_format($totalStudents) }}</h3>
                    <p class="text-xs text-emerald-600 font-semibold mt-1 flex items-center gap-1">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/></svg>
                        <span>Active Enrolled</span>
                    </p>
                </div>
                <div class="w-12 h-12 rounded-xl bg-indigo-50 text-indigo-600 flex items-center justify-center group-hover:scale-110 transition-transform">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                </div>
            </div>
        </div>

        <!-- Total Departments -->
        <div class="glass-card rounded-2xl p-6 relative overflow-hidden group hover:border-purple-300 transition-colors">
            <div class="flex items-center justify-between">
                <div>
                    <span class="text-xs font-bold uppercase tracking-wider text-slate-400">Departments</span>
                    <h3 class="text-3xl font-extrabold text-slate-900 mt-1">{{ number_format($totalDepartments) }}</h3>
                    <p class="text-xs text-purple-600 font-semibold mt-1 flex items-center gap-1">
                        <span>Academic Faculties</span>
                    </p>
                </div>
                <div class="w-12 h-12 rounded-xl bg-purple-50 text-purple-600 flex items-center justify-center group-hover:scale-110 transition-transform">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                </div>
            </div>
        </div>

        <!-- Gender Breakdown -->
        <div class="glass-card rounded-2xl p-6 relative overflow-hidden group hover:border-blue-300 transition-colors">
            <div class="flex items-center justify-between">
                <div>
                    <span class="text-xs font-bold uppercase tracking-wider text-slate-400">Gender Ratio</span>
                    <div class="flex items-baseline space-x-2 mt-1">
                        <span class="text-2xl font-bold text-blue-600">{{ $maleCount }} <span class="text-xs font-normal text-slate-400">M</span></span>
                        <span class="text-slate-300">/</span>
                        <span class="text-2xl font-bold text-pink-500">{{ $femaleCount }} <span class="text-xs font-normal text-slate-400">F</span></span>
                    </div>
                    <p class="text-xs text-slate-500 font-medium mt-1">
                        {{ $otherCount > 0 ? $otherCount . ' other' : 'Balanced distribution' }}
                    </p>
                </div>
                <div class="w-12 h-12 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center group-hover:scale-110 transition-transform">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                </div>
            </div>
        </div>

        <!-- System Staff -->
        <div class="glass-card rounded-2xl p-6 relative overflow-hidden group hover:border-emerald-300 transition-colors">
            <div class="flex items-center justify-between">
                <div>
                    <span class="text-xs font-bold uppercase tracking-wider text-slate-400">Registered Staff</span>
                    <h3 class="text-3xl font-extrabold text-slate-900 mt-1">{{ number_format($totalUsers) }}</h3>
                    <p class="text-xs text-emerald-600 font-semibold mt-1 flex items-center gap-1">
                        <span>Authorized Users</span>
                    </p>
                </div>
                <div class="w-12 h-12 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center group-hover:scale-110 transition-transform">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                </div>
            </div>
        </div>
    </div>

    <!-- Dual Content Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Recent Students Table (2 cols) -->
        <div class="lg:col-span-2 glass-card rounded-2xl p-6">
            <div class="flex items-center justify-between mb-5">
                <div>
                    <h2 class="text-lg font-bold text-slate-900">Recently Enrolled Students</h2>
                    <p class="text-xs text-slate-500">Latest students registered in the system</p>
                </div>
                <a href="{{ route('students.index') }}" class="text-xs font-bold text-indigo-600 hover:text-indigo-800 flex items-center gap-1">
                    <span>View all ({{ $totalStudents }})</span>
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                </a>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm">
                    <thead>
                        <tr class="border-b border-slate-100 text-xs font-bold uppercase tracking-wider text-slate-400">
                            <th class="py-3 px-2">ID</th>
                            <th class="py-3 px-3">Student Name</th>
                            <th class="py-3 px-3">Gender</th>
                            <th class="py-3 px-3">Department (Relational)</th>
                            <th class="py-3 px-3 text-right">Action</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse ($recentStudents as $student)
                            <tr class="hover:bg-slate-50/70 transition-colors">
                                <td class="py-3 px-2 font-mono text-xs text-slate-500">#{{ $student->student_id }}</td>
                                <td class="py-3 px-3">
                                    <div class="font-semibold text-slate-900">{{ $student->student_name }}</div>
                                    <div class="text-xs text-slate-400 font-mono">{{ $student->enrollment }}</div>
                                </td>
                                <td class="py-3 px-3">
                                    @if ($student->gender === 'Male')
                                        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-semibold bg-blue-50 text-blue-700 border border-blue-200">Male</span>
                                    @elseif ($student->gender === 'Female')
                                        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-semibold bg-pink-50 text-pink-700 border border-pink-200">Female</span>
                                    @else
                                        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-semibold bg-slate-100 text-slate-700">{{ $student->gender }}</span>
                                    @endif
                                </td>
                                <td class="py-3 px-3">
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-lg text-xs font-medium bg-indigo-50 text-indigo-700 border border-indigo-100">
                                        {{ $student->department->dept_name ?? 'N/A' }}
                                    </span>
                                </td>
                                <td class="py-3 px-3 text-right">
                                    <a href="{{ route('students.show', $student) }}" class="inline-flex items-center px-2.5 py-1 rounded-lg text-xs font-semibold text-slate-700 bg-slate-100 hover:bg-indigo-50 hover:text-indigo-600 transition-colors">
                                        View
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="py-8 text-center text-sm text-slate-400">
                                    No students registered yet.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Departments Distribution List (1 col) -->
        <div class="glass-card rounded-2xl p-6">
            <div class="flex items-center justify-between mb-5">
                <div>
                    <h2 class="text-lg font-bold text-slate-900">Departments</h2>
                    <p class="text-xs text-slate-500">Academic units & student capacity</p>
                </div>
                <a href="{{ route('departments.index') }}" class="text-xs font-bold text-indigo-600 hover:text-indigo-800 flex items-center gap-1">
                    <span>Manage</span>
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                </a>
            </div>

            <div class="space-y-3.5">
                @forelse ($departments as $dept)
                    <div class="p-3 rounded-xl border border-slate-100 hover:border-indigo-200 hover:bg-slate-50/60 transition-all">
                        <div class="flex items-start justify-between gap-2">
                            <div>
                                <h4 class="text-xs font-bold text-slate-800 leading-snug">{{ $dept->dept_name }}</h4>
                                <div class="text-[11px] text-slate-400 mt-0.5 flex items-center gap-1.5">
                                    <span>Mgr: {{ $dept->manager_id ?? 'Unassigned' }}</span>
                                    <span>&bull;</span>
                                    <span>{{ $dept->location_id ?? 'No location' }}</span>
                                </div>
                            </div>
                            <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-bold bg-indigo-50 text-indigo-700 border border-indigo-200 shrink-0">
                                {{ $dept->students_count }} {{ Str::plural('student', $dept->students_count) }}
                            </span>
                        </div>
                    </div>
                @empty
                    <p class="text-center py-6 text-xs text-slate-400">No departments added yet.</p>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection
