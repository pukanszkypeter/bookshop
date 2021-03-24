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
            <img class="d-block w-100" src="{{ asset("images/cover-1.jpg") }}" alt="First slide">
            <div class="carousel-caption d-none d-md-block">
                <h5>“The library is inhabited by spirits that come out of the pages at night.”</h5>
                <p>- Isabel Allende</p>
            </div>
            </div>
          </div>
          <div class="carousel-item">
            <div class="card bg-dark text-white">
            <img class="d-block w-100" src="{{ asset("images/cover-2.jpg") }}" alt="Second slide">
            <div class="carousel-caption d-none d-md-block">
                <h5>“If you don’t like to read, you haven’t found the right book.”</h5>
                <p>- J.K. Rowling</p>
            </div>
            </div>
          </div>
          <div class="carousel-item">
            <div class="card bg-dark text-white">
            <img class="d-block w-100" src="{{ asset("images/cover-3.jpg") }}" alt="Third slide">
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
                    <p class="my-1">Elérhető műveletek:</p>
                    <a href="{{ route('books.create') }}" role="button" class="btn btn-sm btn-success mb-1"><i class="fas fa-plus-circle"></i> Új könyv</a>
                    <a href="{{ route('genres.create') }}" role="button" class="btn btn-sm btn-success mb-1"><i class="fas fa-plus-circle"></i> Új műfaj</a>
                </div>
            @endauth
        </div>
    </div>

    <div class="row mt-3">
        <div class="col-12 col-lg-9">
            <div id="#books" class="row">
                @forelse ($books as $book)
                    <div class="col-12 col-md-6 col-lg-4 mb-3 d-flex align-items-strech">
                        <div class="card w-100 book">
                            <img class="card-img-top" src={{ $book->imageURL() ? $book->cover_image : asset("images/book.png") }} alt="Card image cap">
                            <div class="card-body">
                                <div class="mb-2">
                                    <h5 class="card-title mb-0 book-title">{{ $book->title }}</h5>
                                    <small class="text-secondary">
                                        <span class="mr-2">
                                            <i class="fas fa-user"></i>
                                            <span class="book-author">{{ ($book->authors ? $book->authors : 'Nincs szerző') }}</span>
                                        </span>
                                        <br>
                                        <span class="mr-2">
                                            <i class="far fa-calendar-alt"></i>
                                            <span class="book-date">{{ $book->dateFormat() }}</span>
                                        </span>
                                    </small>
                                </div>
                                <p class="card-text book-description">{{ Str::of($book->description)->limit(32) }}</p>
                            </div>
                            <div class="card-footer">
                                <a href="{{ route('books.show', $book) }}" class="btn btn-primary">Megtekint <i class="fas fa-angle-right"></i></a>
                            </div>
                        </div>
                    </div>
                @empty
                @endforelse
            </div>

            <nav aria-label="Page navigation example">
                <ul class="pagination justify-content-center">
                    <li class="page-item disabled">
                        <a class="page-link" href="#" tabindex="-1">Előző</a>
                    </li>
                    <li class="page-item"><a class="page-link" href="#">1</a></li>
                    <li class="page-item"><a class="page-link" href="#">2</a></li>
                    <li class="page-item"><a class="page-link" href="#">3</a></li>
                    <li class="page-item">
                        <a class="page-link" href="#">Következő</a>
                    </li>
                </ul>
            </nav>

        </div>
        <div class="col-12 col-lg-3">
            <div class="row">
                <div class="col-12 mb-3">
                    <div class="card bg-light">
                        <div class="card-body">
                            <h5 class="card-title mb-2">Keresés</h5>
                            <p class="small">Bejegyzés keresése cím alapján.</p>
                            <form>
                                <div class="form-group">
                                    <input type="text" class="form-control" placeholder="Keresett cím">
                                </div>
                                <button type="submit" class="btn btn-primary"><i class="fas fa-search"></i> Keresés</button>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="col-12 mb-3">
                    <div class="card bg-light">
                        <div class="card-body">
                            <h5 class="card-title mb-2">Műfajok</h5>
                            <p class="small">Bejegyzések megtekintése egy adott kategóriához.</p>
                            <a href="#" class="badge badge-primary">Primary</a>
                            <a href="#" class="badge badge-secondary">Secondary</a>
                            <a href="#" class="badge badge-success">Success</a>
                            <a href="#" class="badge badge-danger">Danger</a>
                            <a href="#" class="badge badge-warning">Warning</a>
                            <a href="#" class="badge badge-info">Info</a>
                            <a href="#" class="badge badge-light">Light</a>
                            <a href="#" class="badge badge-dark">Dark</a>
                        </div>
                    </div>
                </div>

                <div class="col-12 mb-3">
                    <div class="card bg-light">
                        <div class="card-body">
                            <h5 class="card-title mb-2">Statisztika</h5>
                            <div class="small">
                                <p class="mb-1">Adatbázis statisztika:</p>
                                <ul class="fa-ul">
                                    <li><span class="fa-li"><i class="fas fa-user"></i></span>Felhasználók: 1</li>
                                    <li><span class="fa-li"><i class="fas fa-file-alt"></i></span>Bejegyzések: 1
                                    </li>
                                    <li><span class="fa-li"><i class="fas fa-comments"></i></span>Hozzászólások: 3
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
