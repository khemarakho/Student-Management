<?php

namespace Database\Seeders;

use App\Models\Department;
use Illuminate\Database\Seeder;

class DepartmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $departments = [
            [
                'dept_name' => 'Computer Science & Software Engineering',
                'manager_id' => 'MGR-101',
                'location_id' => 'Building A - Room 301',
            ],
            [
                'dept_name' => 'Information & Communication Technology',
                'manager_id' => 'MGR-102',
                'location_id' => 'Building A - Room 402',
            ],
            [
                'dept_name' => 'Business Administration & Management',
                'manager_id' => 'MGR-103',
                'location_id' => 'Building B - Room 105',
            ],
            [
                'dept_name' => 'Accounting & Financial Banking',
                'manager_id' => 'MGR-104',
                'location_id' => 'Building B - Room 208',
            ],
            [
                'dept_name' => 'Civil & Architectural Engineering',
                'manager_id' => 'MGR-105',
                'location_id' => 'Building C - Room 110',
            ],
            [
                'dept_name' => 'Graphic Design & Multimedia Arts',
                'manager_id' => 'MGR-106',
                'location_id' => 'Building C - Room 304',
            ],
        ];

        foreach ($departments as $dept) {
            Department::firstOrCreate(
                ['dept_name' => $dept['dept_name']],
                $dept
            );
        }
    }
}
