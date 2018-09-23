@extends('cm.app') 
@section('content')
<div class="container">
    <div class="row">
        <div class="col-12">
            <h1 class="h3 mb-4">Create a new movie</h1>
            @if(session()->has('message'))
            <div class="alert alert-success" role="alert">
                    Movie has been created
            </div>
            @endif
            <form method="POST" action="{{ route('cm.movies.store') }}" enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                    <label for="title">Title</label>
                    <input type="text" name="title" class="form-control" id="title">
                </div>
                <div class="form-group">
                    <label for="issuer">Issuer</label>
                    <input type="text" name="issuer" class="form-control" id="issuer">
                </div>
                <div class="form-group">
                    <label for="description">Description</label>
                    <textarea class="form-control" name="desc" id="description" rows="3"></textarea>
                </div>
                <div class="form-group">
                    <label for="download_link">Download Link</label>
                    <input type="url" name="download_link" class="form-control" id="download_link">
                </div>
                <div class="form-group">
                    <label for="released_at">Released at</label>
                    <input type="date" name="released_at" class="form-control" id="released_at">
                </div>
                <div class="form-group">
                    <label for="cover_image">Cover</label>
                    <input type="file" name="cover_image" class="form-control-file" id="cover_image">
                </div>
                <div class="form-group">
                    <label for="preview_images">Preview Images</label>
                    <input type="file" name="preview_images[]" class="form-control-file" id="preview_images" multiple>
                </div>
                <button type="submit" class="btn btn-primary">Submit</button>
            </form>
        </div>
    </div>
</div>
@endsection