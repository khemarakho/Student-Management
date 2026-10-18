<?php

namespace Tests\Feature;

use App\Models\Department;
use App\Models\Student;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class StudentCrudTest extends TestCase
{
    use RefreshDatabase;

    protected User $user;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
    }

    public function test_authenticated_user_can_view_students_table_with_relational_department(): void
    {
        $dept = Department::factory()->create(['dept_name' => 'Computer Science']);
        $student = Student::factory()->create([
            'student_name' => 'Hok Khemarak',
            'gender' => 'Male',
            'enrollment' => 'ENR-2024-001',
            'dept_id' => $dept->dept_id,
        ]);

        $response = $this->actingAs($this->user)->get('/students');

        $response->assertStatus(200);
        $response->assertSee('Hok Khemarak');
        $response->assertSee('ENR-2024-001');
        $response->assertSee('Computer Science');
    }

    public function test_user_can_search_students_by_name(): void
    {
        $dept = Department::factory()->create();
        Student::factory()->create(['student_name' => 'Chan Bopha', 'dept_id' => $dept->dept_id]);
        Student::factory()->create(['student_name' => 'Keo Sreymom', 'dept_id' => $dept->dept_id]);

        $response = $this->actingAs($this->user)->get('/students?search=Bopha');

        $response->assertStatus(200);
        $response->assertSee('Chan Bopha');
        $response->assertDontSee('Keo Sreymom');
    }

    public function test_user_can_filter_students_by_department(): void
    {
        $deptIT = Department::factory()->create(['dept_name' => 'Information Technology']);
        $deptBiz = Department::factory()->create(['dept_name' => 'Business School']);

        Student::factory()->create(['student_name' => 'Student IT', 'dept_id' => $deptIT->dept_id]);
        Student::factory()->create(['student_name' => 'Student Biz', 'dept_id' => $deptBiz->dept_id]);

        $response = $this->actingAs($this->user)->get("/students?dept_id={$deptIT->dept_id}");

        $response->assertStatus(200);
        $response->assertSee('Student IT');
        $response->assertDontSee('Student Biz');
    }

    public function test_user_can_filter_students_by_gender(): void
    {
        $dept = Department::factory()->create();
        Student::factory()->create(['student_name' => 'Male Student', 'gender' => 'Male', 'dept_id' => $dept->dept_id]);
        Student::factory()->create(['student_name' => 'Female Student', 'gender' => 'Female', 'dept_id' => $dept->dept_id]);

        $response = $this->actingAs($this->user)->get('/students?gender=Female');

        $response->assertStatus(200);
        $response->assertSee('Female Student');
        $response->assertDontSee('Male Student');
    }

    public function test_user_can_create_student_linked_to_department(): void
    {
        $dept = Department::factory()->create(['dept_name' => 'Software Engineering']);

        $response = $this->actingAs($this->user)->post('/students', [
            'student_name' => 'Sokha Rithy',
            'gender' => 'Male',
            'dob' => '2004-05-10',
            'enrollment' => 'ENR-2024-099',
            'enrollment_date' => '2024-02-01',
            'description' => 'Aspiring web developer',
            'dept_id' => $dept->dept_id,
        ]);

        $response->assertRedirect('/students');
        $this->assertDatabaseHas('students', [
            'student_name' => 'Sokha Rithy',
            'enrollment' => 'ENR-2024-099',
            'dept_id' => $dept->dept_id,
        ]);
    }

    public function test_user_can_view_student_profile_with_relational_department_info(): void
    {
        $dept = Department::factory()->create([
            'dept_name' => 'Multimedia Design',
            'manager_id' => 'MGR-777',
            'location_id' => 'Building C',
        ]);

        $student = Student::factory()->create([
            'student_name' => 'Keo Dara',
            'dept_id' => $dept->dept_id,
        ]);

        $response = $this->actingAs($this->user)->get("/students/{$student->student_id}");

        $response->assertStatus(200);
        $response->assertSee('Keo Dara');
        $response->assertSee('Multimedia Design');
        $response->assertSee('MGR-777');
        $response->assertSee('Building C');
    }

    public function test_user_can_update_student_details(): void
    {
        $dept1 = Department::factory()->create();
        $dept2 = Department::factory()->create(['dept_name' => 'New Department']);

        $student = Student::factory()->create(['dept_id' => $dept1->dept_id]);

        $response = $this->actingAs($this->user)->put("/students/{$student->student_id}", [
            'student_name' => 'Updated Student Name',
            'gender' => 'Female',
            'dob' => '2003-08-15',
            'enrollment' => 'ENR-2024-UPD',
            'enrollment_date' => '2024-01-20',
            'description' => 'Updated description text',
            'dept_id' => $dept2->dept_id,
        ]);

        $response->assertRedirect('/students');
        $this->assertDatabaseHas('students', [
            'student_id' => $student->student_id,
            'student_name' => 'Updated Student Name',
            'gender' => 'Female',
            'enrollment' => 'ENR-2024-UPD',
            'dept_id' => $dept2->dept_id,
        ]);
    }

    public function test_user_can_delete_student(): void
    {
        $dept = Department::factory()->create();
        $student = Student::factory()->create(['dept_id' => $dept->dept_id]);

        $response = $this->actingAs($this->user)->delete("/students/{$student->student_id}");

        $response->assertRedirect('/students');
        $this->assertDatabaseMissing('students', [
            'student_id' => $student->student_id,
        ]);
    }

    public function test_student_and_department_eloquent_relationships(): void
    {
        $dept = Department::factory()->create();
        $student1 = Student::factory()->create(['dept_id' => $dept->dept_id]);
        $student2 = Student::factory()->create(['dept_id' => $dept->dept_id]);

        // Student belongs to Department
        $this->assertEquals($dept->dept_id, $student1->department->dept_id);

        // Department has many Students
        $this->assertCount(2, $dept->students);
        $this->assertTrue($dept->students->contains($student1));
        $this->assertTrue($dept->students->contains($student2));
    }
}
