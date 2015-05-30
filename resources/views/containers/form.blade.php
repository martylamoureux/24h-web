@extends('app')

@section('content')
<h1>
    @if ($container->exists)
        Modifier un Conteneur
    @else
        Nouveau Conteneur
    @endif
</h1>

<div class="btn-group">
        <a class="btn btn-default" href="{{ route('clients.detail', $client_id) }}">
        <i class="fa fa-chevron-left"></i> Retourner à la liste
    </a>
</div>

<br/><br/>

<form action="{{ URL::full() }}" method="post" class="form-horizontal">
<input name="_token" value="{{ csrf_token() }}" type="hidden"/>
    <div class="row">
        <div class="col-md-6 col-md-offset-3">

            <h3>Informations sur le Conteneur</h3>

            <div class="form-group">
                <label for="ship_id">Navire</label>
                {!! Form::select('ship_id', App\Ship::lists('name', 'id'), Session::get('_old_input.ship_id', $container->exists ? $container->ship_id : ''), ['class'=>'form-control'])  !!}            </div>

            <div class="form-group">
                <label for="capacity">Capacité</label>
                {!! Form::select('capacity', ['1' => '1 EVP', '2' => '2 EVP'], Session::get('_old_input.capacity', $container->exists ? $container->capacity : '1'), ['class'=>'form-control'])  !!}
            </div>

            <div class="text-right">
                <button type="submit" class="btn btn-primary">
                    <i class="fa fa-save"></i>
                    @if ($container->exists)
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
