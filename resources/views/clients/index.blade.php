@extends('app')

@section('content')
<h1>Clients</h1>

<div class="btn-group">
    <a class="btn btn-success" href="{{ route('clients.add') }}">
        <i class="fa fa-plus"></i> Nouveau Client
    </a>
</div>

<div class="table-responsive">
    <table class="table table-striped table-hover">
        <thead>
            <tr>
                <th>Nom</th>
                <th>Adresse</th>
                <th>Pays</th>
                <th>Adresse e-mail</th>
                <th> </th>
            </tr>
        </thead>
        <tbody>
            @forelse ($clients as $client)
                <tr>
                    <td><a href="{{ route('clients.detail', $client) }}">{{ $client->name }}</a></td>
                    <td>{{ $client->address }}</td>
                    <td>{{ $client->country }}</td>
                    <td><a href="mailto:{{ $client->user->email }}">{{ $client->user->email }}</a></td>
                    <td>
                        <a class="btn btn-primary" rel="tooltip" title="Modifier" href="{{ route('clients.edit', $client) }}">
                            <i class="fa fa-pencil"></i>
                        </a>
                        <a class="btn btn-danger delete" rel="tooltip" title="Supprimer" href="{{ route('clients.delete', $client) }}">
                            <i class="fa fa-trash-o"></i>
                        </a>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" class="lead text-center text-muted">
                        Aucun Client
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
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