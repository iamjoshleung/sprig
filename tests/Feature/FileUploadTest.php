<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Http\UploadedFile as UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Filesystem\Filesystem;

class FileUploadTest extends TestCase
{

    protected $currentDate;
    protected $filename;

    public function setUp() {
        parent::setUp();
        $this->currentDate = now()->toDateString();
        $this->filename = str_random(20) . '.jpg';
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
    public function test_a_user_can_upload_a_file() {
        $res = $this->json('POST', '/files', [
            'file' => UploadedFile::fake()->image($this->filename)
        ]);
        $content = $res->decodeResponseJson();

        Storage::assertExists($content['path']);
    }

    /** @test */
    public function test_file_not_exceed_10mb() {
        $exceededFileSize = 11000;
        $res = $this->json('POST', '/files', [
            'file' => UploadedFile::fake()->image($this->filename)->size($exceededFileSize)
        ]);
        $res->assertStatus(422);
    }

    /** @test */
    public function test_file_in_certain_formats() {
        // Storage::fake("uploads");
        // Storage::fake($this->currentDate);
        $filename = 'random';
        $allowedFormats = ['jpg', 'jpeg', 'png', 'gif', 'pdf', 'doc', 'zip', 'rar', 'torrent', 'mp4', 'mp3'];
        foreach($allowedFormats as $format) {
            $res = $this->json('POST', '/files', [
                'file' => UploadedFile::fake()->create("{$filename}.{$format}")
            ]);
            $content = $res->decodeResponseJson();
            $res->assertStatus(201);
            Storage::assertExists($content['path']);
        }

        $disallowedFormats = ['php', 'js', 'py', 'avi'];
        foreach($disallowedFormats as $format) {
            $res = $this->json('POST', '/files', [
                'file' => UploadedFile::fake()->create("{$filename}.{$format}") 
            ]);
            $res->assertStatus(422);
        }
    }

    /** @test */
    public function test_file_download_and_remove_link_included_in_the_response() {
        $res = $this->json('POST', '/files', [
            'file' => UploadedFile::fake()->create($this->filename)
        ]);
        $content = $res->decodeResponseJson();

        $this->assertNotEmpty($content['link']); // same link, different http method
    }

    /** @test */
    public function test_file_can_be_deleted_from_server_with_a_token() {
        // upload a file to server
        $content = $this->json('POST', '/files', [
            'file' => UploadedFile::fake()->create($this->filename)
        ])->decodeResponseJson();

        // delete it from server
        $res = $this->json('DELETE', "/files/{$content['id']}/{$content['deleteToken']}");

        // assert that it's not in the server, and file removed
        $res->assertStatus(204);
        $this->assertDatabaseMissing('files', [
            'path' => $content['path']
        ]);
        Storage::assertMissing($content['path']);
    }

    /** @test */
    public function test_401_returned_when_deleting_files_with_invalid_token() {
        $content = $this->json('POST', '/files', [
            'file' => UploadedFile::fake()->create($this->filename)
        ])->json();

        $res = $this->json('DELETE', "/files/{$content['id']}/invalid_token_here");
        
        $res->assertStatus(401);
    }
}
