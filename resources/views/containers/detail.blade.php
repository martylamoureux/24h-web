@extends('app')

@section('content')
<h1>Clients</h1>

<div class="row">
    <div class="col-md-5">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h3 class="panel-title">
                    Détails du Conteneur
                </h3>
            </div>
            <div class="panel-body">
                <h2>{{ $container }}</h2>
            </div>
        </div>
    </div>
    <div class="col-md-7">

        <div class="btn-group">
            <a class="btn btn-success" href="{{ route('movements.add', [$client_id, $container]) }}">
                <i class="fa fa-plus"></i> Nouveau Mouvement
            </a>
        </div>

        <div class="table-responsive">
            <table class="table table-striped table-hover">
                <thead>
                    <tr>
                        <th>Escale</th>
                        <th>Type</th>
                        <th> </th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($container->movements as $movement)
                        <tr>
                        <td>
                        {{ $movement->stop }}
                        </td>
                            <td>
                                @if ($movement->type == 'C')
                                    Chargement
                                @else
                                    Déchargement
                                @endif
                            </td>
                            <td>
                                <a class="btn btn-primary" rel="tooltip" title="Modifier" href="{{ route('movements.edit', [$client_id, $container->id, $movement]) }}">
                                    <i class="fa fa-pencil"></i>
                                </a>
                                <a class="btn btn-danger delete" rel="tooltip" title="Supprimer" href="{{ route('movements.delete', [$client_id, $container->id, $movement]) }}">
                                    <i class="fa fa-trash-o"></i>
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="lead text-center text-muted">
                                Aucune Escape
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>


@endsection

@section('javascripts')
<script>
    $(document).ready(function() {
        $('.delete').on('click', function(e) {
            if (!confirm("Voulez-vous vraiment supprimer ce mouvement ?")) {
                e.preventDefault();
                return false;
            }
        });
    });
</script>
@endsection