<?php

namespace Tests\Feature;

use App\User;
use App\TumblrSite;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class AdminTumblrSitesManagementTest extends TestCase
{

    protected $admin;

    /**
     * 
     * 
     * @return 
     */
    public function setUp() {
        parent::setUp();
        $this->admin = factory('App\User')->create(['type' => User::ADMIN_TYPE]);
        $this->signIn($this->admin);
    }

    // use DatabaseMigrations;

    /** @test */
    public function admin_users_can_add_tumblr_sites()
    {

        $this->postJson(route('cm.sites.store'), [
            'url' => 'http://puppiestotherescue.tumblr.com/'
        ])
            ->assertStatus(201);

        $this->assertDatabaseHas('tumblr_sites', [
            'url' => 'http://puppiestotherescue.tumblr.com/',
            'identifier' => 'puppiestotherescue'
        ]);

    }

    /** @test */
    public function admin_can_delete_tumblr_sites()
    {

        $res = $this->postJson(route('cm.sites.store'), [
            'url' => 'http://puppiestotherescue.tumblr.com/'
        ]);
  
        $res->assertStatus(201);

        $site = $res->json();

        // dd($this->deleteJson(route('cm.sites.destroy', $site['id'])));
        $this->deleteJson(route('cm.sites.destroy', $site['id']))
            ->assertStatus(204);

        $this->assertCount(0, TumblrSite::all());
    }

    /** @test */
    public function repeated_sites_will_not_be_saved_to_DB()
    {
        $res = $this->postJson(route('cm.sites.store'), [
            'url' => 'http://puppiestotherescue.tumblr.com/'
        ]);

        $res->assertStatus(201);

        $res = $this->postJson(route('cm.sites.store'), [
            'url' => 'http://puppiestotherescue.tumblr.com/'
        ]);
        $res->assertStatus(422);

        $this->assertCount(1, TumblrSite::all());
    }
}
