<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\TumblrSite;

class TumblrSiteTest extends TestCase
{
    /** @test */
    public function identifier_is_auto_extracted_when_saving_a_site() {
        $site = TumblrSite::create([
            'url' => 'https://www.example.tumblr.com/'
        ]);

        $this->assertEquals('example', $site->identifier);
    }
}
