@extends('layouts.app')

@section('content')
<div class="space-y-6">
    <!-- Header with Breadcrumbs & Action -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <div class="flex items-center space-x-2 text-xs font-semibold text-slate-400 mb-1">
                <a href="{{ route('dashboard') }}" class="hover:text-indigo-600">Dashboard</a>
                <span>/</span>
                <span class="text-slate-700">Students</span>
            </div>
            <h1 class="text-2xl font-bold tracking-tight text-slate-900">Student Directory</h1>
            <p class="text-xs text-slate-500">Student Management System &bull; Relational Data with Department</p>
        </div>

        <a href="{{ route('students.create') }}" class="inline-flex items-center space-x-2 px-4 py-2.5 rounded-xl font-semibold text-sm text-white gradient-brand shadow-lg shadow-indigo-500/20 hover:shadow-indigo-500/35 hover:opacity-95 transition-all self-start sm:self-auto cursor-pointer">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/></svg>
            <span>Register New Student</span>
        </a>
    </div>

    <!-- Filter & Search Panel -->
    <div class="glass-card rounded-2xl p-5 shadow-xs">
        <form method="GET" action="{{ route('students.index') }}" class="space-y-4">
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-3">
                <!-- Search by Student Name -->
                <div>
                    <label for="search" class="block text-xs font-bold uppercase tracking-wider text-slate-600 mb-1">Search Name / ID</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate-400">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                        </div>
                        <input type="text" name="search" id="search" value="{{ $search ?? '' }}"
                            class="w-full pl-9 pr-3 py-2 rounded-xl border border-slate-200 text-xs focus:outline-none focus:ring-4 focus:ring-indigo-100 focus:border-indigo-500 transition"
                            placeholder="Student name, enrollment, ID...">
                    </div>
                </div>

                <!-- Filter by Department (FK Relational) -->
                <div>
                    <label for="dept_id" class="block text-xs font-bold uppercase tracking-wider text-slate-600 mb-1">Department</label>
                    <select name="dept_id" id="dept_id"
                        class="w-full px-3 py-2 rounded-xl border border-slate-200 text-xs focus:outline-none focus:ring-4 focus:ring-indigo-100 focus:border-indigo-500 transition bg-white">
                        <option value="">All Academic Departments</option>
                        @foreach ($departments as $dept)
                            <option value="{{ $dept->dept_id }}" {{ (string)$deptId === (string)$dept->dept_id ? 'selected' : '' }}>
                                {{ $dept->dept_name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Filter by Gender -->
                <div>
                    <label for="gender" class="block text-xs font-bold uppercase tracking-wider text-slate-600 mb-1">Gender</label>
                    <select name="gender" id="gender"
                        class="w-full px-3 py-2 rounded-xl border border-slate-200 text-xs focus:outline-none focus:ring-4 focus:ring-indigo-100 focus:border-indigo-500 transition bg-white">
                        <option value="">All Genders</option>
                        <option value="Male" {{ $gender === 'Male' ? 'selected' : '' }}>Male</option>
                        <option value="Female" {{ $gender === 'Female' ? 'selected' : '' }}>Female</option>
                        <option value="Other" {{ $gender === 'Other' ? 'selected' : '' }}>Other</option>
                    </select>
                </div>

                <!-- Sort Order -->
                <div>
                    <label for="sort_by" class="block text-xs font-bold uppercase tracking-wider text-slate-600 mb-1">Sort By</label>
                    <div class="flex items-center space-x-2">
                        <select name="sort_by" id="sort_by"
                            class="w-full px-3 py-2 rounded-xl border border-slate-200 text-xs focus:outline-none focus:ring-4 focus:ring-indigo-100 focus:border-indigo-500 transition bg-white">
                            <option value="student_id" {{ $sortBy === 'student_id' ? 'selected' : '' }}>Student ID</option>
                            <option value="student_name" {{ $sortBy === 'student_name' ? 'selected' : '' }}>Name</option>
                            <option value="dob" {{ $sortBy === 'dob' ? 'selected' : '' }}>Date of Birth</option>
                            <option value="enrollment_date" {{ $sortBy === 'enrollment_date' ? 'selected' : '' }}>Enrollment Date</option>
                        </select>
                        <select name="sort_order" id="sort_order"
                            class="w-24 px-2 py-2 rounded-xl border border-slate-200 text-xs focus:outline-none focus:ring-4 focus:ring-indigo-100 focus:border-indigo-500 transition bg-white">
                            <option value="desc" {{ $sortOrder === 'desc' ? 'selected' : '' }}>Desc</option>
                            <option value="asc" {{ $sortOrder === 'asc' ? 'selected' : '' }}>Asc</option>
                        </select>
                    </div>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="flex items-center justify-between pt-2 border-t border-slate-100">
                <div class="text-xs text-slate-500">
                    Showing <span class="font-bold text-slate-800">{{ $students->total() }}</span> registered students
                    @if ($search || $deptId || $gender)
                        <span class="text-indigo-600 font-semibold">(filtered)</span>
                    @endif
                </div>

                <div class="flex items-center space-x-2">
                    @if ($search || $deptId || $gender || $sortBy !== 'student_id' || $sortOrder !== 'desc')
                        <a href="{{ route('students.index') }}" class="px-3.5 py-1.5 rounded-lg bg-slate-100 hover:bg-slate-200 text-slate-600 text-xs font-semibold transition">
                            Reset Filters
                        </a>
                    @endif
                    <button type="submit" class="px-4 py-1.5 rounded-lg bg-slate-900 hover:bg-slate-800 text-white text-xs font-semibold transition cursor-pointer">
                        Apply Filter & Search
                    </button>
                </div>
            </div>
        </form>
    </div>

    <!-- HTML Table for Students -->
    <div class="glass-card rounded-2xl overflow-hidden shadow-xs">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm">
                <thead>
                    <tr class="bg-slate-50/80 border-b border-slate-200/80 text-xs font-bold uppercase tracking-wider text-slate-500">
                        <th class="py-3.5 px-4">ID </th>
                        <th class="py-3.5 px-4">Student Name</th>
                        <th class="py-3.5 px-4">Gender</th>
                        <th class="py-3.5 px-4">Date of Birth</th>
                        <th class="py-3.5 px-4">Enrollment ID</th>
                        <th class="py-3.5 px-4">Enrollment Date</th>    
                        <th class="py-3.5 px-4">Department </th>
                        <th class="py-3.5 px-4 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 bg-white">
                    @forelse ($students as $student)
                        <tr class="hover:bg-indigo-50/40 transition-colors">
                            <td class="py-3.5 px-4 font-mono font-bold text-xs text-indigo-600">
                                #{{ $student->student_id }}
                            </td>
                            <td class="py-3.5 px-4">
                                <div class="flex items-center space-x-2.5">
                                    <div class="w-8 h-8 rounded-lg bg-indigo-100 text-indigo-700 font-bold text-xs flex items-center justify-center shrink-0">
                                        {{ strtoupper(substr($student->student_name, 0, 1)) }}
                                    </div>
                                    <div>
                                        <a href="{{ route('students.show', $student) }}" class="font-bold text-slate-900 hover:text-indigo-600 transition-colors">
                                            {{ $student->student_name }}
                                        </a>
                                        @if ($student->description)
                                            <p class="text-[11px] text-slate-400 line-clamp-1 max-w-xs">{{ $student->description }}</p>
                                        @endif
                                    </div>
                                </div>
                            </td>
                            <td class="py-3.5 px-4">
                                @if ($student->gender === 'Male')
                                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-semibold bg-blue-50 text-blue-700 border border-blue-200">
                                        Male
                                    </span>
                                @elseif ($student->gender === 'Female')
                                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-semibold bg-pink-50 text-pink-700 border border-pink-200">
                                        Female
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-semibold bg-slate-100 text-slate-700">
                                        {{ $student->gender }}
                                    </span>
                                @endif
                            </td>
                            <td class="py-3.5 px-4 text-xs text-slate-600 whitespace-nowrap">
                                {{ $student->dob ? $student->dob->format('M d, Y') : 'N/A' }}
                            </td>
                            <td class="py-3.5 px-4">
                                <span class="font-mono text-xs px-2 py-0.5 rounded bg-slate-100 text-slate-700 border border-slate-200 font-semibold">
                                    {{ $student->enrollment }}
                                </span>
                            </td>
                            <td class="py-3.5 px-4 text-xs text-slate-600 whitespace-nowrap">
                                {{ $student->enrollment_date ? $student->enrollment_date->format('M d, Y') : 'N/A' }}
                            </td>
                            <td class="py-3.5 px-4">
                                @if ($student->department)
                                    <a href="{{ route('departments.show', $student->department) }}"
                                        class="inline-flex items-center px-2.5 py-1 rounded-lg text-xs font-medium bg-indigo-50 text-indigo-700 border border-indigo-100 hover:bg-indigo-100 transition-colors">
                                        {{ $student->department->dept_name }}
                                    </a>
                                @else
                                    <span class="text-xs text-slate-400 italic">No department</span>
                                @endif
                            </td>
                            <td class="py-3.5 px-4 text-right">
                                <div class="inline-flex items-center space-x-1">
                                    <a href="{{ route('students.show', $student) }}" title="View Student Profile"
                                        class="p-1.5 rounded-lg text-slate-500 hover:text-indigo-600 hover:bg-indigo-50 transition">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                    </a>
                                    <a href="{{ route('students.edit', $student) }}" title="Edit Student"
                                        class="p-1.5 rounded-lg text-slate-500 hover:text-amber-600 hover:bg-amber-50 transition">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                    </a>
                                    <form method="POST" action="{{ route('students.destroy', $student) }}" class="inline"
                                        onsubmit="return confirm('Are you sure you want to delete student {{ $student->student_name }}?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" title="Delete Student"
                                            class="p-1.5 rounded-lg text-slate-500 hover:text-rose-600 hover:bg-rose-50 transition cursor-pointer">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="py-12 text-center">
                                <div class="max-w-sm mx-auto text-center">
                                    <div class="w-12 h-12 rounded-xl bg-slate-100 text-slate-400 mx-auto flex items-center justify-center mb-3">
                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                                    </div>
                                    <h3 class="text-sm font-bold text-slate-800">No students found</h3>
                                    <p class="text-xs text-slate-500 mt-1">Try clearing your search query or department filter.</p>
                                    <a href="{{ route('students.create') }}" class="mt-4 inline-flex items-center text-xs font-semibold text-indigo-600 hover:text-indigo-800">
                                        + Register New Student
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if ($students->hasPages())
            <div class="p-4 border-t border-slate-100 bg-slate-50/50">
                {{ $students->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
