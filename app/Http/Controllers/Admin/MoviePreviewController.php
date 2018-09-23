<?php

namespace App\Http\Controllers\Admin;

use App\Movie;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Spatie\MediaLibrary\Models\Media;

class MoviePreviewController extends Controller
{
    /**
     * 
     * 
     * @return 
     */
    public function destroy(Movie $movie, Media $preview) {
        $preview->delete();
        return response([], 204);
    }
}
