<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Video;

class VideoController extends Controller
{
    public function index() {
        $itemsPerPage = 20;

        if(request()->wantsJson()) {
            return Video::latest()->paginate($itemsPerPage);
        }

        return view('videos', ['videos' => Video::latest()->paginate($itemsPerPage)]);
    }
}
