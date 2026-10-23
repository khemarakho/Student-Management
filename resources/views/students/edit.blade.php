@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto space-y-6">
    <!-- Breadcrumb & Header -->
    <div>
        <div class="flex items-center space-x-2 text-xs font-semibold text-slate-400 mb-1">
            <a href="{{ route('dashboard') }}" class="hover:text-indigo-600">Dashboard</a>
            <span>/</span>
            <a href="{{ route('students.index') }}" class="hover:text-indigo-600">Students</a>
            <span>/</span>
            <span class="text-slate-700">Edit #{{ $student->student_id }}</span>
        </div>
        <h1 class="text-2xl font-bold tracking-tight text-slate-900">Edit Student Record</h1>
        <p class="text-xs text-slate-500">Update academic and personal information for student ID #{{ $student->student_id }}</p>
    </div>

    <!-- Form Card -->
    <div class="glass-card rounded-2xl p-6 sm:p-8">
        <form method="POST" action="{{ route('students.update', $student) }}" class="space-y-6">
            @csrf
            @method('PUT')

            <!-- Section 1: Academic Department Selection (Relational Link) -->
            <div class="p-4 rounded-xl bg-indigo-50/70 border border-indigo-100">
                <div class="flex items-center space-x-2 mb-2">
                    <span class="w-6 h-6 rounded-lg gradient-brand text-white flex items-center justify-center text-xs font-bold shadow-xs">1</span>
                    <label for="dept_id" class="text-xs font-bold uppercase tracking-wider text-indigo-950">
                        Academic Department (Relational Link to Departments Table) <span class="text-rose-500">*</span>
                    </label>
                </div>
                <select name="dept_id" id="dept_id" required
                    class="w-full px-4 py-2.5 rounded-xl border {{ $errors->has('dept_id') ? 'border-rose-400 focus:ring-rose-200' : 'border-indigo-200 focus:ring-indigo-200 focus:border-indigo-500' }} text-sm focus:outline-none focus:ring-4 transition bg-white shadow-xs font-medium">
                    <option value="">-- Choose Academic Department (Dept_Name) --</option>
                    @foreach ($departments as $dept)
                        <option value="{{ $dept->dept_id }}" {{ (string)old('dept_id', $student->dept_id) === (string)$dept->dept_id ? 'selected' : '' }}>
                            {{ $dept->dept_name }} &bull; (ID: #{{ $dept->dept_id }}{{ $dept->location_id ? ' &bull; ' . $dept->location_id : '' }})
                        </option>
                    @endforeach
                </select>
                @error('dept_id')
                    <p class="mt-1.5 text-xs text-rose-600 font-medium">{{ $message }}</p>
                @enderror
            </div>

            <!-- Section 2: Personal Information -->
            <div>
                <div class="flex items-center space-x-2 mb-4">
                    <span class="w-6 h-6 rounded-lg bg-slate-900 text-white flex items-center justify-center text-xs font-bold">2</span>
                    <h3 class="text-xs font-bold uppercase tracking-wider text-slate-700">Personal Information</h3>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                    <!-- Student Name -->
                    <div class="sm:col-span-2">
                        <label for="student_name" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">
                            Full Student Name <span class="text-rose-500">*</span>
                        </label>
                        <input type="text" name="student_name" id="student_name" value="{{ old('student_name', $student->student_name) }}" required
                            class="w-full px-4 py-2.5 rounded-xl border {{ $errors->has('student_name') ? 'border-rose-400 focus:ring-rose-200' : 'border-slate-200 focus:ring-indigo-100 focus:border-indigo-500' }} text-sm focus:outline-none focus:ring-4 transition">
                        @error('student_name')
                            <p class="mt-1.5 text-xs text-rose-600 font-medium">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Gender -->
                    <div>
                        <label for="gender" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">
                            Gender <span class="text-rose-500">*</span>
                        </label>
                        <select name="gender" id="gender" required
                            class="w-full px-4 py-2.5 rounded-xl border {{ $errors->has('gender') ? 'border-rose-400 focus:ring-rose-200' : 'border-slate-200 focus:ring-indigo-100 focus:border-indigo-500' }} text-sm focus:outline-none focus:ring-4 transition bg-white">
                            <option value="Male" {{ old('gender', $student->gender) === 'Male' ? 'selected' : '' }}>Male</option>
                            <option value="Female" {{ old('gender', $student->gender) === 'Female' ? 'selected' : '' }}>Female</option>
                            <option value="Other" {{ old('gender', $student->gender) === 'Other' ? 'selected' : '' }}>Other</option>
                        </select>
                        @error('gender')
                            <p class="mt-1.5 text-xs text-rose-600 font-medium">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Date of Birth (DOB) -->
                    <div>
                        <label for="dob" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">
                            Date of Birth (DOB) <span class="text-rose-500">*</span>
                        </label>
                        <input type="date" name="dob" id="dob"
                            value="{{ old('dob', $student->dob ? $student->dob->format('Y-m-d') : '') }}" required
                            class="w-full px-4 py-2.5 rounded-xl border {{ $errors->has('dob') ? 'border-rose-400 focus:ring-rose-200' : 'border-slate-200 focus:ring-indigo-100 focus:border-indigo-500' }} text-sm focus:outline-none focus:ring-4 transition">
                        @error('dob')
                            <p class="mt-1.5 text-xs text-rose-600 font-medium">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Section 3: Enrollment Details -->
            <div>
                <div class="flex items-center space-x-2 mb-4">
                    <span class="w-6 h-6 rounded-lg bg-slate-900 text-white flex items-center justify-center text-xs font-bold">3</span>
                    <h3 class="text-xs font-bold uppercase tracking-wider text-slate-700">Academic Enrollment</h3>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                    <!-- Enrollment Code / ID -->
                    <div>
                        <label for="enrollment" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">
                            Enrollment ID / Code <span class="text-rose-500">*</span>
                        </label>
                        <input type="text" name="enrollment" id="enrollment"
                            value="{{ old('enrollment', $student->enrollment) }}" required
                            class="w-full px-4 py-2.5 rounded-xl font-mono text-sm border {{ $errors->has('enrollment') ? 'border-rose-400 focus:ring-rose-200' : 'border-slate-200 focus:ring-indigo-100 focus:border-indigo-500' }} focus:outline-none focus:ring-4 transition">
                        @error('enrollment')
                            <p class="mt-1.5 text-xs text-rose-600 font-medium">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Enrollment Date -->
                    <div>
                        <label for="enrollment_date" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">
                            Enrollment Date <span class="text-rose-500">*</span>
                        </label>
                        <input type="date" name="enrollment_date" id="enrollment_date"
                            value="{{ old('enrollment_date', $student->enrollment_date ? $student->enrollment_date->format('Y-m-d') : '') }}" required
                            class="w-full px-4 py-2.5 rounded-xl border {{ $errors->has('enrollment_date') ? 'border-rose-400 focus:ring-rose-200' : 'border-slate-200 focus:ring-indigo-100 focus:border-indigo-500' }} text-sm focus:outline-none focus:ring-4 transition">
                        @error('enrollment_date')
                            <p class="mt-1.5 text-xs text-rose-600 font-medium">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Description / Remarks -->
                    <div class="sm:col-span-2">
                        <label for="description" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">
                            Student Notes / Description
                        </label>
                        <textarea name="description" id="description" rows="3"
                            class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:ring-indigo-100 focus:border-indigo-500 text-sm focus:outline-none focus:ring-4 transition">{{ old('description', $student->description) }}</textarea>
                        @error('description')
                            <p class="mt-1.5 text-xs text-rose-600 font-medium">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="pt-4 border-t border-slate-100 flex flex-col sm:flex-row items-center justify-between gap-3">
                <button type="button"
                    data-delete-url="{{ route('students.destroy', $student) }}"
                    data-delete-name="{{ $student->student_name }}"
                    data-delete-type="Student"
                    data-delete-details="Enrollment: {{ $student->enrollment }} &bull; ID: #{{ $student->student_id }}"
                    data-delete-title="Delete Student Record"
                    data-delete-warning="This will permanently delete {{ $student->student_name }}'s entire profile and academic records."
                    class="w-full sm:w-auto inline-flex items-center justify-center space-x-1.5 px-4 py-2.5 rounded-xl text-xs font-semibold text-rose-600 hover:text-rose-700 hover:bg-rose-50 border border-rose-200 transition cursor-pointer">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                    <span>Delete Student</span>
                </button>

                <div class="flex items-center space-x-3 w-full sm:w-auto justify-end">
                    <a href="{{ route('students.index') }}" class="px-5 py-2.5 rounded-xl text-sm font-semibold text-slate-600 hover:text-slate-900 hover:bg-slate-100 transition">
                        Cancel
                    </a>
                    <button type="submit" class="px-6 py-2.5 rounded-xl text-sm font-semibold text-white gradient-brand shadow-lg shadow-indigo-500/25 hover:shadow-indigo-500/40 hover:opacity-95 transition cursor-pointer">
                        Update Student Record
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
