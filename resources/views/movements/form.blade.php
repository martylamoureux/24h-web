@extends('app')

@section('content')
<h1>
    @if ($movement->exists)
        Modifier un Mouvement
    @else
        Nouveau Mouvement
    @endif
</h1>

<div class="btn-group">
        <a class="btn btn-default" href="{{ route('containers.detail', [$client_id, $container_id]) }}">
        <i class="fa fa-chevron-left"></i> Retourner à la liste
    </a>
</div>

<br/><br/>

<form action="{{ URL::full() }}" method="post" class="form-horizontal">
<input name="_token" value="{{ csrf_token() }}" type="hidden"/>
    <div class="row">
        <div class="col-md-6 col-md-offset-3">

            <h3>Informations sur le Mouvement</h3>

            <div class="form-group">
                <label for="stop_id">Escale</label>
                {!!
                    Form::select('stop_id',
                       App\Stop::getList($ship_id),
                       Session::get('_old_input.type', $movement->exists ? $movement->type : 'C'),
                       ['class' => 'form-control']
                    )
                !!}
            </div>

            <div class="form-group">
                <label for="type">Type de mouvement</label>
                {!!
                    Form::select('type',
                       ['C' => 'Chargement', 'D' => 'Déchargement'],
                       Session::get('_old_input.type', $movement->exists ? $movement->type : 'C'),
                       ['class' => 'form-control']
                    )
                !!}
            </div>

            <div class="text-right">
                <button type="submit" class="btn btn-primary">
                    <i class="fa fa-save"></i>
                    @if ($movement->exists)
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
