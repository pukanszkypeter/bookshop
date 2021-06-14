@extends('layouts.app')
@section('title', 'Borrow' . $borrow->id)

@section('content')
<div class="container">
    <h1>Manage rental</h1>

    <div class="mb-4">
        <a href="javascript:history.back()" class="btn btn-primary btn-sm"><i class="fas fa-long-arrow-alt-left"></i> Back to Rental managment</a>
    </div>

    @if (Session::has('borrow-updated'))
        <div class="alert alert-success" role="alert">
            The borrow was successfully updated!
        </div>
    @endif

    @if (Session::has('borrow-updated-wrong'))
        <div class="alert alert-danger" role="alert">
            The borrow could not be updated! Status was not given!
        </div>
    @endif

    <div class="row border-top" style="border-top-color: #e7c072 !important">

        <div class="col-3 border-right p-3" style="border-right-color: #e7c072 !important">
            <h4><b>Book</b></h4>
            <div class="p-2">
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

        <div class="col-6 p-3">
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

            <div class="mt-3 ml-2">
                @if ($book->getAvaliableCount() > 0 )
                    <span style="color: green"><b>This book is currently available in stock.</b></span>
                @else
                    <span style="color: red"><b>This book is currently out of stock.</b></span>
                @endif
            </div>

            <?php $delayedBorrows = $reader->getDelayedBorrows() ?>
            <?php $delayedBorrowsFromPast = $reader->getDelayedBorrowsFromPast() ?>

            @if (count($delayedBorrows) > 0 || count($delayedBorrowsFromPast) > 0)
            <div class="alert alert-warning mt-3" role="alert">
                <b>Attention!</b> Delays can be attributed to the reader submitting the claim!

                <ul class="mt-2">
                    @if (count($delayedBorrows) > 0)
                        <li>Current delays:
                            @foreach ($delayedBorrows as $delayedBorrow)
                                <span> <a href="{{ route('librarian.borrows.edit', $delayedBorrow->id) }}" target="blank_"> #{{ $delayedBorrow->id }} </a> </span>
                            @endforeach
                        </li>
                    @endif
                    @if (count($delayedBorrowsFromPast) > 0)
                        <li>Past delays:
                            @foreach ($delayedBorrowsFromPast as $delayedBorrowFromPast)
                                <span> <a href="{{ route('librarian.borrows.edit', $delayedBorrowFromPast->id) }}" target="blank_"> #{{ $delayedBorrowFromPast->id }} </a> </span>
                            @endforeach
                        </li>
                    @endif
                </ul>

            </div>
            @endif

        </div>

        <div class="col-3 border-left p-3" style="border-left-color: #e7c072 !important">
            <h4><b>Manage</b></h4>

            <form action="{{ route('librarian.borrows.update') }}" method="POST" enctype="multipart/form-data">
                @method('POST')
                @csrf

                <input type="hidden" id="id" name="id" value={{ $borrow->id }}>
                <input type="hidden" id="librarian" name="librarian" value={{ Auth::user()->id }}>

                <div class="form-group mb-2">
                    <label for="status" class="col-from-label">Change status:</label>
                    <div>
                        <input type="radio" name="status" id="rejected" value="REJECTED" @if ($borrow->status == 'REJECTED')
                            checked
                        @endif>
                        <label for="status" style="margin-bottom: 0.1rem">
                            <span style="color: red">Rejected <i class="fas fa-times"></i></span>
                        </label>
                        <br>

                        <input type="radio" name="status" id="accepted" value="ACCEPTED" @if ($borrow->status == 'ACCEPTED')
                        checked
                        @endif>
                        <label for="status" style="margin-bottom: 0.1rem">
                            <span style="color: green">Accepted <i class="fas fa-check"></i></span>
                        </label>
                        <br>

                        <input type="radio" name="status" id="returned" value="RETURNED" @if ($borrow->status == 'RETURNED')
                        checked
                        @endif>
                        <label for="status" style="margin-bottom: 0.1rem">
                            <span style="color: blue">Returned <i class="fas fa-undo"></i></span>
                        </label>
                        <br>
                    </div>
                </div>


                <div class="form-group mb-2">
                    <label for="deadline" class="col-form-label">Deadline:</label>
                    <div>
                        <input type="date" class="form-control @error('deadline') is-invalid @enderror" id="deadline" name="deadline" value="{{ $borrow->deadline ? str_replace(".","-",$borrow->deadline) : '' }}">
                        @error('deadline')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>

                <div class="form-group mt-4">
                    <label for="request_processed_message" class="form-label">Note for managment:</label>
                    <textarea class="form-control @error('request_processed_message') is-invalid @enderror" id="request_processed_message" name="request_processed_message" rows="3">{{ $borrow->request_processed_message ? $borrow->request_processed_message : null}}</textarea>
                    @error('request_processed_message')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                    <p class="small">If you have any notes for the reader, you can write them here. (max. 255 characters)</p>
                </div>


                <div class="text-left">
                    <button type="submit" class="btn btn-primary btn-sm">Update</button>
                    <a type="button" href="javascript:history.back()" class="btn btn-danger btn-sm">Close</a>
                </div>

            </form>
        </div>

    </div>


</div>
@endsection
