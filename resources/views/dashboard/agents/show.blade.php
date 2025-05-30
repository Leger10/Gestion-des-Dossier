@extends('layouts.admin', ['titrePage' => 'DGTI'])

@section('content')
@include('partials.back-admin._nav')

<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="d-flex justify-content-between align-items-center mb-5">
                <div class="d-flex align-items-center gap-3">
                    <i class="fas fa-folder-open fa-2x text-primary"></i>
                    <div>
                        <b><h1 class="h3 mb-0">Gérer mes dossiers</h1></b>
                        <p class="text-muted mb-0">{{ $agent->nom_complet }}</p>
                    </div>
                </div>
                <div class="badge bg-primary bg-opacity-10 text-primary fs-6 px-4 py-2 rounded-pill">
                    <i class="fas fa-id-card me-2"></i>
                    Matricule: {{ $agent->matricule }}
                </div>
            </div>
        </div>
    </section>

    <div class="container-fluid">
        <div class="row g-4">

            @php
            $sections = [
            'actes_administratifs' => [
            'title' => 'Actes Administratifs',
            'icon' => 'file-contract',
            'color' => 'primary',
            'count' => $agent->actes_administratifs->count()
            ],
            'evaluations' => [
            'title' => 'Évaluations',
            'icon' => 'chart-line',
            'color' => 'success',
            'count' => $agent->evaluations->count()
            ],
            'sanctions' => [
            'title' => 'Sanctions',
            'icon' => 'gavel',
            'color' => 'danger',
            'count' => $agent->sanctions->count()
            ],
            'recompenses' => [
            'title' => 'Récompenses',
            'icon' => 'trophy',
            'color' => 'warning',
            'count' => $agent->recompenses->count()
            ],
            'conge_absences' => [
            'title' => 'Congés & Absences',
            'icon' => 'plane-departure',
            'color' => 'info',
            'count' => $agent->conge_absences->count()
            ],
            'formations' => [
            'title' => 'Formations',
            'icon' => 'graduation-cap',
            'color' => 'purple', // couleur personnalisée
            'count' => $agent->formations->count()
            ],
            'affectations' => [
            'title' => 'Affectations',
            'icon' => 'building',
            'color' => 'dark',
            'count' => $agent->affectations->count()
            ],
            ];
            @endphp

@foreach($sections as $route => $config)
<div class="col-12 col-md-6 col-xl-4 col-xxl-3">
    <div class="card border-0 shadow-sm h-100 transition-all hover-shadow">
        <div class="card-header bg-soft-{{ $config['color'] }} py-3">
            <div class="w-100 text-center">
                <i class="fas fa-2x fa-{{ $config['icon'] }} text-{{ $config['color'] }} mb-2 d-block"></i>
                <h2 class="section-title mb-0">{{ $config['title'] }}</h2>
                <span class="text-muted small">
                    {{ $config['count'] }} élément{{ $config['count'] > 1 ? 's' : '' }}
                </span>
            </div>
        </div>

        <div class="card-body p-0">
            @if($config['count'] > 0)
            <div class="list-group list-group-flush">
                @foreach($agent->{$route}->take(3) as $item)
                <div class="list-group-item border-0 py-3 px-4">
                    <div class="d-flex justify-content-between align-items-start">
                        <div class="flex-grow-1 me-3">
                            <small class="text-muted d-block mb-1">
                                <i class="fas fa-calendar-alt me-1"></i>
                                {{ \Carbon\Carbon::parse($item->created_at)->translatedFormat('d M Y') }}
                            </small>
                            <div class="fw-semibold text-truncate">{{ $item->type ?? 'Sans titre' }}</div>
                            <p class="mb-0 text-muted text-truncate small">
                                {{ $item->description ?? 'Aucun détail fourni' }}
                            </p>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            @else
            <div class="text-center py-5 bg-light-subtle">
                <i class="fas fa-inbox fa-2x text-muted opacity-50"></i>
                <p class="mb-0 text-muted small mt-2">Aucun élément enregistré</p>
            </div>
            @endif
        </div>

        {{-- Footer intégré à l'intérieur de la carte --}}
        <div class="card-footer bg-transparent border-top-0 d-flex justify-content-between align-items-center py-3 px-4">
            <a href="{{ route($route . '.index', ['agent' => $agent->id]) }}"
                class="btn btn-link text-decoration-none text-{{ $config['color'] }} px-2 small">
                Voir tout
            </a>
            <a href="{{ route($route . '.create', $agent) }}"
                class="btn btn-sm btn-{{ $config['color'] }} rounded-pill px-3 shadow-sm d-flex align-items-center gap-2">
                <i class="fas fa-plus fa-sm"></i>
                <span>Ajouter</span>
            </a>
        </div>
    </div>
</div>
@endforeach


<style>
    .section-title {
        font-size: 1.5rem;
        /* Taille plus grande */
        font-weight: bold;
        text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.2);
        
        /* Effet 3D */
        letter-spacing: 1px;
        text-transform: uppercase;
    }

    .hover-shadow {
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }

    .hover-shadow:hover {
        transform: translateY(-2px);
        box-shadow: 0 0.5rem 1.5rem rgba(0, 0, 0, 0.08) !important;
    }

    .bg-soft-primary {
        background-color: #e3f2fd;
    }

    .bg-soft-success {
        background-color: #e8f5e9;
    }

    .bg-soft-danger {
        background-color: #ffebee;
    }

    .bg-soft-warning {
        background-color: #fff8e1;
    }

    .bg-soft-info {
        background-color: #e0f7fa;
    }

    .bg-soft-purple {
        background-color: #f3e5f5;
    }

    .bg-soft-secondary {
        background-color: #f5f5f5;
    }
</style>