@extends('layouts.admin', ['titrePage' => 'DGTI'])

@section('content')
@include('partials.back-admin._nav')

<div class="content-wrapper">

    {{-- En-tête de section --}}
    <section class="content-header">
        <h1>
            Direction générale des transmissions et de l'informatique
            <small>Liste des agents</small>
        </h1>

        {{-- Titre secondaire et actions rapides --}}
        <div class="d-flex align-items-center justify-content-between mb-4">
            <div>
                <h1 class="h3 mb-0 text-gray-800">
                    <i class="fas fa-users-cog text-primary me-2"></i>Gestion des dossiers agents
                </h1>
                <p class="mb-0 text-muted">{{ $agents->total() }} agents enregistrés</p>
            </div>

            <div class="d-flex align-items-center gap-3">
                <div class="card-stat bg-primary text-white">
                    <i class="fas fa-chart-line"></i>
                    <span>+12% ce mois</span>
                </div>
                <a href="{{ route('agent.create') }}" class="btn btn-primary rounded-pill">
                    <i class="fas fa-plus me-2"></i>Nouvel agent
                </a>
            </div>
        </div>

        {{-- Filtres de recherche --}}
        <div class="card shadow-sm mb-4 border-0 animate__animated animate__fadeIn">
            <div class="card-body bg-light-gradient">
                <form class="row g-3 align-items-center">
                    {{-- Nom --}}
                    <div class="col-md-4">
                        <div class="input-group input-group-lg">
                            <span class="input-group-text bg-white border-end-0">
                                <i class="fas fa-search text-primary"></i>
                            </span>
                            <input type="text" name="nom" class="form-control border-start-0"
                                placeholder="Rechercher un agent..." value="{{ request('nom') }}">
                        </div>
                    </div>

                    {{-- Matricule --}}
                    <div class="col-md-3">
                        <div class="input-group input-group-lg">
                            <span class="input-group-text bg-white border-end-0">
                                <i class="fas fa-id-card text-primary"></i>
                            </span>
                            <input type="text" name="matricule" class="form-control border-start-0"
                                placeholder="Matricule..." value="{{ request('matricule') }}">
                        </div>
                    </div>

                    {{-- Services --}}
                    <div class="col-md-3">
                        <select class="form-select form-select-lg" name="service">
                            <option value="">Tous les services</option>
                            @foreach($services as $service)
                            <option value="{{ $service->id }}" @selected(request('service')==$service->id)>
                                {{ e($service->name) }}
                            </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Bouton Filtrer --}}
                    <div class="col-md-2 d-grid">
                        <button type="submit" class="btn btn-primary btn-lg">
                            <i class="fas fa-filter me-2"></i>Filtrer
                        </button>
                    </div>
                </form>
            </div>
        </div>

        {{-- Tableau des agents --}}
        <div class="card shadow-sm border-0 overflow-hidden">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="bg-primary text-white">
                            <tr>
                                <th class="ps-4 py-3" style="width: 40%">Agent</th>
                                <th class="py-3">Matricule</th>
                                <th class="py-3">Service</th>
                                <th class="py-3">Statut</th>
                                <th class="text-end pe-4 py-3">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($agents as $agent)
                            <tr class="hover-lift">
                                {{-- Identité agent --}}
                                <td class="ps-4">
                                    <div class="d-flex align-items-center">
                                        <div class="avatar me-3">
                                            <img src="{{ asset('assets/img/avatar.png') }}" class="rounded-circle"
                                                alt="Avatar" width="40">
                                        </div>
                                        <div>
                                            <h6 class="mb-0 fw-bold">{{ $agent->nom_complet }}</h6>
                                            <small class="text-muted">{{ $agent->email }}</small>
                                        </div>
                                    </div>
                                </td>

                                {{-- Matricule --}}
                                <td>
                                    <span class="bg-light text-dark rounded-pill px-3 py-1">
                                        {{ $agent->matricule }}
                                    </span>

                                </td>

                                {{-- Service --}}
                                <td class="fw-medium text-dark">
                                    {{ $agent->service->name ?? '-' }}
                                </td>

                                {{-- Statut --}}
                                <td>
                                    <span class="bg-success bg-opacity-10 text-success rounded-pill px-3 py-1 small">
                                        <i class="fas fa-circle me-1 small"></i>Actif
                                    </span>

                                </td>

                                {{-- Actions --}}
                                <td class="text-end pe-4">
                                    <div class="d-flex gap-3 justify-content-end">
                                        <a href="{{ route('dashboard.agent.details', $agent->id) }}"
                                            class="btn btn-icon btn-primary rounded-circle action-btn"
                                            data-bs-toggle="tooltip" title="Dossier complet">
                                            <i class="fas fa-file-invoice fa-fw"></i>
                                        </a>

                                        <a href="#" class="btn btn-icon btn-success rounded-circle action-btn"
                                            data-bs-toggle="tooltip" title="Éditer l'agent">
                                            <i class="fas fa-pen fa-fw"></i>
                                        </a>

                                        <button type="button" class="btn btn-icon btn-danger rounded-circle action-btn"
                                            data-bs-toggle="tooltip" title="Archiver l'agent">
                                            <i class="fas fa-archive fa-fw"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="text-center py-5">
                                    <div class="empty-state">
                                        <img src="{{ asset('assets/img/empty.svg') }}" class="img-fluid mb-4"
                                            width="200" alt="Aucun résultat">
                                        <h4 class="mb-1">Aucun agent trouvé</h4>
                                        <p class="text-muted">Essayez d'ajuster vos filtres de recherche</p>
                                    </div>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                {{-- Pagination --}}
                @if($agents->hasPages())
                <div class="card-footer bg-transparent border-top">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="text-muted small">
                            Affichage <strong>{{ $agents->firstItem() }}-{{ $agents->lastItem() }}</strong>
                            sur <strong>{{ $agents->total() }}</strong>
                        </div>
                        {{ $agents->withQueryString()->links('vendor.pagination.bootstrap-5') }}
                    </div>
                </div>
                @endif
            </div>
        </div>
    </section>
</div>



@endsection