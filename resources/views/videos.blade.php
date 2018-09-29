@extends('layouts.master') 

@section('title', "視頻 |")

@section('main')
<page-videos :data="{{ json_encode($videos) }}"></page-videos>
@endsection