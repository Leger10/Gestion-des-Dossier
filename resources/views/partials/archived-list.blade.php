@extends('layouts.admin', ['titrePage' => 'Agents Archivés'])

@section('content')
@include('partials.back-admin._nav')
<div class="content-wrapper">
    <section class="content-header">
        <h1>Liste des Agents Archivés</h1>
        <ol class="breadcrumb">
            <li><a href="{{ route('agent.index') }}"><i class="fa fa-dashboard"></i> Accueil</a></li>
            <li class="active">Agents Archivés</li>
        </ol>
    </section>

    <section class="content">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">Agents Archivés</h3>
            </div>
            <div class="box-body table-responsive no-padding">
                @if($archivedAgents->count())
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Nom</th>
                            <th>Prénom</th>
                            <th>Matricule</th>
                            <th>Date d'archivage</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($archivedAgents as $agent)
                        <tr>
                            <td>{{ $agent->nom }}</td>
                            <td>{{ $agent->prenom }}</td>
                            <td>{{ $agent->matricule }}</td>
                            <td>{{ $agent->deleted_at ? $agent->deleted_at->format('d/m/Y') : '' }}</td>
            <td class="text-nowrap">
    <div class="d-inline-flex gap-2">
        <form action="{{ route('agent.restore', $agent->id) }}" method="POST">
            @csrf
            @method('PUT')
            <button type="submit" class="btn btn-sm btn-success" title="Restaurer">
                <i class="fas fa-undo"></i>
            </button>
        </form>

        <form action="{{ route('agent.destroy', $agent->id) }}" method="POST">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-sm btn-danger" title="Supprimer définitivement"
                    onclick="return confirm('Êtes-vous sûr de vouloir supprimer définitivement cet agent ?');">
                <i class="fas fa-trash"></i>
            </button>
        </form>
    </div>
</td>
                        @endforeach
                    </tbody>
                </table>

                <div class="text-center">
                    {{ $archivedAgents->links() }}
                </div>

                @else
                <p>Aucun agent archivé trouvé.</p>
                @endif
            </div>
        </div>
    </section>
</div>
@endsection

                                <style>
                                    document.querySelectorAll('.delete-form').forEach(form=> {
                                            form.addEventListener('submit', function(e) {
                                                    if ( !confirm('Êtes-vous sûr de vouloir supprimer définitivement cet agent ?')) {
                                                        e.preventDefault();
                                                    }
                                                });
                                        });

                                    .btn-sm {
                                        padding: 0.25rem 0.5rem;
                                        font-size: 0.875rem;
                                        line-height: 1.5;
                                        border-radius: 0.2rem;
                                    }

                                    .btn i {
                                        margin-right: 3px;
                                    }
                                </style>