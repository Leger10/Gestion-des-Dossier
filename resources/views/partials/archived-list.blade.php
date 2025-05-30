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
                            <td>
                                {{-- Exemple: bouton restaurer --}}
                                <form action="{{ route('agent.restore', $agent->id) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <button type="submit">Restaurer</button>
                                </form>


                                {{-- Exemple: bouton supprimer définitivement --}}
                                <form action="{{ route('agent.destroy', $agent->id) }}" method="POST"
                                    style="display:inline;"
                                    onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer définitivement cet agent ?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm"
                                        title="Supprimer définitivement">
                                        <i class="fa fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
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