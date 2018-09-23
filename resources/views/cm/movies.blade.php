@extends('cm.app') 
@section('content')
<div class="container">
    <div class="row">
        <div class="col-12 text-right">
            <a href="{{ route('cm.movies.create') }}" class="btn btn-primary">Create New Movie</a>
        </div>

        <div class="col-12 mt-5">

            @if(session()->has('message'))
            <div class="mb-4">
                <div class="alert alert-success" role="alert">
                    {{ session('message') }}
                </div>
            </div>
            @endif

            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Title</th>
                        <th scope="col">Created at</th>
                        <th scope="col">Visits</th>
                        <th scope="col">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($movies as $movie)
                    <tr>
                        <th scope="row">{{ $movie->id }}</th>
                        <td>{{ $movie->title }}</td>
                        <td>{{ $movie->created_at }}</td>
                        <td>{{ $movie->getVisitCount() }}</td>
                        <td>
                            <div class="d-flex">
                                <a href="{{ route('cm.movies.edit', $movie) }}" class="btn btn-primary btn-sm mr-3">Edit</a>
                                <form action="{{ route('cm.movies.destroy', $movie) }}" method="POST" class="d-inline-block">
                                    @method('DELETE') @csrf
                                    <button type="submit" class="btn btn-secondary btn-sm">Remove</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

            {{ $movies->links() }}
        </div>
    </div>
</div>
@endsection