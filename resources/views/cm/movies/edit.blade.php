@extends('cm.app') 
@section('content')
<app-movies-edit class="container l-movie-edit" inline-template>
    <div class="row">
        <div class="col-12">
            <h1 class="h3">Editting "{{ $movie->title }}"</h1>

            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            
            <form method="POST" action="{{ route('cm.movies.update', $movie) }}" enctype="multipart/form-data">
                @csrf @method('PATCH')
                <div class="form-group">
                    <label for="title">Title</label>
                    <input type="text" name="title" class="form-control" id="title" value="{{ $movie->title }}" required>
                </div>
                <div class="form-group">
                    <label for="issuer">Issuer</label>
                    <input type="text" name="issuer" class="form-control" id="issuer" value="{{ $movie->issuer }}">
                </div>
                <div class="form-group">
                    <label for="description">Description</label>
                    <textarea class="form-control" name="desc" id="description" rows="3" max="5000">{{ $movie->desc }}</textarea>
                </div>
                <div class="form-group">
                    <label for="download_link">Download Link</label>
                    <input type="url" name="download_link" class="form-control" id="download_link" value="{{ $movie->download_link }}" required>
                </div>
                <div class="form-group">
                    <label for="released_at">Released at</label>
                    <input type="date" name="released_at" class="form-control" id="released_at" value="{{ $movie->released_at->format('Y-m-d') }}">
                </div>
                <div class="form-group">
                    <label for="is_featured">Is featured?</label>
                    <input type="hidden" name="is_featured" value="0">
                    <input type="checkbox" name="is_featured" class="form-check-input ml-5" id="is_featured" value="1" @if($movie->is_featured) checked=true @endif>
                </div>
                {{ $movie->is_featured }}
                <div class="form-group">
                    <label for="cover_image">Cover</label>
                    <input type="file" name="cover_image" class="form-control-file" id="cover_image"> 

                    @if($movie->getMedia('cover')->count() > 0)
                    <div class="mt-3">
                        <div class="movie-img">
                            {!! $movie->getMedia('cover')[0]->toHtml() !!}
                            <button type="button" class="btn btn-primary" @click="removeCoverImg( {{ $movie->id }}, {{ $movie->getMedia('cover')[0]->id }} )">Delete</button>
                        </div>
                    </div>
                    @endif

                </div>
                <div class="form-group">
                    <label for="preview_images">Preview Images</label>
                    <input type="file" name="preview_images[]" class="form-control-file" id="preview_images" multiple>


                    <div class="mt-3">
                        @if($movie->getMedia('previews')->count() > 0) @foreach($movie->getMedia('previews') as $preview)
                        <div class="movie-img">
                            {!! $preview->toHtml() !!}
                            <button type="button" class="btn btn-primary" @click="removePreviewImg( {{$movie->id}}, {{ $preview->id }})">Delete</button>
                        </div>
                        @endforeach @endif

                    </div>
                </div>
                <button type="submit" class="btn btn-primary">Submit</button>
            </form>
        </div>
    </div>
</app-movies-edit>
@endsection