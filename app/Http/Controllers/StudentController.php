<?php
namespace App\Http\Controllers;
use App\Models\Department;
use App\Models\Student;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
class StudentController extends Controller
{
    public function index(Request $request): View
    {
        $search = $request->query('search');
        $deptId = $request->query('dept_id');
        $gender = $request->query('gender');
        $sortBy = $request->query('sort_by', 'student_id');
        $sortOrder = $request->query('sort_order', 'desc');
        $query = Student::with('department');
        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('student_name', 'like', "%{$search}%")
                    ->orWhere('enrollment', 'like', "%{$search}%")
                    ->orWhere('student_id', $search);
            });
        }
        if ($deptId) {
            $query->where('dept_id', $deptId);
        }
        if ($gender) {
            $query->where('gender', $gender);
        }
        $allowedSorts = ['student_id', 'student_name', 'dob', 'enrollment_date', 'gender'];
        if (in_array($sortBy, $allowedSorts, true)) {
            $order = strtolower($sortOrder) === 'asc' ? 'asc' : 'desc';
            $query->orderBy($sortBy, $order);
        } else {
            $query->latest('student_id');
        }
        $students = $query->paginate(10)->withQueryString();
        $departments = Department::orderBy('dept_name', 'asc')->get();
        return view('students.index', compact(
            'students',
            'departments',
            'search',
            'deptId',
            'gender',
            'sortBy',
            'sortOrder'
        ));
    }
    public function create(): View
    {
        $departments = Department::orderBy('dept_name', 'asc')->get();
        return view('students.create', compact('departments'));
    }
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'student_name' => ['required', 'string', 'max:255'],
            'gender' => ['required', 'string', 'in:Male,Female,Other'],
            'dob' => ['required', 'date'],
            'enrollment' => ['required', 'string', 'max:50', 'unique:students,enrollment'],
            'enrollment_date' => ['required', 'date'],
            'description' => ['nullable', 'string', 'max:2000'],
            'dept_id' => ['required', 'exists:departments,dept_id'],
        ]);
        $student = Student::create($validated);
        return redirect()->route('students.index')
            ->with('success', 'Student "'.$student->student_name.'" ('.$student->enrollment.') registered successfully!');
    }
    public function show(Student $student): View
    {
        $student->load('department');
        return view('students.show', compact('student'));
    }
    public function edit(Student $student): View
    {
        $departments = Department::orderBy('dept_name', 'asc')->get();
        return view('students.edit', compact('student', 'departments'));
    }
    public function update(Request $request, Student $student): RedirectResponse
    {
        $validated = $request->validate([
            'student_name' => ['required', 'string', 'max:255'],
            'gender' => ['required', 'string', 'in:Male,Female,Other'],
            'dob' => ['required', 'date'],
            'enrollment' => ['required', 'string', 'max:50', 'unique:students,enrollment,'.$student->student_id.',student_id'],
            'enrollment_date' => ['required', 'date'],
            'description' => ['nullable', 'string', 'max:2000'],
            'dept_id' => ['required', 'exists:departments,dept_id'],
        ]);
        $student->update($validated);
        return redirect()->route('students.index')
            ->with('success', 'Student "'.$student->student_name.'" updated successfully!');
    }
    public function destroy(Student $student): RedirectResponse
    {
        $name = $student->student_name;
        $student->delete();

        return redirect()->route('students.index')
            ->with('success', 'Student "'.$name.'" was deleted successfully.');
    }
}
