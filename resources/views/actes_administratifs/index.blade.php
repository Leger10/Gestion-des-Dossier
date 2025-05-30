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
                <!-- Bouton pour ouvrir le modal -->
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalAddActe">
                    <i class="fas fa-plus"></i> Nouvel acte administratif
                </button>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">

            {{-- Affichage des messages de succès / erreurs --}}
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Fermer"></button>
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
                    <table class="table table-hover table-striped">
                        <thead class="bg-light">
                            <tr>
                                <th># Référence</th>
                                <th>Type</th>
                                <th>Agent concerné</th>
                                <th>Date acte</th>
                                <th class="text-end">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($actes as $acte)
                            <tr>
                                <td>{{ $acte->reference }}</td>
                                <td>{{ $acte->type }}</td>
                                <td>{{ $acte->agent->nom_complet }}</td>
                                <td>{{ \Carbon\Carbon::parse($acte->date_acte)->format('d/m/Y') }}</td>
                                <td class="text-end">
                                    <div class="btn-group">
                                        <a href="#" class="btn btn-sm btn-outline-primary" title="Voir">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="#" class="btn btn-sm btn-outline-success" title="Modifier">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="#" method="POST" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cet acte ?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger" title="Supprimer">
                                                <i class="fas fa-trash-alt"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="text-center py-4 text-muted">
                                    <i class="fas fa-database fa-3x mb-3"></i>
                                    <p class="mb-0">Aucun acte administratif enregistré</p>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>

                    <div class="d-flex justify-content-center mt-4">
                        {{ $actes->links() }}
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<!-- Modal Ajout Acte Administratif -->
<div class="modal fade" id="modalAddActe" tabindex="-1" aria-labelledby="modalAddActeLabel" aria-hidden="true">
  <div class="modal-dialog">
    <form method="POST" action="{{ route('actes_administratifs.store') }}">
      @csrf
      <input type="hidden" name="agent_id" value="{{ $agent->id }}">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="modalAddActeLabel">Ajouter un acte administratif</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer"></button>
        </div>
        <div class="modal-body">
          <div class="mb-3">
            <label for="reference" class="form-label">Référence</label>
            <input type="text" class="form-control" id="reference" name="reference" required>
          </div>
          <div class="mb-3">
            <label for="type" class="form-label">Type</label>
            <input type="text" class="form-control" id="type" name="type" required>
          </div>
          <div class="mb-3">
            <label for="date_acte" class="form-label">Date de l'acte</label>
            <input type="date" class="form-control" id="date_acte" name="date_acte" required>
          </div>
          <div class="mb-3">
            <label for="description" class="form-label">Description</label>
            <textarea class="form-control" id="description" name="description" rows="3"></textarea>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
          <button type="submit" class="btn btn-primary">Enregistrer</button>
        </div>
      </div>
    </form>
  </div>
</div>
@endsection

