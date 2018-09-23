<?php

namespace App\Http\Controllers;

use App\Movie;
use Illuminate\Http\Request;

class MovieController extends Controller
{
    /**
     * 
     * 
     * @return 
     */
    public function index() {
        $movies = Movie::orderBy('created_at', 'desc')->paginate(15);

        return view('movies.index', ['movies' => $movies]);
    }

    /**
     * 
     * 
     * @return 
     */
    public function show(Movie $movie) {
        $movie->increaseVisitCount();
        $topMovies = Movie::getTopMovies();

        return view('movies.show', ['movie' => $movie, 'topMovies' => $topMovies]);
    }
}
