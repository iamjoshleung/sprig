<?php

namespace App\Jobs;

use App\Photoset;
use Carbon\Carbon;
use App\TumblrSite;
use Illuminate\Bus\Queueable;
use App\Services\TumblrFilter;
use App\Services\TumblrScrapper;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class ProcessTumblrImages implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {

    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {

        $sites = TumblrSite::all();
        foreach ($sites as $site) {
            $scrapper = new TumblrScrapper($site);

            $posts = $scrapper->scrapImagePosts();

            $filter = new TumblrFilter($site->last_scrapped_at, $posts);

            $collection = $filter->getFilteredImages($filter->filterOldPosts($posts));

            // \Log::debug($site->identifier . '\n');
            // \Log::debug($collection);

            if( sizeof($collection) <= 0 ) continue;

            foreach ($collection as $images) {
                $site->photosets()->create([
                    'images' => json_encode($images)
                ]);
            }

            $site->update([
                'last_scrapped_at' => now()
            ]);
        }
    }
}
