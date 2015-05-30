@extends('app')

@section('content')
<h1>Clients</h1>

<div class="row">
    <div class="col-md-5">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h3 class="panel-title">
                    Détails du Client
                </h3>
            </div>
            <div class="panel-body">
                <h2>{{ $client->name }}</h2>
            </div>
        </div>
    </div>
    <div class="col-md-7">

        <div class="btn-group">
            <a class="btn btn-success" href="{{ route('containers.add', $client) }}">
                <i class="fa fa-plus"></i> Nouveau Conteneur
            </a>
        </div>

        <div class="table-responsive">
            <table class="table table-striped table-hover">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Navire</th>
                        <th>Capacité</th>
                        <th> </th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($client->containers as $container)
                        <tr>
                            <td><a href="{{ route('containers.detail', [$client->id, $container]) }}">{{ $container->id }}</a></td>
                            <td><a href="{{ route('containers.detail', [$client->id, $container]) }}">{{ $container->ship }}</a></td>
                            <td>{{ $container->capacity }} EVP</td>
                            <td>
                                <a class="btn btn-primary" rel="tooltip" title="Modifier" href="{{ route('containers.edit', [$client, $container]) }}">
                                    <i class="fa fa-pencil"></i>
                                </a>
                                <a class="btn btn-danger delete" rel="tooltip" title="Supprimer" href="{{ route('containers.delete', [$client, $container]) }}">
                                    <i class="fa fa-trash-o"></i>
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="lead text-center text-muted">
                                Aucun Conteneur
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
            if (!confirm("Voulez-vous vraiment supprimer ce conteneur ?")) {
                e.preventDefault();
                return false;
            }
        });
    });
</script>
@endsection