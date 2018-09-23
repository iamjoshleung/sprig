<?php

namespace App\Http\Controllers\Admin;

use App\Movie;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Spatie\MediaLibrary\Models\Media;

class MovieCoverController extends Controller
{
    /**
     * 
     * 
     * @return 
     */
    public function destroy(Movie $movie, Media $cover) {
        $cover->delete();
        return response([], 204);
    }
}
