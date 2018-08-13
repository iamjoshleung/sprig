@extends('layouts.master') 
@section('main')
<page-videos :data="{{ json_encode($videos) }}"></page-videos>
@endsection