<?php

namespace Tests\Feature;

use Illuminate\Http\UploadedFile;
use Tests\TestCase;
use App\Models\User;
use App\Models\MoodleMedia;
use App\Models\MoodleMediaLicense;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
class MoodleMediaTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

    /**
     * @test
     */
    public function media_can_be_viewed()
    {
        $this->withoutExceptionHandling();
        $this->authenticatedUser();

        $test = MoodleMedia::factory()->count(1)->create();

        $response = $this->get('/moodle-media');
        $response->assertStatus(200);
    }
    /**
     * @test
     */
    public function media_can_be_stored()
    {
        $this->withoutExceptionHandling();
        $this->authenticatedUser();
        $data = [
            'description_en' => 'description-en',
            'description_fr' => 'description-fr',
            'media' => UploadedFile::fake()->image('avatar.jpg'),
            'title_en' => 'title-en',
            'title_fr' => 'title-fr',
            'license_id' => MoodleMediaLicense::factory()->create()->id,
            'keywords_en' => 'keyword-en',
            'keywords_fr' => 'mots-cles-fr',
        ];
        $response = $this->post('/moodle-media' ,
           $data
        );
        $response->assertStatus(302);
    }
    /**
     * @test
     */

    public function Unauthenticated_can_not_store_media()
    {
        $data = [
            'description_en' => 'jfodsajfosdja',
            'description_fr' => 'jfodsajfosdja',
            'media' => UploadedFile::fake()->image('avatar.jpg'),
            'title_en' => 'en_updated',
            'title_fr' => 'fr_updated',
            'license_id' => MoodleMediaLicense::factory()->create()->id,
            'keywords_en' => 'ggfgd',
            'keywords_fr' => 'ggfgd',
        ];
        $response = $this->post('/moodle-media' ,
            $data);
        $response->assertStatus(302);
    }

    /**
     * @test
     */

    public function media_can_be_updated()
    {
        $this->withoutExceptionHandling();
        $this->authenticatedUser();

        $media = MoodleMedia::factory()->create();
        $response = $this->patch('/moodle-media/' .$media->id, [

            'description_en' => 'updated_en',
            'description_fr' => 'updated_fr',
            'media' => UploadedFile::fake()->image('avatar.jpg'),
            'title_en' => 'sodsoadaso_en',
            'title_fr' => 'cococd_fr',
            'license_id' => MoodleMediaLicense::factory()->create()->id,
            'keywords_en' => 'dpkfdpskfkdp_en',
            'keywords_fr' => 'ovosvs_fr',

        ]);
        $response->assertStatus(302);
    }


    /**
     * @test
     */

    public function media_can_be_deleted()
    {
        $this->withoutExceptionHandling();
        $this->authenticatedUser();

        $media = MoodleMedia::factory()->create();
        $response = $this->delete('/moodle-media/' . $media->id);
        $response->assertStatus(302);

    }

    public function authenticatedUser()
    {
        $this->actingAs($user = User::factory()->create());
    }
}