<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DownloadToken extends Model
{
    protected $fillable = ['token', 'file_id', 'expired_at'];

    protected $hidden = ['id', 'file_id', 'created_at', 'updated_at'];

    /**
     * Define the relationship between DownloadToken and File
     * 
     * @return 
     */
    public function file() {
        return $this->belongsTo(File::class);
    }

    /**
     * Get the route key for the model
     *
     * @return string
     */
    public function getRouteKeyName()
    {
        return 'token';
    }
}
