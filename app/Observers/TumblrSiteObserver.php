<?php

namespace App\Observers;

use App\TumblrSite;
use InvalidArgumentException;


class TumblrSiteObserver
{
    /**
     * Listen to the TumblrSite creating event
     * 
     * @return 
     */
    public function creating(TumblrSite $site) {
        $site->identifier = $this->getIdentifier($site->url);
    }

    /**
     * Extract identifier from the url
     *
     * @param string $url
     * @return string
     */
    protected function getIdentifier($url) {
        if( preg_match("/(?:http|https):\/\/(?:www.)?(.*).tumblr.com\/?/i", $url, $match) ) {
            return $match[1];
        } else {
            throw new InvalidArgumentException('Invalid url.');
        }
    }
}
