@extends('app')

@section('content')
<h1>Compagnies Maritimes</h1>

<div class="row">
    <div class="col-md-5">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h3 class="panel-title">
                    Détails de la Compagnie
                </h3>
            </div>
            <div class="panel-body">
                <h2>{{ $company->name }}</h2>
            </div>
        </div>
    </div>
    <div class="col-md-7">

        <div class="btn-group">
            <a class="btn btn-success" href="{{ route('ships.add', $company) }}">
                <i class="fa fa-plus"></i> Nouveau Navire
            </a>
        </div>

        <div class="table-responsive">
            <table class="table table-striped table-hover">
                <thead>
                    <tr>
                        <th>Nom</th>
                        <th>Capacité</th>
                        <th> </th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($company->ships as $ship)
                        <tr>
                            <td><a href="{{ route('ships.detail', [$company, $ship]) }}">{{ $ship->name }}</a></td>
                            <td>{{ $ship->capacity }} EVP</td>
                            <td>
                                <a class="btn btn-primary" rel="tooltip" title="Modifier" href="{{ route('ships.edit', [$company, $ship]) }}">
                                    <i class="fa fa-pencil"></i>
                                </a>
                                <a class="btn btn-danger delete" rel="tooltip" title="Supprimer" href="{{ route('ships.delete', [$company, $ship]) }}">
                                    <i class="fa fa-trash-o"></i>
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="lead text-center text-muted">
                                Aucun Navire
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
            if (!confirm("Voulez-vous vraiment supprimer ce navire ?")) {
                e.preventDefault();
                return false;
            }
        });
    });
</script>
@endsection