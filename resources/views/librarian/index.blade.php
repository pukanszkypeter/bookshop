@extends('layouts.app')
@section('title', 'My Profile')

@section('content')
<div class="container">
    <h1 class="mb-4">Profile</h1>

    <h3>{{ Auth::user()->name }} <span class="badge bg-danger text-white"> Librarian </span></h3>

    <ul class="mb-4" style="list-style-type: none">
        <li><i class="fas fa-envelope"></i> E-mail: {{ Auth::user()->email }}</li>
        <li><i class="far fa-clock"></i> Registered: {{ Auth::user()->created_at }}</li>
        <li><i class="fas fa-chart-pie"></i> Rentals accepted by you: {{ count(Auth::user()->requests()->where('status', 'ACCEPTED')->get()) }}</li>
        <li><i class="fas fa-chart-pie"></i> Rentals rejected by you: {{ count(Auth::user()->requests()->where('status', 'REJECTED')->get()) }}
        </li>
        <li><i class="fas fa-chart-pie"></i> Rentals returned by you: {{ count(Auth::user()->returns()->where('status', 'RETURNED')->get()) }}
        </li>
    </ul>

    <a type="button" class="btn btn-primary btn-sm" href="{{ route('librarian.borrows.index.pending') }}"><i class="fas fa-edit"></i> Rental managment</a>
</div>
@endsection
