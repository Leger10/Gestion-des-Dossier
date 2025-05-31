@extends('layouts.admin', ['titrePage' => 'Actes administratifs'])

@section('content')
@include('partials.back-admin._nav')

<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="d-flex justify-content-between align-items-center">
                <h1>
                    <i class="fas fa-file-contract text-primary"></i>
                    Gestion des actes administratifs
                </h1>
                
                <!-- Bouton pour ajouter un nouvel acte administratif -->
                @if(isset($agent))
                <a href="{{ route('actes_administratifs.create', ['agent_id' => $agent->id]) }}"
                    class="btn btn-sm btn-outline-primary" title="Ajouter un nouvel acte administratif">
                    <i class="fas fa-plus"></i> Nouvel acte administratif
                </a>
                @else
                <a href="{{ route('actes_administratifs.create') }}"
                    class="btn btn-sm btn-outline-primary" title="Ajouter un nouvel acte administratif">
                    <i class="fas fa-plus"></i> Nouvel acte administratif
                </a>
                @endif
            </div>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">
            {{-- Affichage des messages de succès / erreurs --}}
            @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Fermer">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            @endif

            @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif

            <div class="card shadow-lg">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover">
                            <thead class="thead-light">
                                <tr>
                                    @if(!isset($agent))
                                    <th>Agent</th>
                                    @endif
                                    <th>Référence</th>
                                    <th>Type</th>
                                    <th>Date</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($actes as $acte)
                                <tr>
                                    @if(!isset($agent))
                                    <td>
                                        <a href="{{ route('agents.show', $acte->agent) }}">
                                            {{ $acte->agent->nom }} {{ $acte->agent->prenom }}
                                        </a>
                                    </td>
                                    @endif
                                    <td>{{ $acte->reference }}</td>
                                    <td>{{ $acte->type }}</td>
                                    <td>{{ $acte->date_acte->format('d/m/Y') }}</td>
                                    <td class="text-nowrap">
                                        <a href="{{ route('actes_administratifs.show', $acte->id) }}" 
                                           class="btn btn-sm btn-info" title="Voir les détails">
                                           <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('actes_administratifs.edit', $acte->id) }}" 
                                           class="btn btn-sm btn-warning" title="Modifier">
                                           <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('actes_administratifs.destroy', $acte->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger" 
                                                    title="Supprimer"
                                                    onclick="return confirm('Êtes-vous sûr de vouloir supprimer cet acte ?')">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="{{ isset($agent) ? 4 : 5 }}" class="text-center text-muted">
                                        Aucun acte administratif trouvé
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="d-flex justify-content-center mt-4">
                        {{ $actes->links() }}
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection

@section('scripts')
<script>
$(document).ready(function() {
    // Fermer automatiquement les alertes après 5 secondes
    setTimeout(function() {
        $('.alert').alert('close');
    }, 5000);
});
</script>
@endsection

<style>
    .table thead th {
        background-color: #f8f9fc;
        font-weight: 600;
    }
    .table-hover tbody tr:hover {
        background-color: rgba(0, 0, 0, 0.03);
    }
    .btn-sm {
        padding: 0.25rem 0.5rem;
    }
    .d-inline {
        display: inline;
    }
</style>