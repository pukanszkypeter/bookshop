@extends('layouts.app')
@section('title', $book->title)

@section('content')
<div class="container">
    <div class="row justify-content-between">
        <div class="col-12 col-md-8">
            <h1 id="book-title">{{ $book->title }}</h1>

            <div id="book-categories" class="mb-2">
                @foreach($book->genres as $genre)
                    <a href="#" class="badge badge-{{ $genre->style }}">{{ $genre->name }}</a>
                @endforeach
            </div>

            <div class="mb-3">
                <a id="all-books-ref" href="{{ route('books.index') }}" class="btn btn-primary btn-sm"><i class="fas fa-long-arrow-alt-left"></i> All Books</a>
            </div>
            <br>
            <h3>Book details</h3>
            <ul class="list-group list-group-flush">
                <li id="book-authors" class="list-group-item" style="background-color: #f8fafc"><i class="fas fa-user"></i><b> Authors: </b>{{ ($book->authors ? $book->authors : 'No authors') }} </li>
                <li id="book-date" class="list-group-item" style="background-color: #f8fafc"><i class="far fa-calendar-alt"></i><b> Release date:</b> {{ $book->dateFormat() }}</li>
                <li id="book-pages" class="list-group-item" style="background-color: #f8fafc"><i class="fas fa-book-open"></i><b> Pages:</b> {{ $book->pages }}</li>
                <li id="book-lang" class="list-group-item" style="background-color: #f8fafc"><i class="fas fa-globe"></i><b> Language:</b> {{ $book->language_code }}</li>
                <li id="book-isbn" class="list-group-item" style="background-color: #f8fafc"><i class="fas fa-book"></i><b> ISBN:</b> {{ $book->isbn }}</li>
                <li id="book-in-stock" class="list-group-item" style="background-color: #f8fafc"><i class="fas fa-sign-in-alt"></i><b> In stock:</b> {{ $book->getAvaliableCount() }} pieces</li>
                <li id="book-borrowed" class="list-group-item" style="background-color: #f8fafc"><i class="fas fa-sign-out-alt"></i><b> Out stock:</b> {{ $book->getAcceptedBorrowsCount() }} pieces</li>
            </ul>
            <br>
            <h3>Book description</h3>
            <p id="book-description">{{ $book->description }}</p>

            <br>
            <h3>Book cover image</h3>
            <a type="button" data-toggle="modal" data-target="#exampleModal">
                <img height="145px" src={{ $book->hasAttachment() ? asset('images/book_covers/' . $book->attachment_hash_name) : asset('images/book_covers/' . $book->cover_image) }}>
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
                                <img id="book-cover-preview" height="250px" src={{ $book->hasAttachment() ? asset('images/book_covers/' . $book->attachment_hash_name) : asset('images/book_covers/' . $book->cover_image) }}>
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
        @auth
        <div id="book-actions" class="col-12 col-md-4">
            <div class="py-md-3 text-md-right">
                <p class="my-1">Book managment:</p>
                <form action="{{ url('books', $book->id) }}" method="POST">
                    <a id="edit-book-btn" href="{{ route('books.edit', $book) }}" role="button" class="btn btn-sm btn-primary"><i class="far fa-edit"></i> Modify</a>
                    @csrf
                    {{ method_field('DELETE') }}
                    <button id="delete-book-btn" type="submit" class="btn btn-sm btn-danger"><i class="far fa-trash-alt"></i> Delete</button>
                </form>
            </div>
        </div>
        @endauth
    </div>


</div>
@endsection
