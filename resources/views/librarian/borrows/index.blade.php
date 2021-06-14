@extends('layouts.app')
@section('title', 'Rental Managment')

@section('content')
<div class="container">
    <h1>Rental managment</h1>
    <p>On this page you can manage the rentals.</p>

    <div class="mb-4">
        <a href="{{ route('books.index') }}" class="btn btn-primary btn-sm"><i class="fas fa-long-arrow-alt-left"></i> All Books</a>
    </div>

    <ul class="nav nav-tabs">
        <li class="nav-item">
          <a id="rentals-pending" class="nav-link" href="{{ route('librarian.borrows.index.pending') }}"><i class="fas fa-hourglass-start" style="color: grey"></i> Pending</a>
        </li>
        <li class="nav-item">
          <a id="rentals-rejected" class="nav-link" href="{{ route('librarian.borrows.index.rejected') }}"><i class="fas fa-times" style="color: red"></i> Rejected</a>
        </li>
        <li class="nav-item">
          <a id="rentals-accepted" class="nav-link" href="{{ route('librarian.borrows.index.accepted') }}"><i class="fas fa-check" style="color: green"></i> Accepted</a>
        </li>
        <li class="nav-item">
          <a id="rentals-returned" class="nav-link" href="{{ route('librarian.borrows.index.returned') }}" ><i class="fas fa-undo-alt" style="color: blue"></i> Returned</a>
        </li>
        <li class="nav-item">
            <a id="rentals-delay" class="nav-link" href="{{ route('librarian.borrows.index.delay') }}" ><i class="fas fa-hourglass-end" style="color: orange"></i> Delay</a>
        </li>
    </ul>

    @yield('rentals')

</div>
@endsection
