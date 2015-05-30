@extends('app')

@section('content')
<h1>
    @if ($stop->exists)
        Modifier une Escale
    @else
        Nouvelle Escale
    @endif
</h1>

<div class="btn-group">
        <a class="btn btn-default" href="{{ route('ships.detail', [$company_id, $ship_id]) }}">
        <i class="fa fa-chevron-left"></i> Retourner à la liste
    </a>
</div>

<br/><br/>

<form action="{{ URL::full() }}" method="post" class="form-horizontal">
<input name="_token" value="{{ csrf_token() }}" type="hidden"/>
    <div class="row">
        <div class="col-md-6 col-md-offset-3">

            <h3>Informations sur l'Escale</h3>

            <div class="form-group">
                <label for="date_in">Date d'entrée</label>
                <input type="text" name="date_in" id="date_in" class="form-control" placeholder="dd/mm/aaaa" value="{{ Session::get('_old_input.date_in', $stop->getDateIn()->format('d/m/Y')) }}"  />
            </div>

            <div class="form-group">
                <label for="date_out">Date de Sortie</label>
                <input type="text" name="date_out" id="date_out" class="form-control" placeholder="dd/mm/aaaa" value="{{ Session::get('_old_input.date_out', $stop->exists ? $stop->getDateOut()->format('d/m/Y') : '') }}"  />
            </div>

            <div class="text-right">
                <button type="submit" class="btn btn-primary">
                    <i class="fa fa-save"></i>
                    @if ($stop->exists)
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
