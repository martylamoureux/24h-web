@extends('app')

@section('content')
<h1>Quantité sur un Mois</h1>

<div class="row">
    <div class="col-md-3">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h3 class="panel-title">
                    <i class="fa fa-filter"></i> Filtres
                </h3>
            </div>
            <div class="panel-body">
                <form action="{{ URL::full() }}" method="post" class="form-horizontal" style="padding: 0 8px;" >
                <input name="_token" value="{{ csrf_token() }}" type="hidden"/>

                    <div class="form-group">
                        <label for="month">Client</label>
                        {!!
                            Form::select('client',
                                $clients,
                                Request::get('client', ''),
                                ['class' => 'form-control']
                            )
                        !!}
                    </div>

                    <div class="form-group">
                        <label for="month">Période</label>
                        {!!
                            Form::select('month',
                                $months,
                                Request::get('month', ''),
                                ['class' => 'form-control']
                            )
                        !!}
                    </div>

                    <div class="form-group">
                        <label for="ship">Navire</label>
                        {!!
                            Form::select('ship',
                                $ships,
                                Request::get('ship', ''),
                                ['class' => 'form-control']
                            )
                        !!}
                    </div>

                    @if (count($stops) > 0)
                        <div class="form-group">
                            <label for="stop">Escale</label>
                            {!!
                                Form::select('stop',
                                    $stops,
                                    Request::get('stop', ''),
                                    ['class' => 'form-control']
                                )
                            !!}
                        </div>
                    @endif

                    <button type="submit" class="btn btn-primary btn-block">
                        <i class="fa fa-filter"></i> Filtrer
                    </button>

                </form>
            </div>
        </div>
    </div>
    <div class="col-md-9">
        @if (Request::has('_token'))
            <div class="panel panel-success">
                <div class="panel-heading">
                    <h3 class="panel-title">
                        <i class="fa fa-table"></i> Résultats
                    </h3>
                </div>
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>Compagnie</th>
                            <th>Navire</th>
                            <th>Nb Chargements</th>
                            <th>Nb Déchargements</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($results as $company => $stepdata)
                            @foreach ($stepdata as $ship => $data)
                                <tr>
                                    <td>{{ $company }}</td>
                                    <td>{{ $ship }}</td>
                                    <td>{{ $data['chargement'] }}</td>
                                    <td>{{ $data['dechargement'] }}</td>
                                </tr>
                            @endforeach
                        @empty
                            <tr>
                                <td colspan="4" class="lead text-center text-muted">
                                    Aucun résultat
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        @endif
    </div>
</div>
@endsection

@section('javascripts')
<script>
    $(document).ready(function() {
        $('.delete').on('click', function(e) {
            if (!confirm("Voulez-vous vraiment supprimer ce client ?")) {
                e.preventDefault();
                return false;
            }
        });
    });
</script>
@endsection