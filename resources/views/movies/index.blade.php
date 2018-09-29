@extends('layouts.master') 
@section('main')
<div class="l-movies js-page-movies-index">
    <div class="container">
        <div class="row l-movies__items">
            <div class="col-12">
                <div class="js-items">
                    @foreach($movies as $movie)
                    <a href="{{ route('movies.show', $movie) }}" class="card text-dark d-block">
                        <div class="card-img">
                            {{ $movie->getMedia('cover')[0] }}
                        </div>

                        <div class="card-body">
                            {{ $movie->title }}
                        </div>
                    </a>
                    @endforeach
                </div>
            </div>
            <div class="col-12 d-flex justify-content-center mb-5">
                {{ $movies->links() }}
            </div>
        </div>
    </div>
</div>
@endsection