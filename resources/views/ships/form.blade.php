@extends('app')

@section('content')
<h1>
    @if ($ship->exists)
        Modifier un Navire
    @else
        Nouveau Navire
    @endif
</h1>

<div class="btn-group">
    <a class="btn btn-default" href="{{ route('companies.detail', $company_id) }}">
        <i class="fa fa-chevron-left"></i> Retourner à la liste
    </a>
</div>

<br/><br/>

<form action="{{ URL::full() }}" method="post" class="form-horizontal">
<input name="_token" value="{{ csrf_token() }}" type="hidden"/>
    <div class="row">
        <div class="col-md-6 col-md-offset-3">

            <h3>Informations sur le Navire</h3>

            <div class="form-group">
                <label for="name">Nom</label>
                <input type="text" class="form-control" name="name" id="name" value="{{ Session::get('_old_input.name', $ship->exists ? $ship->name : '') }}"/>
            </div>

            <div class="form-group">
                <label for="capacity">Capacité</label>
                <input type="number" class="form-control" name="capacity" id="capacity" value="{{ Session::get('_old_input.capacity', $ship->exists ? $ship->capacity : '') }}"/>
            </div>

            <div class="text-right">
                <button type="submit" class="btn btn-primary">
                    <i class="fa fa-save"></i>
                    @if ($ship->exists)
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
