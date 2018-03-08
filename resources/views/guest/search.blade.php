@extends('layouts.app')

@section('content')
<div class="card">
    <div class="card-header">Search "{{ $query }}"</div>

    <div class="card-body">

        @include('guest.partials.blogs-loop-box')

        <div class="row">
            <div class="col-md-12">
                {{ $blogs->appends(['q' => $query])->links() }}
            </div>
        </div>

    </div>
</div>
@endsection