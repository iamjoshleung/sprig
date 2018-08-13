<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Video extends Model
{
    protected $guarded = [];

    /**
     * 
     * 
     * @return 
     */
    public function site() {
        return $this->belongsTo(TumblrSite::class, 'site_id', 'id');
    }
}
