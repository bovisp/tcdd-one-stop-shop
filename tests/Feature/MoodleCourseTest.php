<?php

namespace Tests\Feature;

use App\Models\CourseCategory;
use App\Models\MoodleCourseMetadata;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;


class MoodleCourseTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

    /**
     * @test
     */
    public function course_can_be_viewed()
    {
        $this->withoutExceptionHandling();

        $this->authenticatedUser();
       MoodleCourseMetadata::factory()->count(15)->create();

        $response = $this->get('/moodle-courses');
        $response->assertStatus(200);
    }

    /**
     * @test
     */
    public function course_can_be_deleted()
    {
        $this->withoutExceptionHandling();
        $this->authenticatedUser();

        MoodleCourseMetadata::factory()->count(1)->create();

        $course = MoodleCourseMetadata::first();
        $response = $this->delete('/moodle-courses/' . $course->id);
        $response->assertStatus(302);
    }

    /**
     * @test
     */
    public function unauthenticated_user_can_not_access_resource()
    {
        $response = $this->get('/moodle-courses');
        $response->assertStatus(302);
    }

    /**
     * actingAs auth user
     */
    public function authenticatedUser()
    {
        $this->actingAs($user = User::factory()->create());
    }
}
