@extends('app')

@section('content')
<h1>Compagnies Maritimes</h1>

<div class="row">
    <div class="col-md-5">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h3 class="panel-title">
                    Détails du Navire
                </h3>
            </div>
            <div class="panel-body">
                <h2>{{ $ship->name }}</h2>
            </div>
        </div>
    </div>
    <div class="col-md-7">

        <div class="btn-group">
            <a class="btn btn-success" href="{{ route('stops.add', [$company_id, $ship]) }}">
                <i class="fa fa-plus"></i> Nouvelle Escale
            </a>
        </div>

        <div class="table-responsive">
            <table class="table table-striped table-hover">
                <thead>
                    <tr>
                        <th>Date Entrée</th>
                        <th>Date Sortie</th>
                        <th>Nombre de chargement</th>
                        <th>Nombre de déchargement</th>
                        <th> </th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($ship->stops as $stop)
                        <tr>
                            <td>{{ $stop->getDateInString() }}</td>
                            <td>{{ $stop->getDateOutString() }}</td>
                            <td>
                                <span class="badge">{{ App\Movement::where('stop_id', $stop->id)->where('type', 'D')->count() }}</span>
                            </td>
                            <td><span class="badge">{{ App\Movement::where('stop_id', $stop->id)->where('type', 'C')->count()
                            }}</span></td>
                            <td>
                                <a class="btn btn-primary" rel="tooltip" title="Modifier" href="{{ route('stops.edit', [$company_id, $ship->id, $stop]) }}">
                                    <i class="fa fa-pencil"></i>
                                </a>
                                <a class="btn btn-danger delete" rel="tooltip" title="Supprimer" href="{{ route('stops.delete', [$company_id, $ship->id, $stop]) }}">
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
            if (!confirm("Voulez-vous vraiment supprimer cette escale ?")) {
                e.preventDefault();
                return false;
            }
        });
    });
</script>
@endsection