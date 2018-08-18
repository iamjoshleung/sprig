<?php

/**
 * Responsible for filtering tumblr posts
 */

namespace App\Services;

use Carbon\Carbon;
use App\TumblrSite;

class TumblrFilter
{
    protected $posts;
    protected $last_scrapped_at;

    public function __construct($last_scrapped_at, array $posts)
    {
        $this->posts = $posts;
        $this->last_scrapped_at= $last_scrapped_at ?? Carbon::now()->subMonth();
    }

    /**
     * Filter the images by timestamp
     * Filter out image posts that already in the database
     * 
     * @return 
     */
    public function getFilteredImages($filteredPosts)
    {
        $posts = [];

        foreach ($filteredPosts as $post) {
            $collection = [];
            if( $post->type !== 'photo' ) {
                continue;
            }
            foreach ($post->photos as $photo) {
                $collection[sizeof($collection)] = [
                    'original' => $this->getOriginalImageData($photo),
                    'alts' => $this->getAlternativeImagesData($photo->alt_sizes)
                ];
            }
            $posts[] = $collection;
        }

        return $posts;
    }

    /**
     * 
     * 
     * @return 
     */
    public function getFilteredVideos($filteredPosts): array {
        $collection = [];

        foreach($filteredPosts as $post) {

            if($post->type !== 'video' || $post->video_type !== 'tumblr') {
                continue;
            }

            $collection[] = [
                'video_url' => $post->video_url,
                'thumbnail_url' => $post->thumbnail_url,
                'thumbnail_width' => $post->thumbnail_width,
                'thumbnail_height' => $post->thumbnail_height,
                'duration' => $post->duration
            ];
        }

        return $collection;
    }

    /**
     * 
     * 
     * @return 
     */
    public function filterOldPosts()
    {
        return collect($this->posts)->filter(function ($post) {
            return Carbon::createFromTimestamp($post->timestamp)->greaterThan($this->last_scrapped_at);
        });
    }

    /**
     * Return data about the original image of the post
     *
     * @param StdClass $data
     * @return array
     */
    private function getOriginalImageData($data)
    {
        return [
            "url" => $data->original_size->url,
            "width" => $data->original_size->width,
            "height" => $data->original_size->height
        ];
    }

    /**
     * Return data about the alternative images of the post
     *
     * @param StdClass $data
     * @return array
     */
    private function getAlternativeImagesData($data)
    {
        $images = [];
        foreach ($data as $alt) {
            $images[] = [
                "url" => $alt->url,
                "width" => $alt->width,
                "height" => $alt->height
            ];
        }

        return $images;
    }
}