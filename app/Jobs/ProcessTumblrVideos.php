<?php

namespace App\Jobs;

use App\Exceptions\TumblrRequestException;
use App\Services\TumblrFilter;
use App\Services\TumblrScrapper;
use App\TumblrSite;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ProcessTumblrVideos implements ShouldQueue
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
                $posts = $scrapper->scrapVideoPosts();
            } catch (TumblrRequestException $e) {
                report($e);
                continue;
            }
            $filter = new TumblrFilter($site->last_scrapped_videos_at, $posts);
            $collection = $filter->getFilteredVideos($filter->filterOldPosts($posts));
            if (sizeof($collection) <= 0) {
                continue;
            }
            foreach ($collection as $video) {
                $site->videos()->create([
                    'video_url' => $video['video_url'],
                    'thumbnail_url' => $video['thumbnail_url'],
                    'thumbnail_width' => $video['thumbnail_width'],
                    'thumbnail_height' => $video['thumbnail_height'],
                    'duration' => $video['duration'],
                ]);
            }

            $site->update([
                'last_scrapped_videos_at' => now(),
            ]);
        }
    }
}
