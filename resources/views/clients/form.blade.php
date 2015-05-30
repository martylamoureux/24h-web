@extends('app')

@section('content')
<h1>
    @if ($client->exists)
        Modifier un Client
    @else
        Nouveau Client
    @endif
</h1>

<div class="btn-group">
    <a class="btn btn-default" href="{{ route('clients.index') }}">
        <i class="fa fa-chevron-left"></i> Retourner à la liste
    </a>
</div>

<br/><br/>

<form action="{{ URL::full() }}" method="post" class="form-horizontal">
<input name="_token" value="{{ csrf_token() }}" type="hidden"/>
    <div class="row">
        <div class="col-md-6 col-md-offset-3">

            <h3>Informations sur le Client</h3>

            <div class="form-group">
                <label for="name">Nom</label>
                <input type="text" class="form-control" name="name" id="name" value="{{ Session::get('_old_input.name', $client->exists ? $client->name : '') }}"/>
            </div>

            <div class="form-group">
                <label for="address">Adresse</label>
                <input type="text" class="form-control" name="address" id="address" value="{{ Session::get('_old_input.address', $client->exists ? $client->address : '') }}"/>
            </div>

            <div class="form-group">
                <label for="country">Pays</label>
                <input type="text" class="form-control" name="country" id="country" value="{{ Session::get('_old_input.country', $client->exists ? $client->country : '') }}"/>
            </div>

            <h3>Informations sur le Compte Utilisateur</h3>

            <div class="form-group">
                <label for="email">Adresse E-mail</label>
                <input type="text" class="form-control" name="email" id="email" value="{{ Session::get('_old_input.email', $client->exists ? $client->user->email : '') }}"/>
            </div>

            @unless ($client->exists)
                <div class="form-group">
                    <label for="password">Mot de Passe</label>
                    <input type="password" class="form-control" name="password" id="password" value="" />
                </div>

                <div class="form-group">
                    <label for="password_confirmation">Confirmation du Mot de Passe</label>
                    <input type="password" class="form-control" name="password_confirmation" id="password_confirmation" value="" />
                </div>
            @endunless

            <div class="text-right">
                <button type="submit" class="btn btn-primary">
                    <i class="fa fa-save"></i>
                    @if ($client->exists)
                        Enregistrer
                    @else
                        Créer
                    @endif
                </button>
            </div>

        </div>
    </div>
</form>

@endsection
