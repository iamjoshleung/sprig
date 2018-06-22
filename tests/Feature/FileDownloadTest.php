<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Http\UploadedFile;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class FileDownloadTest extends TestCase
{
    public function setUp() {
        parent::setUp();
        Storage::fake('testing');
    }

    /**
     * 
     * 
     * @return 
     */
    public function tearDown()
    {
        $file = new Filesystem;
        $file->cleanDirectory(storage_path() . '/app/public/testing/');
    }

    /** @test */
    public function test_token_generated_when_user_initiate_download() {
        $file = $this->json('POST', '/files', [
            'file' => UploadedFile::fake()->image('random.jpg')
        ])->json();
        // dd($file);
        $result = $this->json('GET', "/files/{$file['id']}/token")->json();
        // dd($result);
        $this->assertEquals(20, strlen($result['token']));
    }

    /** @test */
    public function test_token_expires_after_30_mins_of_creation() {
        $file = factory(\App\File::class)->create();
        $token = factory(\App\DownloadToken::class)->create([
            'expired_at' => now()->subMinutes(31)
        ]);
        
        $res = $this->json('GET', "/files/{$file->getRouteKey()}/download/{$token['token']}");

        $res->assertStatus(403);
    }

    /** @test */
    public function download_count_increase_by_one_after_download() {
        $file = $this->json('POST', '/files', [
            'file' => UploadedFile::fake()->image('random.jpg')
        ])->json();

        $token = $this->json('GET', "/files/{$file['id']}/token")->json();

        $content = $this->json('GET', "/files/{$file['id']}/download/{$token['token']}");

        $file = \App\File::latest()->first();

        $this->assertEquals(1, $file->downloads);
    }
}
