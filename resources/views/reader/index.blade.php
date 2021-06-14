@extends('layouts.app')
@section('title', 'My Profile')

@section('content')
<div class="container">
    <h1 class="mb-4">Profile</h1>

    <h3>{{ Auth::user()->name }} <span class="badge bg-success text-white"> Reader </span></h3>

    <ul class="mb-4" style="list-style-type: none">
        <li><i class="fas fa-envelope"></i> E-mail: {{ Auth::user()->email }}</li>
        <li><i class="far fa-clock"></i> Registered: {{ Auth::user()->created_at }}</li>
        <li><i class="fas fa-chart-pie"></i> Total rentals: {{ count(Auth::user()->borrows()->get()) }}</li>
        <li><i class="fas fa-chart-pie"></i> Books by you: {{ count(Auth::user()->getBorrowsByStatus('ACCEPTED')) }}
            @if (count(Auth::user()->getDelayedBorrows()) > 0)
                (<span style="color: red">{{ count(Auth::user()->getDelayedBorrows()) }} delay</span>)
            @endif
        </li>
    </ul>

    <a type="button" class="btn btn-success btn-sm" href="{{ route('reader.borrows.index.pending') }}"><i class="fas fa-edit"></i> My rentals</a>
</div>
@endsection
