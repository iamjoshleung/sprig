<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TumblrSite extends Model
{
    const UPDATED_AT = null;

    protected $fillable = ['identifier', 'url', 'last_scrapped_images_at', 'last_scrapped_videos_at'];

    /**
     * Define relationship with Photoset
     *
     * @return void
     */
    public function photosets() {
        return $this->hasMany(Photoset::class, 'site_id', 'id');
    }

    /**
     * 
     * 
     * @return 
     */
    public function videos() {
        return $this->hasMany(Video::class, 'site_id', 'id');
    }
}
