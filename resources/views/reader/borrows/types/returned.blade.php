@extends('reader.borrows.index')
@section('title', 'My Rentals - Returned')

@section('rentals')
    <h3 class="mt-3">Returned Rentals</h3>

    <div class="alert alert-info" role="alert">
        These rentals were returned.
    </div>

    <?php $returned = Auth::user()->getBorrowsByStatus('RETURNED') ?>

    <ol class="list-group list-group-numbered">

    @if($returned->count() > 0)
    @for($i = 0; $i < $returned->count(); $i++)
    <li class="list-group-item d-flex justify-content-between align-items-start">
        <div class="ms-2 me-auto">
          <h5>#{{$i + 1}}</h5>
          Book: <b>{{ $returned[$i]->book()->get()->first()->title }}</b>
        </div>
        <div style="margin-right: 1rem">
            <div class="row mb-1"><span class="small">Submitted: {{ $returned[$i]->created_at }}</span></div>
            <div class="row justify-content-end"><a type="button" class="btn btn-primary btn-sm" href="{{ route('reader.borrows.show', $returned[$i]->id) }}">Details</a></div>
        </div>
    </li>
    @endfor
    @else
        You don't have any returned rentals yet.
    @endif
    </ol>
@endsection
