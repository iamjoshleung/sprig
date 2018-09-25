<?php

namespace App;

use Spatie\MediaLibrary\File;
use App\Http\Traits\Hashidable;
use Spatie\Image\Manipulations;
use Spatie\MediaLibrary\Models\Media;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia\HasMedia;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;

class Movie extends Model implements HasMedia
{
    use HasMediaTrait, Hashidable;

    protected $guarded = [];

    protected $dates = [
        'created_at',
        'updated_at',
        'released_at'
    ];

    protected $casts = [
        'released_at' => 'datetime:Y-m-d',
    ];

    public function registerMediaCollections()
    {
        $this->addMediaCollection('cover')
            ->acceptsFile(function (File $file) {
                return $file->mimeType === 'image/jpeg' || $file->mimeType === 'image/png';
            })
            ->singleFile()
            ->registerMediaConversions(function (Media $media) {
                $this
                    ->addMediaConversion('thumb')
                    ->withResponsiveImages()
                    ->crop(Manipulations::CROP_CENTER, 350, 350)
                    ->width(350)
                    ->height(350);
            });

        $this->addMediaCollection('previews')
            ->acceptsFile(function (File $file) {
                return $file->mimeType === 'image/jpeg' || $file->mimeType === 'image/png';
            })
            ->registerMediaConversions(function (Media $media) {
                $this
                    ->addMediaConversion('thumb')
                    ->withResponsiveImages()
                    ->width(250)
                    ->height(250);
            });
    }

    /**
     * 
     * 
     * @return 
     */
    public function visits() {
        return visits($this);
    }

    /**
     * 
     * 
     * @return 
     */
    public function getVisitCount() {
        return $this->visits()->count();
    }

    /**
     * 
     * 
     * @return 
     */
    public function increaseVisitCount() {
        $this->visits()->forceIncrement();
    }

    /**
     * 
     * 
     * @return 
     */
    public static function getTopMovies() {
        return visits(Movie::class)->period('week')->top(7);
    }

    /**
     * 
     * 
     * @return 
     */
    public function hasCoverImage() {
        return $this->getMedia('cover')->count() === 1;
    }
}
