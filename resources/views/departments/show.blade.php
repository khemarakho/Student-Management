@extends('layouts.app')

@section('content')
<div class="space-y-6">
    <!-- Breadcrumb & Header -->
    <div>
        <div class="flex items-center space-x-2 text-xs font-semibold text-slate-400 mb-1">
            <a href="{{ route('dashboard') }}" class="hover:text-indigo-600">Dashboard</a>
            <span>/</span>
            <a href="{{ route('departments.index') }}" class="hover:text-indigo-600">Departments</a>
            <span>/</span>
            <span class="text-slate-700">{{ $department->dept_name }}</span>
        </div>
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div>
                <h1 class="text-2xl font-bold tracking-tight text-slate-900">{{ $department->dept_name }}</h1>
                <p class="text-xs text-slate-500">Department Overview & Enrolled Students Roster</p>
            </div>
            <div class="flex items-center space-x-3">
                <button type="button"
                    data-delete-url="{{ route('departments.destroy', $department) }}"
                    data-delete-name="{{ $department->dept_name }}"
                    data-delete-type="Department"
                    data-delete-details="ID: #{{ $department->dept_id }} &bull; {{ $department->students->count() }} {{ Str::plural('Student', $department->students->count()) }}"
                    data-delete-title="Delete Department"
                    data-delete-warning="{{ $department->students->count() > 0 ? 'Caution: This department currently has ' . $department->students->count() . ' enrolled ' . Str::plural('student', $department->students->count()) . '. Deleting this department will permanently delete all associated students as well.' : 'Are you sure you want to permanently delete this department?' }}"
                    class="inline-flex items-center space-x-1.5 px-3.5 py-2 rounded-xl text-xs font-semibold bg-white border border-rose-200 text-rose-600 hover:bg-rose-50 hover:border-rose-300 transition shadow-xs cursor-pointer">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                    <span>Delete Department</span>
                </button>
                <a href="{{ route('departments.edit', $department) }}" class="inline-flex items-center space-x-1.5 px-4 py-2 rounded-xl text-xs font-semibold bg-white border border-slate-200 text-slate-700 hover:bg-slate-50 transition shadow-xs">
                    <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                    <span>Edit Department</span>
                </a>
                <a href="{{ route('students.create') }}?dept_id={{ $department->dept_id }}" class="inline-flex items-center space-x-1.5 px-4 py-2 rounded-xl text-xs font-semibold text-white gradient-brand shadow-xs hover:opacity-95 transition">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/></svg>
                    <span>Add Student</span>
                </a>
            </div>
        </div>
    </div>

    <!-- Department Detail Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-5">
        <div class="glass-card rounded-2xl p-5">
            <span class="text-xs font-bold uppercase tracking-wider text-slate-400">Primary Key ID</span>
            <div class="text-xl font-mono font-bold text-indigo-600 mt-1">#{{ $department->dept_id }}</div>
            <span class="text-[11px] text-slate-400">Referenced as FK in Students</span>
        </div>
        <div class="glass-card rounded-2xl p-5">
            <span class="text-xs font-bold uppercase tracking-wider text-slate-400">Department Chair / Manager</span>
            <div class="text-lg font-bold text-slate-900 mt-1">{{ $department->manager_id ?? 'None Assigned' }}</div>
            <span class="text-[11px] text-slate-400">Head of Department</span>
        </div>
        <div class="glass-card rounded-2xl p-5">
            <span class="text-xs font-bold uppercase tracking-wider text-slate-400">Campus Office Location</span>
            <div class="text-lg font-bold text-slate-900 mt-1">{{ $department->location_id ?? 'Not Assigned' }}</div>
            <span class="text-[11px] text-slate-400">Physical Facility</span>
        </div>
    </div>

    <!-- Enrolled Students in this Department (HTML Table) -->
    <div class="glass-card rounded-2xl overflow-hidden shadow-xs">
        <div class="p-5 border-b border-slate-100 flex items-center justify-between">
            <div>
                <h3 class="text-base font-bold text-slate-900">Enrolled Students</h3>
                <p class="text-xs text-slate-500">Students officially registered in {{ $department->dept_name }}</p>
            </div>
            <span class="px-3 py-1 rounded-full text-xs font-bold bg-indigo-50 text-indigo-700 border border-indigo-200">
                {{ $department->students->count() }} {{ Str::plural('Student', $department->students->count()) }}
            </span>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm">
                <thead>
                    <tr class="bg-slate-50/80 border-b border-slate-200/80 text-xs font-bold uppercase tracking-wider text-slate-500">
                        <th class="py-3 px-4">Student ID</th>
                        <th class="py-3 px-4">Name</th>
                        <th class="py-3 px-4">Gender</th>
                        <th class="py-3 px-4">Enrollment Code</th>
                        <th class="py-3 px-4">Date of Birth</th>
                        <th class="py-3 px-4">Enrolled Date</th>
                        <th class="py-3 px-4 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 bg-white">
                    @forelse ($department->students as $student)
                        <tr class="hover:bg-indigo-50/30 transition-colors">
                            <td class="py-3 px-4 font-mono text-xs text-slate-500">#{{ $student->student_id }}</td>
                            <td class="py-3 px-4 font-semibold text-slate-900">
                                <a href="{{ route('students.show', $student) }}" class="hover:text-indigo-600 transition">
                                    {{ $student->student_name }}
                                </a>
                            </td>
                            <td class="py-3 px-4">
                                @if ($student->gender === 'Male')
                                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-semibold bg-blue-50 text-blue-700 border border-blue-200">Male</span>
                                @elseif ($student->gender === 'Female')
                                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-semibold bg-pink-50 text-pink-700 border border-pink-200">Female</span>
                                @else
                                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-semibold bg-slate-100 text-slate-700">{{ $student->gender }}</span>
                                @endif
                            </td>
                            <td class="py-3 px-4 font-mono text-xs text-slate-600 font-semibold">{{ $student->enrollment }}</td>
                            <td class="py-3 px-4 text-xs text-slate-600">{{ $student->dob ? $student->dob->format('M d, Y') : 'N/A' }}</td>
                            <td class="py-3 px-4 text-xs text-slate-600">{{ $student->enrollment_date ? $student->enrollment_date->format('M d, Y') : 'N/A' }}</td>
                            <td class="py-3 px-4 text-right">
                                <div class="inline-flex items-center space-x-1">
                                    <a href="{{ route('students.show', $student) }}" title="View Student Profile" class="p-1.5 rounded-lg text-slate-400 hover:text-indigo-600 hover:bg-indigo-50 transition">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                    </a>
                                    <a href="{{ route('students.edit', $student) }}" title="Edit Student" class="p-1.5 rounded-lg text-slate-400 hover:text-amber-600 hover:bg-amber-50 transition">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                    </a>
                                    <button type="button"
                                        title="Delete Student"
                                        data-delete-url="{{ route('students.destroy', $student) }}"
                                        data-delete-name="{{ $student->student_name }}"
                                        data-delete-type="Student"
                                        data-delete-details="Enrollment: {{ $student->enrollment }} &bull; ID: #{{ $student->student_id }}"
                                        data-delete-title="Delete Student Record"
                                        data-delete-warning="This will permanently delete {{ $student->student_name }}'s entire profile and academic record from {{ $department->dept_name }}."
                                        class="p-1.5 rounded-lg text-slate-400 hover:text-rose-600 hover:bg-rose-50 transition cursor-pointer">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="py-8 text-center text-xs text-slate-400">
                                No students currently enrolled in this department.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
