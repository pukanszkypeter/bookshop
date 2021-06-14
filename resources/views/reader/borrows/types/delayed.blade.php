@extends('reader.borrows.index')
@section('title', 'My Rentals - Delayed')

@section('rentals')
    <h3 class="mt-3">Delayed Rentals</h3>

    <div class="alert alert-danger" role="alert">
        These rentals are overdue.
    </div>

    <?php $delayed = Auth::user()->getDelayedBorrows() ?>

    <ol class="list-group list-group-numbered">

    @if(count($delayed) > 0)
    @for($i = 0; $i < count($delayed); $i++)
    <li class="list-group-item d-flex justify-content-between align-items-start">
        <div class="ms-2 me-auto">
          <h5>#{{$i + 1}}</h5>
          Book: <b>{{ $delayed[$i]->book()->get()->first()->title }}</b>
        </div>
        <div style="margin-right: 1rem">
            <div class="row mb-1"><span class="small">Submitted: {{ $delayed[$i]->created_at }}</span></div>
            <div class="row justify-content-end"><a type="button" class="btn btn-primary btn-sm" href="{{ route('reader.borrows.show', $delayed[$i]->id) }}">Details</a></div>
        </div>
    </li>
    @endfor
    @else
        You don't have any delayed rentals yet.
    @endif
    </ol>
@endsection
