<?php

namespace Tests;

use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;
    use RefreshDatabase;

    /**
     * 
     * 
     * @return 
     */
    public function signIn($user = null) {
        $user = $user ?? factory(User::class)->create();

        $this->actingAs($user);
    }

    /**
     * 
     * 
     * @return 
     */
    public function signInAsAdmin() {
        $admin = $this->signIn(factory('App\User')->create(['type' => User::ADMIN_TYPE]));
    }
}
