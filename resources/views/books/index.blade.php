@extends('layouts.app')
@section('title', 'Könyvek')

@section('content')
<div class="container">
    <div class="row justify-content-between">
        <div class="col-12 col-md-8">
            <h1>Welcome to <b>My Bookshop!</b></h1>
        </div>
    </div>
    <br>
    <div id="carouselExampleSlidesOnly" class="carousel slide" data-ride="carousel">
        <div class="carousel-inner">
          <div class="carousel-item active">
            <div class="card bg-dark text-white">
            <img class="d-block w-100" src="{{ asset("images/banner-1.jpg") }}" alt="First slide">
            <div class="carousel-caption d-none d-md-block">
                <h5>“The library is inhabited by spirits that come out of the pages at night.”</h5>
                <p>- Isabel Allende</p>
            </div>
            </div>
          </div>
          <div class="carousel-item">
            <div class="card bg-dark text-white">
            <img class="d-block w-100" src="{{ asset("images/banner-2.jpg") }}" alt="Second slide">
            <div class="carousel-caption d-none d-md-block">
                <h5>“If you don’t like to read, you haven’t found the right book.”</h5>
                <p>- J.K. Rowling</p>
            </div>
            </div>
          </div>
          <div class="carousel-item">
            <div class="card bg-dark text-white">
            <img class="d-block w-100" src="{{ asset("images/banner-3.jpg") }}" alt="Third slide">
            <div class="carousel-caption d-none d-md-block">
                <h5>“That’s the thing about books. They let you travel without moving your feet.”</h5>
                <p>- Jhumpa Lahiri</p>
            </div>
            </div>
          </div>
        </div>
    </div>
    <br>
    <div class="row justify-content-between">
        <div class="col-12 col-md-8">
            <h3 class="mb-1">All Books</h3>
        </div>
        <div class="col-12 col-md-4">
            @auth
                <div class="py-md-3 text-md-right">
                    <p class="my-1">Available options:</p>
                    <a id="create-book-btn" href="{{ route('books.create') }}" role="button" class="btn btn-sm btn-primary mb-1"><i class="fas fa-plus-circle"></i> New book</a>
                    <a id="create-genre-btn" href="{{ route('genres.create') }}" role="button" class="btn btn-sm btn-primary mb-1"><i class="fas fa-plus-circle"></i> New genre</a>
                </div>
            @endauth
        </div>
    </div>

    <div class="row mt-3">
        <div class="col-12 col-lg-9">
        @if (Session::has('book-deleted'))
        <div id="book-deleted" class="alert alert-danger" role="alert">
            The book called <span id="book-name"><strong>{{ Session::get('book-deleted') }}</strong></span> has been successfully deleted!
        </div>
        @endif
        @if (Session::has('book-delete-failed'))
        <div id="book-delete-failed" class="alert alert-warning" role="alert">
            This book has <strong>{{ Session::get('book-delete-failed') }}</strong> borrow. Please handle them before deleting!
        </div>
        @endif
        @if (Session::has('genre-deleted'))
        <div id="genre-deleted" class="alert alert-danger" role="alert">
            The genre called <strong><span id="genre-name">{{ Session::get('genre-deleted') }}</span></strong> has been successfully deleted!
        </div>
        @endif
            <div id="books" class="row">
                @forelse ($books as $book)
                    <div class="col-12 col-md-6 col-lg-4 mb-3 d-flex align-items-strech">
                        <div class="card w-100 book" @if ($book->getAvaliableCount() <= 0)
                            style="background-color: rgb(255, 0, 0,0.4)"
                        @endif>
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
                @empty
                @endforelse
            </div>

            <nav aria-label="Page navigation example">
                <ul class="pagination justify-content-center">
                    {{ $books->links() }}
                </ul>
            </nav>

        </div>
        <div class="col-12 col-lg-3">
            <div class="row">
                <div class="col-12 mb-3">
                    <div class="card bg-light">
                        <div class="card-body">
                            <h5 class="card-title mb-2">Search</h5>
                            <p class="small">Search for a book by title.</p>
                            <form>
                                <div class="form-group">
                                    <input type="text" class="form-control" placeholder="Searched title">
                                </div>
                                <button type="submit" class="btn btn-primary"><i class="fas fa-search"></i> Search</button>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="col-12 mb-3">
                    <div class="card bg-light">
                        <div class="card-body genres-list">
                            <h5 class="card-title mb-2">Genres</h5>
                            <p class="small">View books for a specific genre.</p>
                            @forelse ($genres as $genre)
                            <a href="{{ route('genres.show', $genre) }}" class="badge badge-{{ $genre->style }}">{{ $genre->name }}</a>
                            @empty
                            @endforelse
                        </div>
                    </div>
                </div>

                <div class="col-12 mb-3">
                    <div class="card bg-light">
                        <div class="card-body">
                            <h5 class="card-title mb-2">Statistics </h5>
                            <div class="small">
                                <p class="mb-1">Database statistics:</p>
                                <ul class="fa-ul">
                                    <li><span class="fa-li"><i class="fas fa-user"></i></span>Users: <span id="stats-users">{{ $usersCount }}</span></li>
                                    <li><span class="fa-li"><i class="fas fa-book"></i></span>Books: <span id="stats-books">{{ $booksCount }}</span>
                                    </li>
                                    <li><span class="fa-li"><i class="fas fa-th-list"></i></span>Genres: <span id="stats-genres">{{ $genresCount }}</span>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection
