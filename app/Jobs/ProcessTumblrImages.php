<?php

namespace App\Jobs;

use App\TumblrSite;
use Illuminate\Bus\Queueable;
use App\Services\TumblrFilter;
use App\Services\TumblrScrapper;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use App\Exceptions\TumblrRequestException;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class ProcessTumblrImages implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct()
    {
    }

    /**
     * Execute the job.
     */
    public function handle()
    {
        $sites = TumblrSite::all();
        foreach ($sites as $site) {
            $scrapper = new TumblrScrapper($site);

            try {
                $posts = $scrapper->scrapImagePosts();
            } catch (TumblrRequestException $e) {
                report($e);
                continue;
            }

            $filter = new TumblrFilter($site->last_scrapped_images_at, $posts);

            $collection = $filter->getFilteredImages($filter->filterOldPosts($posts));

            if (sizeof($collection) <= 0) {
                continue;
            }

            foreach ($collection as $images) {
                $site->photosets()->create([
                    'images' => json_encode($images),
                ]);
            }

            $site->update([
                'last_scrapped_images_at' => now(),
            ]);
        }
    }
}
