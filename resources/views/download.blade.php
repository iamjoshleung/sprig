@extends('layouts.master')

@section('main')
    <div class="l-download pageHeroBottom">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <download-steps :file="{{ json_encode($file) }}"></download-steps>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="l-download--ads-copy">
                        <h4 class="mb-2"><small>Ads</small></h4>
                        <p>Google unveils Cloud Services Platform, a family of cloud services. While infrastructure-as-a-service has existed for more than a decade, the market for cloud computing still has substantial room for growth: Worldwide spending on public cloud services will reach $186.4 billion this year, according to Gartner, yet remains just a fraction of overall IT spending.
                            Recognizing this, Google on Tuesday unveiled the Cloud Services Platform, an integrated family of cloud services designed for organizations with workloads that remain on premise. The platform made its debut on the first day of the Google Next cloud conference in San Francisco.
                            Earlier, Chen Goldberg, Google director of engineering, explained to reporters that the Cloud Services Platform "allows you to modernize wherever you are and at your own pace." By accommodating the reality of hybrid IT, Goldberg said, Google is "catering to the needs of IT organizations today and in the future."
                            </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts-after')
    {!! NoCaptcha::renderJs() !!}
@endpush
