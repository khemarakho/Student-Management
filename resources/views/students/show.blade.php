@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">
    <!-- Breadcrumb & Header -->
    <div>
        <div class="flex items-center space-x-2 text-xs font-semibold text-slate-400 mb-1">
            <a href="{{ route('dashboard') }}" class="hover:text-indigo-600">Dashboard</a>
            <span>/</span>
            <a href="{{ route('students.index') }}" class="hover:text-indigo-600">Students</a>
            <span>/</span>
            <span class="text-slate-700">{{ $student->student_name }}</span>
        </div>
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div>
                <h1 class="text-2xl font-bold tracking-tight text-slate-900">{{ $student->student_name }}</h1>
                <p class="text-xs text-slate-500">Student Profile & Academic Record (ID: #{{ $student->student_id }})</p>
            </div>
            <div class="flex items-center space-x-3">
                <a href="{{ route('students.index') }}" class="inline-flex items-center space-x-1.5 px-3.5 py-2 rounded-xl text-xs font-semibold text-slate-600 bg-slate-100 hover:bg-slate-200 transition">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                    <span>Back to List</span>
                </a>
                <a href="{{ route('students.edit', $student) }}" class="inline-flex items-center space-x-1.5 px-4 py-2 rounded-xl text-xs font-semibold text-white gradient-brand shadow-xs hover:opacity-95 transition">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                    <span>Edit Profile</span>
                </a>
            </div>
        </div>
    </div>

    <!-- Student Profile Hero Card -->
    <div class="glass-card rounded-2xl p-6 sm:p-8 relative overflow-hidden">
        <div class="flex flex-col sm:flex-row sm:items-center gap-6 pb-6 border-b border-slate-100">
            <div class="w-20 h-20 rounded-2xl gradient-brand text-white font-extrabold text-2xl flex items-center justify-center shadow-lg shadow-indigo-500/20 shrink-0">
                {{ strtoupper(substr($student->student_name, 0, 1)) }}
            </div>
            <div class="space-y-1.5">
                <div class="flex flex-wrap items-center gap-2">
                    <h2 class="text-xl font-bold text-slate-900">{{ $student->student_name }}</h2>
                    <span class="px-2.5 py-0.5 rounded-full text-xs font-mono font-bold bg-slate-100 text-slate-700 border border-slate-200">
                        {{ $student->enrollment }}
                    </span>
                    @if ($student->gender === 'Male')
                        <span class="px-2.5 py-0.5 rounded-full text-xs font-semibold bg-blue-50 text-blue-700 border border-blue-200">Male</span>
                    @elseif ($student->gender === 'Female')
                        <span class="px-2.5 py-0.5 rounded-full text-xs font-semibold bg-pink-50 text-pink-700 border border-pink-200">Female</span>
                    @else
                        <span class="px-2.5 py-0.5 rounded-full text-xs font-semibold bg-slate-100 text-slate-700">{{ $student->gender }}</span>
                    @endif
                </div>
                <div class="text-xs text-slate-500 flex flex-wrap items-center gap-2">
                    <span>Student ID: <strong class="text-slate-800">#{{ $student->student_id }}</strong></span>
                    <span>&bull;</span>
                    <span>Registered: {{ $student->created_at ? $student->created_at->format('M d, Y') : 'N/A' }}</span>
                </div>
            </div>
        </div>

        <!-- Details Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 pt-6">
            <!-- Academic Information (Relational Database) -->
            <div class="space-y-4">
                <div class="flex items-center space-x-2 text-xs font-bold uppercase tracking-wider text-indigo-700">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                    <span>Academic Department (FK: {{ $student->dept_id }})</span>
                </div>

                <div class="p-4 rounded-xl bg-slate-50/70 border border-slate-100 space-y-3">
                    <div>
                        <span class="text-[11px] font-semibold uppercase tracking-wider text-slate-400">Department Name</span>
                        <div class="text-sm font-bold text-slate-900 mt-0.5">
                            @if ($student->department)
                                <a href="{{ route('departments.show', $student->department) }}" class="text-indigo-600 hover:text-indigo-800 underline">
                                    {{ $student->department->dept_name }}
                                </a>
                            @else
                                <span class="text-slate-400">None</span>
                            @endif
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-2 text-xs">
                        <div>
                            <span class="text-[11px] font-semibold uppercase tracking-wider text-slate-400">Manager ID</span>
                            <div class="font-medium text-slate-700 mt-0.5">{{ $student->department->manager_id ?? 'N/A' }}</div>
                        </div>
                        <div>
                            <span class="text-[11px] font-semibold uppercase tracking-wider text-slate-400">Location</span>
                            <div class="font-medium text-slate-700 mt-0.5">{{ $student->department->location_id ?? 'N/A' }}</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Personal & Enrollment Information -->
            <div class="space-y-4">
                <div class="flex items-center space-x-2 text-xs font-bold uppercase tracking-wider text-slate-700">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                    <span>Personal & Enrollment Dates</span>
                </div>

                <div class="p-4 rounded-xl bg-slate-50/70 border border-slate-100 space-y-3">
                    <div class="grid grid-cols-2 gap-3 text-xs">
                        <div>
                            <span class="text-[11px] font-semibold uppercase tracking-wider text-slate-400">Date of Birth</span>
                            <div class="text-sm font-bold text-slate-800 mt-0.5">
                                {{ $student->dob ? $student->dob->format('F d, Y') : 'N/A' }}
                            </div>
                            @if ($student->dob)
                                <span class="text-[10px] text-slate-400">({{ $student->dob->age }} years old)</span>
                            @endif
                        </div>
                        <div>
                            <span class="text-[11px] font-semibold uppercase tracking-wider text-slate-400">Enrollment Date</span>
                            <div class="text-sm font-bold text-slate-800 mt-0.5">
                                {{ $student->enrollment_date ? $student->enrollment_date->format('F d, Y') : 'N/A' }}
                            </div>
                        </div>
                    </div>

                    <div>
                        <span class="text-[11px] font-semibold uppercase tracking-wider text-slate-400">Enrollment Code</span>
                        <div class="font-mono text-xs font-bold text-slate-700 mt-0.5">
                            {{ $student->enrollment }}
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Description / Notes -->
        <div class="mt-6 pt-6 border-t border-slate-100">
            <span class="text-xs font-bold uppercase tracking-wider text-slate-500 block mb-2">Student Notes & Description</span>
            <div class="p-4 rounded-xl bg-slate-50 border border-slate-100 text-sm text-slate-700 leading-relaxed">
                {{ $student->description ?: 'No additional notes provided for this student.' }}
            </div>
        </div>

        <!-- Footer Actions -->
        <div class="mt-8 pt-6 border-t border-slate-100 flex items-center justify-between">
            <form method="POST" action="{{ route('students.destroy', $student) }}"
                onsubmit="return confirm('Are you sure you want to permanently delete this student record?');">
                @csrf
                @method('DELETE')
                <button type="submit" class="px-4 py-2 rounded-xl text-xs font-semibold text-rose-600 hover:text-rose-700 hover:bg-rose-50 transition cursor-pointer">
                    Delete Student Record
                </button>
            </form>

            <a href="{{ route('students.edit', $student) }}" class="px-5 py-2.5 rounded-xl text-xs font-semibold text-white gradient-brand shadow-md shadow-indigo-500/20 hover:opacity-95 transition">
                Edit Record
            </a>
        </div>
    </div>
</div>
@endsection
