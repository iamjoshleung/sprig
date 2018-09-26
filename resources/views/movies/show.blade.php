@extends('layouts.master') 
@section('main')
<page-show-movie class="l-movies-show js-pages-movies-show" :data="{{ $movie }}" inline-template>
    <div class="container">
        <div class="row">
            <div class="col-12 col-lg-6">
                <div class="cover">
                    {{ $movie->getMedia('cover')[0] }}
                </div>

                <div class="previews">
                    @foreach($movie->getMedia('previews') as $preview)
                    <a href="{{ $preview->getFullUrl() }}" class="preview-img">
                        {{ $preview }}
                    </a> @endforeach
                </div>
            </div>

            <div class="col-12 col-lg-6">
                <div class="mt-4 mt-lg-0 meta">
                    <div class="d-inline-block">@if($movie->issuer) <span>發行商</span> <span>{{ $movie->issuer }}</span> @endif</div>
                    <div class="d-inline-block">
                        @if($movie->released_at) <span>/ 發行日期</span> <span>{{ $movie->released_at->toDateString('Y-m-d') }}</span>                        @endif
                    </div>
                </div>
                <h1 class="mt-4 h3">{{ $movie->title }}</h1>

                @if( $movie->desc )
                <p class="mt-5">簡介</p>
                <div class="desc">
                    {!! $movie->desc !!}
                </div>
                @endif

                <div class="mt-5">
                    <a href="{{ $movie->download_link }}" class="button button-primary">下載地址</a>
                </div>
            </div>
        </div>

        <div class="col-12 mt-5">
            @if($topMovies->count() > 0)
            <h3 class="h4 mb-5">更多電影</h3>
            @endif

            <div class="row">
                @foreach($topMovies as $rMovie)
                <div class="col-12 col-lg-3">
                    <article class="mb-5 more-movie-item">
                        <a href="{{ route('movies.show', $rMovie) }}" class="text-dark">
                                    {{ $rMovie->getMedia('cover')[0]('thumb') }}
                                    <h3 class="mt-3">{{ $rMovie->title }}</h3>
                                </a>
                    </article>
                </div>
                @endforeach
            </div>

            {{-- <div class="d-flex flex-wrap justify-content-between">
                @foreach($topMovies as $rMovie)
                <article class="mb-5 more-movie-item">
                    <a href="{{ route('movies.show', $rMovie) }}" class="text-dark">
                        {{ $rMovie->getMedia('cover')[0]('thumb') }}
                        <h3 class="mt-3">{{ $rMovie->title }}</h3>
                    </a>
                </article>
                @endforeach
            </div> --}}
        </div>
    </div>
</page-show-movie>
@endsection