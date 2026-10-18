<?php
namespace App\Http\Controllers;
use App\Models\Department;
use App\Models\Student;
use App\Models\User;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $totalStudents = Student::count();
        $totalDepartments = Department::count();
        $totalUsers = User::count();

        $maleCount = Student::where('gender', 'Male')->count();
        $femaleCount = Student::where('gender', 'Female')->count();
        $otherCount = Student::whereNotIn('gender', ['Male', 'Female'])->count();
        $recentStudents = Student::with('department')
            ->latest('created_at')
            ->limit(5)
            ->get();
        $departments = Department::withCount('students')
            ->orderBy('students_count', 'desc')
            ->get();
        return view('dashboard', compact(
            'totalStudents',
            'totalDepartments',
            'totalUsers',
            'maleCount',
            'femaleCount',
            'otherCount',
            'recentStudents',
            'departments'
        ));
    }
}
