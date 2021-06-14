@extends('librarian.borrows.index')
@section('title', 'Rental managment - Delay')

@section('rentals')
    <h3 class="mt-3">Delayed Rentals</h3>

    <div class="alert alert-primary" role="alert">
        These rentals are overdue.
    </div>

    <ol class="list-group list-group-numbered">

    @if($delayed->count() > 0)
    @for($i = 0; $i < $delayed->count(); $i++)
    <li class="list-group-item d-flex justify-content-between align-items-start">
        <div class="ms-2 me-auto">
          <h5>#{{$i + 1}}</h5>
          Book: <b>{{ $delayed[$i]->book()->get()->first()->title }}</b>
        </div>
        <div style="margin-right: 1rem">
            <div class="row mb-1"><span class="small">Submitted: {{ $delayed[$i]->created_at }}</span></div>
            <div class="row justify-content-end"><a type="button" class="btn btn-primary btn-sm" href="{{ route('librarian.borrows.edit', $delayed[$i]->id) }}">Manage</a></div>
        </div>
    </li>
    @endfor
    @else
        There aren't any delayed rentals.
    @endif
    </ol>

@endsection
