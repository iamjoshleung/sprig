<?php

namespace App;
use App\Http\Traits\Hashidable;

use Illuminate\Database\Eloquent\Model;

class File extends Model
{
    use Hashidable;

    protected $guarded = [];
    protected $appends = ['hashId', 'link'];
    
    protected $hidden = ['path', 'id', 'downloads', 'delete_token'];

    /**
     * Define the relationship between DownloadToken and File
     * 
     * @return 
     */
    public function tokens() {
        return $this->hasMany(DownloadToken::class);
    }

    /**
     * Get custom attribute -- hashId
     * 
     * @return 
     */
    public function getHashIdAttribute() {
        return $this->getRouteKey();
    }

    /**
     * 
     * 
     * @return 
     */
    public function getLinkAttribute() {
        return route('files.show', $this);
    }
}
