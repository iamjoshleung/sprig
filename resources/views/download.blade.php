@extends('layouts.master')

@section('main')
    <div class="l-download pageHeroBottom">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <download-steps :file="{{ json_encode($file) }}"></download-steps>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts-after')
    {!! NoCaptcha::renderJs() !!}
@endpush
