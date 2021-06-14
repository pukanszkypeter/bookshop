@extends('reader.borrows.index')
@section('title', 'My Rentals - Accepted')

@section('rentals')
    <h3 class="mt-3">Accepted Rentals</h3>

    <div class="alert alert-success" role="alert">
        These rentals were accepted.
    </div>

    <?php $accepted = Auth::user()->getBorrowsByStatus('ACCEPTED') ?>

    <ol class="list-group list-group-numbered">

    @if($accepted->count() > 0)
    @for($i = 0; $i < $accepted->count(); $i++)
    <li class="list-group-item d-flex justify-content-between align-items-start">
        <div class="ms-2 me-auto">
          <h5>#{{$i + 1}}</h5>
          Book: <b>{{ $accepted[$i]->book()->get()->first()->title }}</b>
        </div>
        <div style="margin-right: 1rem">
            <div class="row mb-1"><span class="small">Submitted: {{ $accepted[$i]->created_at }}</span></div>
            <div class="row justify-content-end"><a type="button" class="btn btn-primary btn-sm" href="{{ route('reader.borrows.show', $accepted[$i]->id) }}">Details</a></div>
        </div>
    </li>
    @endfor
    @else
        You don't have any accepted rentals yet.
    @endif
    </ol>
@endsection
