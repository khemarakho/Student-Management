<?php

namespace Tests\Feature;

use App\Models\Department;
use App\Models\Student;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DepartmentCrudTest extends TestCase
{
    use RefreshDatabase;

    protected User $user;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
    }

    public function test_authenticated_user_can_view_departments_index_table(): void
    {
        $dept = Department::factory()->create([
            'dept_name' => 'Computer Science',
            'manager_id' => 'MGR-101',
            'location_id' => 'Building A',
        ]);

        $response = $this->actingAs($this->user)->get('/departments');

        $response->assertStatus(200);
        $response->assertSee('Computer Science');
        $response->assertSee('MGR-101');
        $response->assertSee('Building A');
    }

    public function test_user_can_search_departments_by_name(): void
    {
        Department::factory()->create(['dept_name' => 'Architecture & Design']);
        Department::factory()->create(['dept_name' => 'Computer Science']);

        $response = $this->actingAs($this->user)->get('/departments?search=Architecture');

        $response->assertStatus(200);
        $response->assertSee('Architecture & Design');
        $response->assertDontSee('Computer Science');
    }

    public function test_user_can_create_department_via_template(): void
    {
        $response = $this->actingAs($this->user)->post('/departments', [
            'dept_name' => 'Faculty of Engineering',
            'manager_id' => 'MGR-500',
            'location_id' => 'Building E',
        ]);

        $response->assertRedirect('/departments');
        $this->assertDatabaseHas('departments', [
            'dept_name' => 'Faculty of Engineering',
            'manager_id' => 'MGR-500',
            'location_id' => 'Building E',
        ]);
    }

    public function test_user_can_view_department_details_with_students(): void
    {
        $dept = Department::factory()->create(['dept_name' => 'Data Science']);
        $student = Student::factory()->create([
            'student_name' => 'Alice Tech',
            'dept_id' => $dept->dept_id,
        ]);

        $response = $this->actingAs($this->user)->get("/departments/{$dept->dept_id}");

        $response->assertStatus(200);
        $response->assertSee('Data Science');
        $response->assertSee('Alice Tech');
    }

    public function test_user_can_update_department(): void
    {
        $dept = Department::factory()->create([
            'dept_name' => 'Old Name',
            'manager_id' => 'MGR-111',
        ]);

        $response = $this->actingAs($this->user)->put("/departments/{$dept->dept_id}", [
            'dept_name' => 'Updated Faculty Name',
            'manager_id' => 'MGR-999',
            'location_id' => 'New Building',
        ]);

        $response->assertRedirect('/departments');
        $this->assertDatabaseHas('departments', [
            'dept_id' => $dept->dept_id,
            'dept_name' => 'Updated Faculty Name',
            'manager_id' => 'MGR-999',
        ]);
    }

    public function test_user_can_delete_department(): void
    {
        $dept = Department::factory()->create();

        $response = $this->actingAs($this->user)->delete("/departments/{$dept->dept_id}");

        $response->assertRedirect('/departments');
        $this->assertDatabaseMissing('departments', [
            'dept_id' => $dept->dept_id,
        ]);
    }

    public function test_department_views_render_delete_buttons_and_modal(): void
    {
        $dept = Department::factory()->create([
            'dept_name' => 'Architecture Dept',
        ]);
        $student = Student::factory()->create([
            'dept_id' => $dept->dept_id,
            'student_name' => 'Enrolled Student',
        ]);

        // Department index page renders delete button with modal trigger
        $indexResponse = $this->actingAs($this->user)->get('/departments');
        $indexResponse->assertStatus(200);
        $indexResponse->assertSee('delete-confirmation-modal');
        $indexResponse->assertSee("departments/{$dept->dept_id}");

        // Department show page renders delete button and student roster delete button
        $showResponse = $this->actingAs($this->user)->get("/departments/{$dept->dept_id}");
        $showResponse->assertStatus(200);
        $showResponse->assertSee('Delete Department');
        $showResponse->assertSee("departments/{$dept->dept_id}");
        $showResponse->assertSee("students/{$student->student_id}");

        // Department edit page renders delete button
        $editResponse = $this->actingAs($this->user)->get("/departments/{$dept->dept_id}/edit");
        $editResponse->assertStatus(200);
        $editResponse->assertSee('Delete Department');
    }
}
