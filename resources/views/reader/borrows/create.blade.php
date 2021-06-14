@extends('layouts.app')
@section('title', 'Loan book: ' . $book->title)

@section('content')
<div class="container">
    <h1>Loan</h1>

    <div class="mb-4">
        <a href="{{ route('books.show', $book) }}" class="btn btn-primary btn-sm"><i class="fas fa-long-arrow-alt-left"></i> Back to the Book</a>
    </div>

    <div class="row">

        <div class="col-4 p-3">
            <div class="card w-100 book" @if ($book->getAvaliableCount() <= 0) style="background-color: rgb(255, 0, 0,0.4)" @endif>
                @if ($book->getAvaliableCount() <= 0)
                    <img class="card-img-top" height="145px" src={{ asset('images/book_covers/sold-out.png') }} alt="Card image cap">
                @else
                    <img class="card-img-top" height="145px" src={{ asset($book->coverURL()) }} alt="Card image cap">
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

        <div class="col-8 p-3">
            @if(Auth::user()->isAlreadyBorrowed($book))
                <div class="alert alert-danger" role="alert">
                    <b>Attention </b> <i class="fas fa-exclamation-triangle"></i>
                    <p>You cannot submit additional loan requests for this book, as you have already submitted one according to the records / the book is with you.</p>
                </div>
                <div class="mt-3">
                    <a href="{{ route('books.index') }}" class="btn btn-secondary">Back</a>
                </div>
            @elseif($book->getAvaliableCount() <= 0)
                <div class="alert alert-warning" role="alert">
                    <b>Attention </b> <i class="fas fa-exclamation-triangle"></i>
                    <p>You can apply for a loan for this book, but it may take longer to accept the request, as all copies are currently out of stock.</p>
                </div>
                <h4>Stock information</h4>
                <p class="text-danger"><b>This book is currently out of stock!</b></p>
                <h4>Loan</h4>
                <p>Here you can submit your loan application.</p>
                <form action="{{ route('reader.borrows.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <p>Note for rent:</p>
                        <input type="textarea" class="form-control @error('description') is-invalid @enderror" placeholder="If you have any comments about the rental, you can write it here! (Max. 255 characters)" id="description" name="description">
                        @error('description')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="text-right">
                        <button type="submit" class="btn btn-success">Submit</button>
                        <a href="{{ route('books.index') }}" class="btn btn-danger">Close</a>
                    </div>
                </form>
            @else
                <div class="alert alert-primary" role="alert">
                    <b>Attention <i class="fas fa-exclamation-triangle"></i></b>
                    <p>You can submit your rental request on this page. This only creates a demand that librarians have yet to approve.</p>
                </div>
                <h4>Stock information</h4>
                <p class="text-success"><b>This book is currently available in the library stock!</b></p>
                <h4>Loan</h4>
                <p>Here you can submit your loan application.</p>
                <form action="{{ route('reader.borrows.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <p>Note for rent:</p>
                        <input type="hidden" id="bookID" name="bookID" value="{{ $book->id }}">
                        <input type="hidden" id="userID" name="userID" value="{{ Auth::user()->id }}">
                        <input type="textarea" class="form-control @error('description') is-invalid @enderror" placeholder="If you have any comments about the rental, you can write it here! (Max. 255 characters)" id="description" name="description">
                        @error('description')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="text-right">
                        <button type="submit" class="btn btn-success">Submit</button>
                        <a href="{{ route('books.index') }}" class="btn btn-danger">Close</a>
                    </div>
                </form>
            @endif
        </div>
    </div>

</div>
@endsection
