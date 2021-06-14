@extends('layouts.app')
@section('title', 'My Rentals')

@section('content')
<div class="container">
    <h1>My Rentals</h1>
    <p>On this page you can see the status of your rentals.</p>

    <div class="mb-4">
        <a href="{{ route('books.index') }}" class="btn btn-primary btn-sm"><i class="fas fa-long-arrow-alt-left"></i> All Books</a>
    </div>

    <?php $delayedBorrows = count(Auth::user()->getDelayedBorrows()) ?>
    @if($delayedBorrows > 0)
    <div class="alert alert-danger" role="alert">
        <b>Attention!</b> You currently have <b>{{ $delayedBorrows }}</b> rentals that have expired but you have not returned.
    </div>
    @endif

    <ul class="nav nav-tabs">
        <li class="nav-item">
          <a id="rentals-pending" class="nav-link" href="{{ route('reader.borrows.index.pending') }}"><i class="fas fa-hourglass-start" style="color: grey"></i> Pending</a>
        </li>
        <li class="nav-item">
          <a id="rentals-rejected" class="nav-link" href="{{ route('reader.borrows.index.rejected') }}"><i class="fas fa-times" style="color: red"></i> Rejected</a>
        </li>
        <li class="nav-item">
          <a id="rentals-accepted" class="nav-link" href="{{ route('reader.borrows.index.accepted') }}"><i class="fas fa-check" style="color: green"></i> Accepted</a>
        </li>
        <li class="nav-item">
          <a id="rentals-returned" class="nav-link" href="{{ route('reader.borrows.index.returned') }}" ><i class="fas fa-undo-alt" style="color: blue"></i> Returned</a>
        </li>
        <li class="nav-item">
            <a id="rentals-delay" class="nav-link" href="{{ route('reader.borrows.index.delay') }}" >
                <i class="fas fa-hourglass-end" style="color: orange"></i>
                Delay
                @if($delayedBorrows > 0) <span style="color: red;font-weight: bold">{{ $delayedBorrows }}</span> @endif
            </a>
        </li>
    </ul>

    @yield('rentals')

</div>
@endsection
