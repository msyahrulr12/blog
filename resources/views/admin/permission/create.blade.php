@extends('layouts.admin.app')
@section('title', 'Tambah '.$title)
@section('content')

<div class="card">
    <div class="card-body">
        <form action="{{ route($route.'store') }}" method="post">
            @include($view.'field')
        </form>
    </div>
</div>

@endsection