<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Http\UploadedFile;
use Storage;
use App\Models\User;

class FormXMLTest extends TestCase
{

    public function test_loga_usuario()
    {
        $user = User::factory()->create();

        $response = $this->post('/login', [
            'email' => $user->email,
            'password' => 'password',
        ]);
        $this->assertAuthenticated();
        return $user;
    }

    /**
     * @depends test_loga_usuario
     */
    public function test_upload_sync($user)
    {
        $this->post('/login', [
            'email' => $user->email,
            'password' => 'password',
        ]);

        $response = $this->actingAs($user)->post(route('xml-file.upload'), [
            'file' => UploadedFile::fake()->create('document.xml', 500, 'application/xml')
        ]);

        $response->assertStatus(200);
        return $user;
    }


    /**
     * @depends test_upload_sync
     */
    public function test_upload_async($user)
    {
        $this->post('/login', [
            'email' => $user->email,
            'password' => 'password',
        ]);

        $this->assertAuthenticated();

        $response = $this->post(route('xml-file.upload'), [
            'backgroud' => 1,
            'file' => UploadedFile::fake()->create(
                'document.xml', 500, 'application/xml',
            )
        ]);

        $response->assertStatus(200);

    }
}
