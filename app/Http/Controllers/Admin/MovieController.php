<?php

namespace App\Http\Controllers\Admin;

use App\Movie;
use Exception;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class MovieController extends Controller
{

    /**
     * 
     * 
     * @return 
     */
    public function index()
    {
        $movies = Movie::orderBy('created_at', 'desc')->paginate(10);

        if (request()->wantsJson()) {
            return response($movies, 200);
        }

        return view('cm.movies', ['movies' => $movies]);
    }

    /**
     * 
     * 
     * @return 
     */
    public function show(Movie $movie)
    {
        $previewImages = [];

        foreach ($movie->getMedia('previews') as $img) {
            $previewImages[] = [
                'id' => $img->id,
                'url' => $img->getFullUrl(),
                'html' => $img->toHtml()
            ];
        };

        $coverImage = $movie->getMedia('cover')[0];

        $data = [
            'id' => $movie->id,
            'title' => $movie->title,
            'issuer' => $movie->issuer,
            'desc' => $movie->desc,
            'download_link' => $movie->download_link,
            'released_at' => $movie->released_at,
            'images' => [
                'cover' => [
                    'id' => $coverImage->id,
                    'url' => $coverImage->getFullUrl(),
                    'html' => $coverImage->toHtml()
                ],
                'previews' => $previewImages
            ]
        ];


        return response($data, 200);
    }

    /**
     * 
     * 
     * @return 
     */
    public function create()
    {
        return view('cm.movies.create');
    }

    /**
     * 
     * 
     * @return 
     */
    public function store()
    {

        request()->validate([
            'title' => 'required|min:5|max:255',
            'issuer' => 'nullable|max:255',
            'desc' => 'nullable|max:5000',
            'download_link' => 'required|url',
            'released_at' => 'nullable|date',
            'cover_image' => 'required|image',
            'preview_images.*' => 'nullable|image',
            'is_featured' => 'nullable|boolean'
        ]);

        $movie = Movie::create(request()->only(['title', 'issuer', 'released_at', 'desc', 'download_link', 'is_featured']));

        $movie->addMediaFromRequest('cover_image')->withResponsiveImages()->toMediaCollection('cover', config('filesystems.cloud'));
        
        if(request()->hasFile('preview_images')) {
            $movie->addMultipleMediaFromRequest(['preview_images'])->each(function ($fileAdder) {
                $fileAdder->withResponsiveImages()->toMediaCollection('previews', config('filesystems.cloud'));
            });
        }

        if (request()->wantsJson()) {
            return response($movie, 201);
        }

        return redirect()->back()->with('message', 'Created');
    }

    /**
     * 
     * 
     * @return 
     */
    public function destroy(Movie $movie)
    {
        $movie->delete();

        if (request()->wantsJson()) {
            return response([], 204);
        }

        return redirect()->back()->with('message', "Movie {$movie->title} has been deleted.");
    }

    /**
     * 
     * 
     * @return 
     */
    public function edit(Movie $movie)
    {
        return view('cm.movies.edit', ['movie' => $movie]);
    }

    /**
     * 
     * 
     * @return 
     */
    public function update(Movie $movie)
    {
        request()->validate([
            'title' => 'required|min:5|max:255',
            'issuer' => 'nullable|max:255',
            'desc' => 'nullable|max:5000',
            'download_link' => 'required|url',
            'released_at' => 'nullable|date',
            'cover_image' => 'nullable|image',
            'preview_images.*' => 'image',
            'is_featured' => 'nullable|boolean',
        ]);

        $movie->update(request()->only(['title', 'issuer', 'desc', 'download_link', 'released_at', 'is_featured']));

        if (request()->hasFile('cover_image')) {
            if ($movie->hasCoverImage()) {
                throw new Exception('Movie can have only have one cover image.');
            } else {
                $movie->addMediaFromRequest('cover_image')->withResponsiveImages()->toMediaCollection('cover', config('filesystems.cloud'));
            }
        }


        if( request()->hasFile('preview_images') ) {
            $movie->addMultipleMediaFromRequest(['preview_images'])->each(function ($fileAdder) {
                $fileAdder->withResponsiveImages()->toMediaCollection('previews', config('filesystems.cloud'));
            });
        }

        if (request()->wantsJson()) {
            return response([], 200);
        }

        return redirect()->back()->with('message', 'Updated');
    }
}
