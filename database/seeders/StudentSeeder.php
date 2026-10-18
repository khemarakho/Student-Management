<?php

namespace Database\Seeders;

use App\Models\Department;
use App\Models\Student;
use Illuminate\Database\Seeder;

class StudentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $departments = Department::all();

        if ($departments->isEmpty()) {
            $this->call(DepartmentSeeder::class);
            $departments = Department::all();
        }

        $sampleStudents = [
            [
                'student_name' => 'Hok Khemarak',
                'gender' => 'Male',
                'dob' => '2003-05-14',
                'enrollment' => 'ENR-2024-001',
                'enrollment_date' => '2024-01-15',
                'description' => 'Top student focusing on full-stack web applications and cloud architecture.',
                'dept_name' => 'Computer Science & Software Engineering',
            ],
            [
                'student_name' => 'Sokha Rithy',
                'gender' => 'Male',
                'dob' => '2004-02-20',
                'enrollment' => 'ENR-2024-002',
                'enrollment_date' => '2024-01-16',
                'description' => 'Cybersecurity enthusiast and network administration team lead.',
                'dept_name' => 'Information & Communication Technology',
            ],
            [
                'student_name' => 'Chan Bopha',
                'gender' => 'Female',
                'dob' => '2003-11-08',
                'enrollment' => 'ENR-2024-003',
                'enrollment_date' => '2024-01-18',
                'description' => 'Specializing in international financial management and investment analytics.',
                'dept_name' => 'Accounting & Financial Banking',
            ],
            [
                'student_name' => 'Vannak Dara',
                'gender' => 'Male',
                'dob' => '2002-08-25',
                'enrollment' => 'ENR-2024-004',
                'enrollment_date' => '2024-02-01',
                'description' => 'Interested in digital marketing, entrepreneurship, and venture startup creation.',
                'dept_name' => 'Business Administration & Management',
            ],
            [
                'student_name' => 'Keo Sreymom',
                'gender' => 'Female',
                'dob' => '2004-07-19',
                'enrollment' => 'ENR-2024-005',
                'enrollment_date' => '2024-02-05',
                'description' => 'Award winner in 3D architectural rendering and structural engineering.',
                'dept_name' => 'Civil & Architectural Engineering',
            ],
            [
                'student_name' => 'Meng Piseth',
                'gender' => 'Male',
                'dob' => '2003-09-30',
                'enrollment' => 'ENR-2024-006',
                'enrollment_date' => '2024-02-10',
                'description' => 'UI/UX designer with advanced proficiency in Figma and motion graphics.',
                'dept_name' => 'Graphic Design & Multimedia Arts',
            ],
            [
                'student_name' => 'Lim Channary',
                'gender' => 'Female',
                'dob' => '2003-03-12',
                'enrollment' => 'ENR-2024-007',
                'enrollment_date' => '2024-03-01',
                'description' => 'Active participant in regional hackathons and algorithm contests.',
                'dept_name' => 'Computer Science & Software Engineering',
            ],
            [
                'student_name' => 'Samnang Visal',
                'gender' => 'Male',
                'dob' => '2004-12-04',
                'enrollment' => 'ENR-2024-008',
                'enrollment_date' => '2024-03-15',
                'description' => 'Specializing in data pipelines and automated database replication.',
                'dept_name' => 'Information & Communication Technology',
            ],
            [
                'student_name' => 'Chea Sovann',
                'gender' => 'Male',
                'dob' => '2002-10-17',
                'enrollment' => 'ENR-2024-009',
                'enrollment_date' => '2024-04-02',
                'description' => 'Focusing on supply chain optimization and logistics systems.',
                'dept_name' => 'Business Administration & Management',
            ],
            [
                'student_name' => 'Heng Thida',
                'gender' => 'Female',
                'dob' => '2004-04-22',
                'enrollment' => 'ENR-2024-010',
                'enrollment_date' => '2024-04-10',
                'description' => 'Corporate auditing and enterprise tax compliance researcher.',
                'dept_name' => 'Accounting & Financial Banking',
            ],
        ];

        foreach ($sampleStudents as $s) {
            $dept = $departments->firstWhere('dept_name', $s['dept_name']) ?? $departments->first();

            Student::firstOrCreate(
                ['enrollment' => $s['enrollment']],
                [
                    'student_name' => $s['student_name'],
                    'gender' => $s['gender'],
                    'dob' => $s['dob'],
                    'enrollment' => $s['enrollment'],
                    'enrollment_date' => $s['enrollment_date'],
                    'description' => $s['description'],
                    'dept_id' => $dept->dept_id,
                ]
            );
        }
    }
}
