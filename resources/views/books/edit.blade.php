@extends('layouts.app')
@section('title', 'Edit book: '.$book->title)

@section('content')
<div class="container">
<h1>Edit book</h1>
    <p class="mb-1">On this page you can edit books.</p>
    <div class="mb-4">
        <a id="all-books-ref" href="{{ route('books.index') }}" class="btn btn-primary btn-sm"><i class="fas fa-long-arrow-alt-left"></i> Back to books</a>
    </div>

    @if (Session::has('book-updated'))
        <div id="book-updated" class="alert alert-success" role="alert">
            The book called <span id="book-title"><strong>{{ Session::get('book-updated') }}</strong></span> has been successfully updated!
        </div>
    @endif

    <form action="{{ route('books.update', $book) }}" method="POST" enctype="multipart/form-data">
        @method('PATCH')
        @csrf

        <div class="form-group row">
            <label for="title" class="col-sm-2 col-form-label">Title*</label>
            <div class="col-sm-10">
                <input type="text" class="form-control @error('title') is-invalid @enderror" id="title" name="title" placeholder="Book's title" value="{{ old('title') ? old('title') : $book->title }}">
                @error('title')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>
        </div>

        <div class="form-group row">
            <label for="authors" class="col-sm-2 col-form-label">Authors*</label>
            <div class="col-sm-10">
                <input type="text" class="form-control @error('authors') is-invalid @enderror" id="authors" name="authors" placeholder="Author names" value="{{ old('authors') ? old('authors') : $book->authors }}">
                @error('authors')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>
        </div>

        <div class="form-group row">
            <label for="released_at" class="col-sm-2 col-form-label">Released At*</label>
            <div class="col-sm-10">
                <input type="date" class="form-control @error('released_at') is-invalid @enderror" id="released_at" name="released_at" value="{{ old('released_at') ? old('released_at') : $book->released_at }}">
                @error('released_at')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>
        </div>

        <div class="form-group row">
            <label for="language_code" class="col-sm-2 col-form-label">Language*</label>
            <div class="col-sm-10">
                <input type="text" class="form-control @error('language_code') is-invalid @enderror" id="language_code" name="language_code" placeholder="Book's language" value="{{ old('language_code') ? old('language_code') : $book->language_code }}">
                @error('language_code')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>
        </div>

        <div class="form-group row">
            <label for="pages" class="col-sm-2 col-form-label">Pages*</label>
            <div class="col-sm-10">
                <input type="number" class="form-control @error('pages') is-invalid @enderror" placeholder="Book's pages" id="pages" name="pages"  value="{{ old('pages') ? old('pages') : $book->pages }}">
                @error('pages')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>
        </div>

        <div class="form-group row">
            <label for="isbn" class="col-sm-2 col-form-label">ISBN*</label>
            <div class="col-sm-10">
                <input type="text" class="form-control @error('isbn') is-invalid @enderror" placeholder="ISBN numbers" id="isbn" name="isbn"  value="{{ old('isbn') ? old('isbn') : $book->isbn }}">
                @error('isbn')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>
        </div>

        <div class="form-group row">
            <label for="in_stock" class="col-sm-2 col-form-label">In Stock*</label>
            <div class="col-sm-10">
                <input type="number" class="form-control @error('in_stock') is-invalid @enderror" placeholder="Books in stock" id="in_stock" name="in_stock"  value="{{ old('in_stock') ? old('in_stock') : $book->in_stock }}">
                @error('in_stock')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>
        </div>

        <div class="form-group row">
            <label for="description" class="col-sm-2 col-form-label">Description</label>
            <div class="col-sm-10">
                <input type="textarea" class="form-control @error('description') is-invalid @enderror" placeholder="Book's description" id="description" name="description"  value="{{ old('description') ? old('description') : $book->description }}">
                @error('description')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>
        </div>

        <div class="form-group row">
            <label for="genres" class="col-sm-2 col-form-label">Genres</label>
            <div class="col-sm-10">
                <div class="row">
                    @forelse ($genres->chunk(5) as $chunk)
                        <div class="col-6 col-md-4 col-lg-2">
                            @foreach ($chunk as $genre)
                                <div class="form-check">
                                    <input
                                        type="checkbox"
                                        class="form-check-input"
                                        value="{{ $genre->id }}"
                                        id="genre{{ $genre->id }}"
                                        name="genres[]"
                                        @if (is_array(old('genres')) && in_array($genre->id, old('genres')))
                                            checked
                                        @else
                                            @foreach ($book->genres as $value)
                                                @if ($value->name === $genre->name)
                                                    checked
                                                @endif
                                            @endforeach
                                        @endif
                                    >
                                    <label
                                        for="genre{{ $genre->id }}"
                                        class="form-check-label"
                                    >
                                        <span class="badge badge-{{ $genre->style }}">
                                            {{ $genre->name }}
                                        </span>
                                    </label>
                                </div>
                            @endforeach
                        </div>
                    @empty
                        <p>There are no genres</p>
                    @endforelse
                </div>
            </div>
        </div>

        <div class="form-group row">
            <label class="col-sm-2 col-form-label">Cover Image</label>
            <div class="col-sm-10">
                <a type="button" data-toggle="modal" data-target="#exampleModal">
                    <img id="book-cover-preview" height="145px" src={{ asset($book->coverURL()) }}>
                </a>
                <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                      <div class="modal-content">
                        <div class="modal-header">
                          <h5 class="modal-title" id="exampleModalLabel">Image Preview</h5>
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                          </button>
                        </div>
                        <div class="modal-body">
                            <div class="container-fluid">
                                <div class="row justify-content-center">
                                    <img id="book-cover-preview" height="250px" src={{ asset($book->coverURL()) }}>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        </div>
                      </div>
                    </div>
                  </div>
            </div>
        </div>

        <div class="form-group row">
            <label for="remove_cover" class="col-sm-2 col-form-label">Remove Cover</label>
            <div class="col-sm-10">
                <div class="row">
                <div class="col-6 col-md-4 col-lg-2">
                    <div class="form-check">
                        @if ($book->hasAttachment())
                            <input type="checkbox" class="form-check-input" value="{{ True }}"  @error('remove_cover') is-invalid @enderror" id="remove_cover" name="remove_cover"
                            @if (old('remove_cover'))
                                checked
                            @endif>
                        @else
                            <input type="checkbox" class="form-check-input" value="{{ True }}" @error('remove_cover') is-invalid @enderror" id="remove_cover" name="remove_cover" disabled>
                        @endif
                        <label class="form-check-label">
                            <span>Yes</span>
                        </label>
                        @error('remove_cover')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                </div>
                </div>
            </div>
        </div>

        <div class="form-group row">
            <label for="attachment" class="col-sm-2 col-form-label">Update Cover</label>
            <div class="col-sm-10">
                <div class="form-group">
                    <input type="file" class="form-control-file @error('attachment') is-invalid @enderror" id="attachment" name="attachment">
                    @error('attachment')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
            </div>
        </div>

        <div class="text-center">
            <button type="submit" class="btn btn-primary">Update</button>
        </div>

    </form>
</div>
@endsection
