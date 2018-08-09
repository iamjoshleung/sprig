<?php

namespace Tests\Feature;

use App\TumblrSite;
use Tests\TestCase;
use App\Services\TumblrScrapper;
use App\Jobs\ProcessTumblrImages;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Services\TumblrFilter;

class ScrapTumblrImagesTest extends TestCase
{

    protected $site;

    public function setUp()
    {
        parent::setUp();

        $this->site = TumblrSite::create([
            'url' => 'http://ianloveasianmen.tumblr.com/'
        ]);
    }

    /** @test */
    public function it_get_the_lastest_20_images_post_from_site()
    {
        $scrapper = new TumblrScrapper($this->site);

        $this->assertCount(20, $scrapper->scrapImagePosts());
    }

    /** @test */
    // public function each_collection_of_images_in_a_post_will_be_saved_to_DB_when_processed_by_cron_job()
    // {

    // }
}
