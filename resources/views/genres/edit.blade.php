@extends('layouts.app')
@section('title', 'Edit genre: '.$genre->name)

@section('content')
<div class="container">
    <h1>Edit genre</h1>
    <p class="mb-1">On this page you can edit genres. You can assign books by editing the book after editing the genre and checking that genre there as well.</p>
    <div class="mb-4">
        <a id="all-books-ref" href="{{ route('books.index') }}" class="btn btn-primary btn-sm"><i class="fas fa-long-arrow-alt-left"></i> Back to books</a>
    </div>

    @if (Session::has('genre-updated'))
        <div id="genre-updated" class="alert alert-success" role="alert">
            The <span id="genre-name"><strong>{{ Session::get('genre-updated') }}</strong></span> genre has been successfully updated!
        </div>
    @endif

    <form action="{{ route('genres.update', $genre) }}" method="POST">
        @method('PATCH')
        @csrf
        <div class="form-group row">
            <label for="name" class="col-sm-2 col-form-label">Name*</label>
            <div class="col-sm-10">
                <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" placeholder="Genre name" value="{{ old('name') ? old('name') : $genre->name }}">
                @error('name')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>
        </div>
        <div class="form-group row">
            <label class="col-sm-2 col-form-label">Style* {{ old('style') }} </label>
            <div class="col-sm-10">
                @foreach ($styles as $style)
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="style" id="style-{{ $style }}" value="{{ $style }}" {{ old('style') === $style ? 'checked' : ($genre->style === $style && !old('style') ? 'checked' : '') }}>
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
            <button type="submit" class="btn btn-primary">Update</button>
        </div>
    </form>
</div>
@endsection
