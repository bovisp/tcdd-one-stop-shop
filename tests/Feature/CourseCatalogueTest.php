<?php

namespace Tests\Feature;

use App\Models\MoodleCourseCatalogue;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CourseCatalogueTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

    /**
     * @test
     */
    public function catalogue_can_be_viewed()
    {
        $this->withoutExceptionHandling();
        $this->authenticatedUser();

        MoodleCourseCatalogue::factory()->count(3)->create();
        $response = $this->get('/course-catalogues');
        $response->assertStatus(200);
    }

    /**
     * @test
     */

    public function Unauthenticated_can_not_access_catalogue()
    {

        MoodleCourseCatalogue::factory()->count(3)->create();
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
