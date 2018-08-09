<?php

namespace Tests\Feature;

use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AdminFileManagementTest extends TestCase
{
    /** @test */
    public function admins_can_fetch_files() {
        $admin = factory('App\User')->create([
            'type' => User::ADMIN_TYPE
        ]);

        $this->actingAs($admin);

        $files = factory('App\File', 4)->create();


        $res = $this->getJson('/cm/files');

        // dd($res->json()['data']);
            
        $res->assertStatus(200);

        $this->assertCount(4, $res->json()['data']);
        
    }

    /** @test */
    public function admins_can_remove_files() {
        $admin = factory('App\User')->create([
            'type' => User::ADMIN_TYPE
        ]);

        $this->actingAs($admin);

        $file = factory('App\File')->create();

        // dd($file->getRouteKey());

        $this->delete("/cm/files/{$file->getRouteKey()}")
            ->assertStatus(204);
    }
}
