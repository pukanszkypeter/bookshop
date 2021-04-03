@extends('layouts.app')
@section('title', 'New genre')

@section('content')
<div class="container">
    <h1>New genre</h1>
    <p class="mb-1">On this page you can create a new genre. You can assign books by editing the book after creating the genre and checking that genre there as well.</p>
    <div class="mb-4">
        <a id="all-books-ref" href="{{ route('books.index') }}" class="btn btn-primary btn-sm"><i class="fas fa-long-arrow-alt-left"></i> Back to books</a>
    </div>

    @if (Session::has('genre-created'))
        <div id="genre-created" class="alert alert-success" role="alert">
            The <span id="genre-name"><strong>{{ Session::get('genre-created') }}</strong></span> genre was successfully created!
        </div>
    @endif

    <form action="{{ route('genres.store') }}" method="POST">
        @csrf
        <div class="form-group row">
            <label for="name" class="col-sm-2 col-form-label">Name*</label>
            <div class="col-sm-10">
                <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" placeholder="Genre name" value="{{ old('name') }}">
                @error('name')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>
        </div>
        <div class="form-group row">
            <label for="inputPassword" class="col-sm-2 col-form-label">Style*</label>
            <div class="col-sm-10">
                @foreach ($styles as $style)
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="style" id="style-{{ $style }}" value="{{ $style }}" {{ old('style') === $style ? 'checked' : '' }}>
                        <label class="form-check-label" for="style-{{ $style }}">
                            <span class="badge badge-{{ $style }}">{{ $style }}</span>
                        </label>
                    </div>
                @endforeach
                @error('style')
                    <p class="text-danger small">{{ $message }}</p>
                @enderror
            </div>
        </div>
        <div class="text-center">
            <button type="submit" class="btn btn-primary">Create</button>
        </div>
    </form>
</div>
@endsection
