@extends('app')

@section('content')

    <div class="jumbotron">
        <h2>Bienvenue sur le site de gestion portuaire du Havre !</h2>

        <p>Ce site va vous permettre de gérer les navires qui arrivent sur le Havre, les escales qui sont effectuées,
            la gestion des conteneurs sur les bateaux, la gestion des compagnies ...
        </p>

        <p><a class="btn btn-primary btn-lg" href="http://fr.wikipedia.org/wiki/Le_Havre" role="button">En
                apprendre plus sur le Havre</a></p>
    </div>

    <div class="row">
        @if(Auth::check())
            @if(Auth::user()->type == 'AG')
                <div class="col-md-6">
                    <a class="btn btn-block btn-success" href="{{ route('clients.add') }}">Ajouter un client</a>
                </div>
                <div class="col-md-6">
                    <a class="btn btn-block btn-success" href="{{ route('companies.add') }}">Ajouter une compagnie</a>
                </div>
            @elseif (Auth::user()->type == 'CO')
                <div class="col-md-12">
                    <a class="btn btn-block btn-success" href="{{ route('companies.detail', Auth::user()->company)
                    }}">Mes données</a>
                </div>
            @elseif (Auth::user()->type == 'CL')
                <div class="col-md-12">
                    <a class="btn btn-block btn-success" href="{{ route('clients.detail', Auth::user()->client) }}">Mes
                        données</a>
                </div>
            @endif
        @endif
    </div>

@endsection
