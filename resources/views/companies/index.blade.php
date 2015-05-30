@extends('app')

@section('content')
<h1>Compagnies Maritimes</h1>

<div class="btn-group">
    <a class="btn btn-success" href="{{ route('companies.add') }}">
        <i class="fa fa-plus"></i> Nouvelle Compagnie
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
            @forelse ($companies as $company)
                <tr>
                    <td>
                        <a href="{{ route('companies.detail', $company) }}">
                            {{ $company->name }}
                        </a>
                    </td>
                    <td>{{ $company->address }}</td>
                    <td>{{ $company->country }}</td>
                    <td><a href="mailto:{{ $company->user->email }}">{{ $company->user->email }}</a></td>
                    <td>
                        <a class="btn btn-primary" rel="tooltip" title="Modifier" href="{{ route('companies.edit', $company) }}">
                            <i class="fa fa-pencil"></i>
                        </a>
                        <a class="btn btn-danger delete" rel="tooltip" title="Supprimer" href="{{ route('companies.delete', $company) }}">
                            <i class="fa fa-trash-o"></i>
                        </a>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" class="lead text-center text-muted">
                        Aucune compagnie
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
            if (!confirm("Voulez-vous vraiment supprimer cette compagnie ?")) {
                e.preventDefault();
                return false;
            }
        });
    });
</script>
@endsection