@extends('layouts.app')
@section('title', $genre->name)

@section('content')
<div class="container">
    <div class="row justify-content-between">

        <div class="col-12 col-md-8">
            <h1 id="genre"><span>{{ $genre->name }}</span></h1>

            <div class="mb-3">
                <a href="{{ route('books.index') }}" class="btn btn-primary btn-sm"><i class="fas fa-long-arrow-alt-left"></i> All Books</a>
            </div>
            <br>
            <h3>Genre details</h3>
            <ul class="list-group list-group-flush">
                <li class="list-group-item" style="background-color: #f8fafc"><i class="fas fa-signature"></i><b> Name: </b>{{ $genre->name }} </li>
                <li class="list-group-item" style="background-color: #f8fafc"><i class="fas fa-th-list"></i><b> Style:</b> <span class="badge badge-{{ $genre->style }}">{{ $genre->style }}</span></li>
            </ul>
            <br>
            <h3>Books in <span class="badge badge-{{ $genre->style }}">{{ $genre->name }}</span> genre</h3>
            <p>Coming soon...</p>
        </div>

        @auth
        <div id="genre-actions" class="col-12 col-md-4">
            <div class="py-md-3 text-md-right">
                <p class="my-1">Genre managment:</p>
                <form action="{{ url('genres', $genre->id) }}" method="POST">
                    <a id="edit-genre-btn" href="{{ route('genres.edit', $genre) }}" role="button" class="btn btn-sm btn-primary"><i class="far fa-edit"></i> Modify</a>
                    @csrf
                    {{ method_field('DELETE') }}
                    <button id="delete-genre-btn" type="submit" class="btn btn-sm btn-danger"><i class="far fa-trash-alt"></i> Delete</button>
                </form>
            </div>
        </div>
        @endauth

        <div class="row mt-3">
            <div class="col-12 col-lg-9">
                <div id="books" class="row">
                    @forelse ($books as $book)
                        <div class="col-12 col-md-6 col-lg-4 mb-3 d-flex align-items-strech">
                            <div class="card w-100 book" @if ($book->getAvaliableCount() <= 0)
                                style="background-color: rgb(255, 0, 0,0.4)"
                            @endif>
                                @if ($book->getAvaliableCount() <= 0)
                                    <img class="card-img-top" height="145px" src={{ asset('images/book_covers/sold-out.png') }} alt="Card image cap">
                                @else
                                    <img class="card-img-top" height="145px" src={{ $book->hasAttachment() ? asset('images/book_covers/' . $book->attachment_hash_name) : asset('images/book_covers/' . $book->cover_image) }} alt="Card image cap">
                                @endif
                                <div class="card-body">
                                    <div class="mb-2">
                                        <h5 class="card-title mb-0 book-title">{{ $book->title }}</h5>
                                        <small class="text-secondary">
                                            <span class="mr-2">
                                                <i class="fas fa-user"></i>
                                                <span class="book-author"> {{ ($book->authors ? $book->authors : 'No authors') }}</span>
                                            </span>
                                            <br>
                                            <span class="mr-2">
                                                <i class="far fa-calendar-alt"></i>
                                                <span class="book-date"> {{ $book->dateFormat() }}</span>
                                            </span>
                                        </small>
                                    </div>
                                    <p class="card-text book-description">{{ Str::of($book->description)->limit(32) }}</p>
                                </div>
                            <div class="card-footer">
                            <a href="{{ route('books.show', $book) }}" class="btn btn-primary book-details">View <i class="fas fa-angle-right"></i></a>
                        </div>
                </div>
            </div>
                @empty
                @endforelse
        </div>

    </div>
</div>
@endsection
