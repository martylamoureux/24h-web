@extends('app')

@section('content')

    <div class="panel panel-danger">
        <div class="panel-heading">Erreur <b>{{ $code }}</b></div>
        <div class="panel-body">
            {{ $message }}
        </div>
    </div>

@endsection
