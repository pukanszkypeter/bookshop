@extends('layouts.app')
@section('title', 'Borrow' . $borrow->id)

@section('content')
<div class="container">
    <h1>Rental details</h1>

    <div class="mb-4">
        <a href="javascript:history.back()" class="btn btn-primary btn-sm"><i class="fas fa-long-arrow-alt-left"></i> Back to My Rentals</a>
    </div>

    <div class="row border-top" style="border-top-color: #e7c072 !important">

        <div class="col-4 border-right p-3" style="border-right-color: #e7c072 !important">
            <h4><b>Book</b></h4>
            <div class="p-3">
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
        </div>

        <div class="col-8 p-3">
            <h4><b>Details</b></h4>
            <ul style="list-style-type: none">
                <li>
                    <h5>Basic rental information</h5>
                    <ul style="list-style-type: none">
                        <li><i class="fas fa-user"></i> Reader: {{ $reader->name }}</li>
                        <li><i class="fas fa-book"></i> Book: <a href="{{ route('books.show', $book) }}" target="_blank">{{ $book->title }}</a></li>
                        <li><i class="far fa-clock"></i> Rental requested at this time: {{ $borrow->created_at }}</li>
                        <li><i class="far fa-comment"></i> Reader's note:
                            @if ($borrow->reader_message)
                                {{ $borrow->reader_message }}
                            @else
                                There are no comments for this rental.
                            @endif
                        </li>
                        <li><i class="fas fa-chart-pie"></i> Condition:
                            @if ($borrow->status == 'ACCEPTED')
                                <span style="color: green">{{ ucfirst(strtolower($borrow->status)) }}</span>
                            @elseif($borrow->status == 'REJECTED')
                                <span style="color: red">{{ ucfirst(strtolower($borrow->status)) }}</span>
                            @elseif($borrow->status == 'PENDING')
                                <span style="color: yellowgreen">{{ ucfirst(strtolower($borrow->status)) }}</span>
                            @else
                                <span style="color: blue">{{ ucfirst(strtolower($borrow->status)) }}</span>
                            @endif
                        </li>
                    </ul>
                </li>
                <li>
                    <h5>Rental processing</h5>
                    <ul style="list-style-type: none">
                        @if ($borrow->request_managed_by)
                            <li><i class="far fa-clock"></i> Processed at: {{ $borrow->request_processed_at }}</li>
                            <li><i class="fas fa-user"></i> Processed by: {{ $request_librarian->name }}</li>
                            <li><i class="far fa-comment"></i> Librarian's note:
                                @if ( $borrow->request_processed_message)
                                    {{ $borrow->request_processed_message }}
                                @else
                                    There are no comments for the request processing.
                                @endif
                            </li>
                            <li><i class="far fa-clock"></i> Deadline:
                                @if ( $borrow->deadline )
                                    {{ $borrow->deadline }}
                                    @if ($borrow->deadline < date('Y.m.d') )
                                        (<span style="color: red">delay</span>)
                                    @endif
                                @else
                                    Not specified.
                                @endif
                            </li>
                        @else
                            <li>No processing information.</li>
                        @endif
                    </ul>
                </li>
                <li>
                    <h5>Return</h5>
                    <ul style="list-style-type: none">
                        @if ($borrow->return_managed_by)
                            <li><i class="far fa-clock"></i> Returned at: {{ $borrow->returned_at }}</li>
                            <li><i class="fas fa-user"></i> Processed by: {{ $return_librarian->name }}</li>
                        @else
                            <li>No return information.</li>
                        @endif
                    </ul>
                </li>
            </ul>
        </div>

    </div>

</div>
@endsection
