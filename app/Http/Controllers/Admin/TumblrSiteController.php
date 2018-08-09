<?php

namespace App\Http\Controllers\Admin;

use App\TumblrSite;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\CreateTumblrSite;

class TumblrSiteController extends Controller
{
    /**
     * 
     * 
     * @return 
     */
    public function index() {
        return view('cm.sites', ['sites' => TumblrSite::all()]);
    }

    /**
     * 
     * 
     * @return 
     */
    public function store(CreateTumblrSite $request) {
        // dd(request()->all());
        $site = TumblrSite::create(request()->all());
        return response($site, 201);
    }

    /**
     * 
     * 
     * @return 
     */
    public function destroy(TumblrSite $tumblr_site) {
        $tumblr_site->delete();
        return response([], 204);
    }
}
