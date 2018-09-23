@extends('layouts.master') 
@section('main')
<div class="l-movies js-page-movies-index">
    <div class="container">
        <div class="row l-movies__items">
            <div class="col-12">
                @foreach($movies as $movie)
                <a href="{{ route('movies.show', $movie) }}" class="card text-dark">
                    <div class="card-img">
                        {{ $movie->getMedia('cover')[0] }}
                    </div>

                    <div class="card-body">
                        {{ $movie->title }}
                    </div>
                </a>
                @endforeach

                {{ $movies->links() }}
            </div>
        </div>
    </div>
</div>
@endsection