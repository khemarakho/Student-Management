<?php
namespace App\Http\Controllers;
use App\Models\Department;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
class DepartmentController extends Controller
{
    public function index(Request $request): View
    {
        $search = $request->query('search');

        $query = Department::withCount('students');

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('dept_name', 'like', "%{$search}%")
                    ->orWhere('manager_id', 'like', "%{$search}%")
                    ->orWhere('location_id', 'like', "%{$search}%");
            });
        }

        $departments = $query->orderBy('dept_name', 'asc')->paginate(10)->withQueryString();

        return view('departments.index', compact('departments', 'search'));
    }
    public function create(): View
    {
        return view('departments.create');
    }
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'dept_name' => ['required', 'string', 'max:255', 'unique:departments,dept_name'],
            'manager_id' => ['nullable', 'string', 'max:100'],
            'location_id' => ['nullable', 'string', 'max:150'],
        ]);

        Department::create($validated);

        return redirect()->route('departments.index')
            ->with('success', 'Department "'.$validated['dept_name'].'" was created successfully.');
    }
    public function show(Department $department): View
    {
        $department->load(['students' => function ($query) {
            $query->orderBy('student_name', 'asc');
        }]);

        return view('departments.show', compact('department'));
    }
    public function edit(Department $department): View
    {
        return view('departments.edit', compact('department'));
    }
    public function update(Request $request, Department $department): RedirectResponse
    {
        $validated = $request->validate([
            'dept_name' => ['required', 'string', 'max:255', 'unique:departments,dept_name,'.$department->dept_id.',dept_id'],
            'manager_id' => ['nullable', 'string', 'max:100'],
            'location_id' => ['nullable', 'string', 'max:150'],
        ]);

        $department->update($validated);

        return redirect()->route('departments.index')
            ->with('success', 'Department "'.$department->dept_name.'" was updated successfully.');
    }
    public function destroy(Department $department): RedirectResponse
    {
        $name = $department->dept_name;
        $department->delete();

        return redirect()->route('departments.index')
            ->with('success', 'Department "'.$name.'" was deleted successfully.');
    }
}
