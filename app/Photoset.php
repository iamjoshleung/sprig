<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Photoset extends Model
{

    protected $fillable = ['images', 'site_id'];

    /**
     * Define relationship with TumblrSite
     *
     * @return void
     */
    public function site() {
        return $this->belongsTo(TumblrSite::class, 'site_id', 'id');
    }
}
