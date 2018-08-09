<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Photoset;

class PhotosetController extends Controller
{

    public function index() {
        $photosets = Photoset::latest()->simplePaginate(20);
        
        $photosets->getCollection()->transform(function($collection) {
            $collection->images = json_decode($collection['images'], true);
            return $collection;
        });
        
        return view('photosets', ['photosets' => $photosets]);
    }

    public function destroy(Photoset $photoset) {
        $photoset->delete();
        return response([], 204);
    }
}
