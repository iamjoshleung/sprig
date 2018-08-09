<?php

namespace App\Services;

use App\TumblrSite;
use Tumblr\API\Client as TumblrClient;

class TumblrScrapper {

    protected $site;
    protected $client;

    public function __construct(TumblrSite $site) {
        $this->site = $site;

        $this->client = new TumblrClient( config('tumblr.api_key') );
    }

    public function scrapImagePosts() {
        $data = $this->client->getBlogPosts("{$this->site->identifier}.tumblr.com", array('type' => 'photo', 'limit' => 20));
        return $data->posts;
    }
}