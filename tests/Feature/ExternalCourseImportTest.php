<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ExternalCourseImportTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

    /**
     * @test
     */
    public function course_can_be_added()
    {
        $this->withoutExceptionHandling();
        $this->authenticatedUser();
        $response = $this->get('/external-course/create');
        $response->assertOk();
    }

    /**
     * @test
     */

    public function Unauthenticated_can_not_access()
    {

        $response = $this->get('/course-catalogues');
        $response->assertStatus(302);
    }

    /**
     * Authenticated user
     */
    public function authenticatedUser()
    {
        $this->actingAs($user = User::factory()->create());
    }


}
