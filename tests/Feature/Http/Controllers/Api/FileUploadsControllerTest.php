<?php

namespace Tests\Feature\Http\Controllers\Api;

use Tests\TestCase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class FileUploadsControllerTest extends TestCase
{
    /**
     * @test
     */
    public function user_can_upload_an_image_with_specified_json_structure()
    {
        $image = UploadedFile::fake()->image('image.jpg', 10, 10);
        $data = [
            'image' => $image,
            'directory' => 'images/'
        ];

        $response = $this->post('/api/file-upload/image', $data, [
            'enctype' => 'multipart/form-data'
        ]);

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'data' => [
                'url'
            ],
            'message',
            'status',
            'status_message'
        ]);

        Storage::disk('local')->assertExists("images/{$image->hashName()}");
    }

    /**
     * test
     */
    public function user_can_upload_a_video_with_specified_json_structure()
    {
        $video = UploadedFile::fake()->create('video.mp4');
        $data = [
            'video' => $video,
            'directory' => 'videos/'
        ];

        $response = $this->post('/api/file-upload/video', $data, [
            'enctype' => 'multipart/form-data'
        ]);

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'data' => [
                'url'
            ],
            'message',
            'status',
            'status_message'
        ]);
        Storage::disk('local')->assertExists("images/{$video->hashName()}");
    }
}
