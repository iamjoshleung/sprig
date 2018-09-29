@extends('layouts.master') 
@section('main')
<div class="l-download pageHeroBottom">
    <div class="container">
        <div class="row">
            <div class="col-12 col-lg-8">
                <download-steps :file="{{ json_encode($file) }}"></download-steps>
            </div>
            <div class="col-12 col-lg-4">
                <div class="row">
                    <h3 class="h4 font-weight-normal mb-4">更多電影</h3>
                    @foreach($featuredMovies as $fMovie)
                    <div class="col-12 p-0">
                        <article class="mb-5 more-movie-item">
                            <a href="{{ route('movies.show', $fMovie) }}" class="text-dark">
                                <div class="d-flex">
                                    <div class="col-3 p-0 pr-4">
                                        {{ $fMovie->getMedia('cover')[0]('thumb') }}
                                    </div>
                                    <h3 class="h4 flex-grow-1"><span class="badge badge-pill badge-success">推薦</span> {{ $fMovie->title }}</h3>
                                </div>
                            </a>
                        </article>
                    </div>
                    @endforeach @foreach($topMovies as $rMovie)
                    <div class="col-12 p-0">
                        <article class="mb-5 more-movie-item">
                            <a href="{{ route('movies.show', $rMovie) }}" class="text-dark">
                                <div class="d-flex">
                                    <div class="col-3 p-0 pr-4">
                                        {{ $rMovie->getMedia('cover')[0]('thumb') }}
                                    </div>
                                    <h3 class="h4 flex-grow-1">{{ $rMovie->title }}</h3>
                                </div>
                            </a>
                        </article>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
        {{--
        <div class="row">
            <div class="col-12">
                <div class="l-download--ads-copy">
                    <h4 class="mb-2"><small>Ads</small></h4>
                    <p>Google unveils Cloud Services Platform, a family of cloud services. While infrastructure-as-a-service
                        has existed for more than a decade, the market for cloud computing still has substantial room for
                        growth: Worldwide spending on public cloud services will reach $186.4 billion this year, according
                        to Gartner, yet remains just a fraction of overall IT spending. Recognizing this, Google on Tuesday
                        unveiled the Cloud Services Platform, an integrated family of cloud services designed for organizations
                        with workloads that remain on premise. The platform made its debut on the first day of the Google
                        Next cloud conference in San Francisco. Earlier, Chen Goldberg, Google director of engineering, explained
                        to reporters that the Cloud Services Platform "allows you to modernize wherever you are and at your
                        own pace." By accommodating the reality of hybrid IT, Goldberg said, Google is "catering to the needs
                        of IT organizations today and in the future."
                    </p>
                </div>
            </div>
        </div> --}}
    </div>
</div>
@endsection
 @push('scripts-after') {!! NoCaptcha::renderJs() !!} 
@endpush