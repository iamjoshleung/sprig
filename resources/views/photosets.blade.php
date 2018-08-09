@extends('layouts.master') 
@section('main')
<div class="l-photosets">
    <div class="container">
        <div class="row">
    {{-- <!-- @foreach($photosets as $collection) 
                    <div class="card">
                        <img class="card-img-top" src="{{ $collection['images'][0]['alts'][0]['url'] }}" alt="Card image cap">
                    </div>
                @endforeach --> --}}
                <photosets :data="{{ json_encode($photosets) }}"></photosets>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="d-flex justify-content-center mt-5">
                    <paginator :data="{{ json_encode($photosets) }}"></paginator>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection