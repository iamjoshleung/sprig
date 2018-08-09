<?php

namespace Tests\Feature;

use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CreatePhotosetsTest extends TestCase
{
    /** @test */
    public function non_admin_cannot_remove_photosets()
    {
        $this->actingAs(factory('App\User')->create());

        $photosets = factory('App\Photoset')->create();

        $this->deleteJson("/photosets/{$photosets->id}")
            ->assertStatus(401);

        $this->assertDatabaseHas('photosets', ['id' => $photosets->id]);
    }

    /** @test */
    public function admin_can_remove_photosets()
    {
        $this->actingAs(factory('App\User')->create([
            'type' => User::ADMIN_TYPE
        ]));

        $photosets = factory('App\Photoset')->create();

        $this->deleteJson("/photosets/{$photosets->id}")
            ->assertStatus(204);

        $this->assertDatabaseMissing('photosets', ['id' => $photosets->id]);
    }
}
