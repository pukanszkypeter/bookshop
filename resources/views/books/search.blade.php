@extends('layouts.app')
@section('title', 'Search Page')

@section('content')
<div class="container">
    <div class="row justify-content-between">
        <div class="col-12 col-md-8">
            <h1>Search Page</h1>
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
            <h3 class="mb-1">Search results for the given word: <span class="badge rounded-pill bg-primary text-white">{{$search}}</h3>
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
            <div id="books" class="row">
                @if (count($books) > 0)
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
                @else
                    <div class="p-3" style="margin-top: -1rem">
                        <div class="alert alert-danger" role="alert">
                            No matching books were found for the specified keyword.
                        </div>
                    </div>
                @endif
            </div>
        </div>

        <div class="col-12 col-lg-3">
            <div class="row">
                <div class="col-12 mb-3">
                    <div class="card bg-light">
                        <div class="card-body">
                            <h5 class="card-title mb-2">Search</h5>
                            <p class="small">Search for a book by title.</p>
                            <form action="{{ route('books.search') }}" method="GET">
                                <div class="form-group">
                                    <input type="text" class="form-control @error('search') is-invalid @enderror" name="search" class="form-control" placeholder="Searched title">
                                    @error('search')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                                <button type="submit" class="btn btn-primary"><i class="fas fa-search"></i> Search</button>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="col-12 mb-3 genres-list">
                    <div class="card bg-light">
                        <div class="card-body">
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
