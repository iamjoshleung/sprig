@extends('layouts.master') 

@section('title', "圖集 |")

@section('main')
<div class="l-photosets">
    <div class="container">
        <div class="row">
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