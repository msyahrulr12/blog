@extends('layouts.admin.app')
@section('title', 'Edit '.$title)
@section('content')

<div class="card">
    <div class="card-body">
        <form action="{{ route($route.'update', $data->id) }}" method="post">
            @method('PUT')
            @include($view.'field')
        </form>
    </div>
</div>

@endsection