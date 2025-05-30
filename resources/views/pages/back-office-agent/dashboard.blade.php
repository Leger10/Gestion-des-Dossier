@extends('layouts.admin', ['titrePage' => 'DGTI - Gestion des agents'])

@section('content')
@include('partials.back-admin._nav')

<div class="content-wrapper">
    <section class="content-header">
        <h1>
            Gestion du personnel
            <small>Direction générale des Transmissions et de l'informatique</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Accueil</a></li>
            <li class="active"><i class="fa fa-users"></i> Gestion des agents</li>
        </ol>
    </section>
    <div class="row">
        {{-- Agents actifs --}}
        <div class="col-md-6 col-sm-12 col-xs-12">
            <div class="info-box" style="min-height: 160px;">
                <span class="info-box-icon bg-aqua" style="height: 160px; line-height: 160px;">
                    <i class="fa fa-user-plus" style="font-size: 30px;"></i>
                </span>
                <div class="info-box-content" style="padding-top: 30px;">
                    <span class="info-box-text" style="font-size: 20px; font-weight: bold; white-space: normal;">Agents
                        actifs</span>
                    <span class="info-box-number" style="font-size: 22px;">{{ $activeCount ?? 0 }}</span>
                </div>
            </div>
        </div>

        {{-- Archivés --}}
        <a href="{{ route('agent.archive') }}">
            <div class="col-md-6 col-sm-12 col-xs-12">
                <div class="info-box" style="min-height: 160px;">
                    <span class="info-box-icon bg-red" style="height: 160px; line-height: 160px;">
                        <i class="fa fa-archive" style="font-size: 30px;"></i>
                    </span>
                    <div class="info-box-content" style="padding-top: 30px;">
                        <span class="info-box-text"
                            style="font-size: 20px; font-weight: bold; white-space: normal;">Archivés</span>
                        <span class="info-box-number" style="font-size: 22px;">{{ $archivedCount ?? 0 }}</span>
                    </div>
                </div>
            </div>
        </a>
    </div>

    {{-- Liste des agents --}}
    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title">Liste des agents actifs</h3>
            <a href="{{ route('admin.agents.create') }}" class="btn btn-success pull-right">
                <i class="fa fa-plus"></i> Ajouter un agent
            </a>
        </div>

        <div class="box-body">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Nom</th>
                        <th>Prénom</th>
                        <th>Matricule</th>
                        <th>Grade</th>
                        <th>Direction</th>
                        <th>Service</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($agents as $agent)
                    <tr>
                        <td>{{ $agent->nom }}</td>
                        <td>{{ $agent->prenom }}</td>
                        <td>{{ $agent->matricule }}</td>
                        <td>{{ $agent->grade }}</td>
                        <td>{{ $agent->direction->name ?? 'N/A' }}</td>
                        <td>{{ $agent->service->name ?? 'N/A' }}</td>
                        <td>
                            <!-- Bouton Modifier -->
                            <button class="btn btn-primary btn-xs" data-toggle="modal"
                                data-target="#editModal{{ $agent->id }}" title="Modifier">
                                <i class="fa fa-edit"></i>
                            </button>
                            <!-- Bouton Archiver -->
                            <button class="btn btn-danger btn-xs" data-toggle="modal"
                                data-target="#deleteModal{{ $agent->id }}" title="Archiver">
                                <i class="fa fa-archive"></i>
                            </button>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="box-footer clearfix">
            {{ $agents->links('pagination::bootstrap-4') }}
        </div>
    </div>
    </section>
</div>

{{-- Modales --}}
@foreach($agents as $agent)
<!-- Modal d'archivage -->
<div class="modal fade" id="deleteModal{{ $agent->id }}" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <form action="{{ route('agent.destroy', $agent) }}" method="POST" class="modal-content">
            @csrf
            @method('DELETE')
            <div class="modal-header">
                <h4 class="modal-title">Confirmation d'archivage</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <p>Voulez-vous archiver l'agent : <strong>{{ $agent->prenom }} {{ $agent->nom }}</strong> ?</p>
                <div class="form-group">
                    <label>Type d'archivage :</label>
                    <select class="form-control" name="typeArchive" required>
                        <option value="" disabled selected>Choisir le type</option>
                        <option value="Affecté">Affecté</option>
                        <option value="Décédé">Décédé</option>
                        <option value="Démissionné">Démissionné</option>
                        <option value="Licencié">Licencié</option>
                        <option value="Rétraité">Rétraité</option>
                        <option value="Revoqué">Revoqué</option>
                        <option value="Autres">Autres</option>
                    </select>
                </div>
                <div class="form-group">
                    <label>Motif :</label>
                    <textarea class="form-control" name="motif" rows="4" placeholder="Motif d'archivage"
                        required></textarea>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Annuler</button>
                <button type="submit" class="btn btn-danger">Archiver</button>
            </div>
        </form>
    </div>
</div>

<!-- Modal d'édition -->
<div class="modal fade" id="editModal{{ $agent->id }}" tabindex="-1" aria-labelledby="editModalLabel{{ $agent->id }}"
    aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <form action="{{ route('agent.update', $agent->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editModalLabel{{ $agent->id }}">Modifier l'agent {{ $agent->nom }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Fermer">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <!-- Nom -->
                    <div class="form-group">
                        <label for="nom{{ $agent->id }}">Nom :</label>
                        <input type="text" name="nom" id="nom{{ $agent->id }}" class="form-control"
                            value="{{ old('nom', $agent->nom) }}" required>
                    </div>
                    <!-- Prénom -->
                    <div class="form-group">
                        <label for="prenom{{ $agent->id }}">Prénom :</label>
                        <input type="text" name="prenom" id="prenom{{ $agent->id }}" class="form-control"
                            value="{{ old('prenom', $agent->prenom) }}" required>
                    </div>
                    <!-- Telephone -->
                    <div class="form-group">
                        <label for="telephone{{ $agent->id }}">Téléphone :</label>
                        <input type="text" name="telephone" id="telephone{{ $agent->id }}" class="form-control"
                            value="{{ old('telephone', $agent->telephone) }}" required>
                    </div>
                    <!-- Date Naissance -->
                    <div class="form-group">
                        <label for="date_naissance{{ $agent->id }}">Date de naissance :</label>
                        <input type="date" name="date_naissance" id="date_naissance{{ $agent->id }}"
                            class="form-control"
                            value="{{ old('date_naissance', $agent->date_naissance ? $agent->date_naissance->format('Y-m-d') : '') }}"
                            required>
                    </div>
                    <!-- Lieu Naissance -->
                    <div class="form-group">
                        <label for="lieu_naissance{{ $agent->id }}">Lieu de naissance :</label>
                        <input type="text" name="lieu_naissance" id="lieu_naissance{{ $agent->id }}"
                            class="form-control" value="{{ old('lieu_naissance', $agent->lieu_naissance) }}" required>
                    </div>
                    <!-- Sexe -->
                    <div class="form-group">
                        <label for="sexe{{ $agent->id }}">Sexe :</label>
                        <select name="sexe" id="sexe{{ $agent->id }}" class="form-control" required>
                            <option value="M" {{ old('sexe', $agent->sexe) == 'M' ? 'selected' : '' }}>Masculin</option>
                            <option value="F" {{ old('sexe', $agent->sexe) == 'F' ? 'selected' : '' }}>Féminin</option>
                        </select>
                    </div>
                    <!-- Situation Matrimoniale -->
                    <div class="form-group">
                        <label for="situation_matrimoniale{{ $agent->id }}">Situation matrimoniale :</label>
                        <input type="text" name="situation_matrimoniale" id="situation_matrimoniale{{ $agent->id }}"
                            class="form-control"
                            value="{{ old('situation_matrimoniale', $agent->situation_matrimoniale) }}" required>
                    </div>
                    <!-- Matricule -->
                    <div class="form-group">
                        <label for="matricule{{ $agent->id }}">Matricule :</label>
                        <input type="text" name="matricule" id="matricule{{ $agent->id }}" class="form-control"
                            value="{{ old('matricule', $agent->matricule) }}" required>
                    </div>
                    <!-- Nationalité -->
                    <div class="form-group">
                        <label for="nationalite{{ $agent->id }}">Nationalité :</label>
                        <input type="text" name="nationalite" id="nationalite{{ $agent->id }}" class="form-control"
                            value="{{ old('nationalite', $agent->nationalite) }}" required>
                    </div>
                    <!-- Date recrutement -->
                    <div class="form-group">
                        <label for="date_recrutement{{ $agent->id }}">Date recrutement :</label>
                        <input type="date" name="date_recrutement" id="date_recrutement{{ $agent->id }}"
                            class="form-control"
                            value="{{ old('date_recrutement', $agent->date_recrutement ? $agent->date_recrutement->format('Y-m-d') : '') }}"
                            required>
                    </div>
                    <!-- Diplome recrutement -->
                    <div class="form-group">
                        <label for="diplome_recrutement{{ $agent->id }}">Diplôme recrutement :</label>
                        <input type="text" name="diplome_recrutement" id="diplome_recrutement{{ $agent->id }}"
                            class="form-control" value="{{ old('diplome_recrutement', $agent->diplome_recrutement) }}"
                            required>
                    </div>
                    <!-- Statut -->
                    <div class="form-group">
                        <label for="statut{{ $agent->id }}">Statut :</label>
                        <input type="text" name="statut" id="statut{{ $agent->id }}" class="form-control"
                            value="{{ old('statut', $agent->statut) }}" required>
                    </div>
                    <!-- Position -->
                    <div class="form-group">
                        <label for="position{{ $agent->id }}">Position :</label>
                        <input type="text" name="position" id="position{{ $agent->id }}" class="form-control"
                            value="{{ old('position', $agent->position) }}" required>
                    </div>
                    <!-- Grade -->
                    <div class="form-group">
                        <label for="grade{{ $agent->id }}">Grade :</label>
                        <input type="text" name="grade" id="grade{{ $agent->id }}" class="form-control"
                            value="{{ old('grade', $agent->grade) }}" required>
                    </div>
                    <!-- Categorie -->
                    <div class="form-group">
                        <label for="categorie{{ $agent->id }}">Catégorie :</label>
                        <input type="text" name="categorie" id="categorie{{ $agent->id }}" class="form-control"
                            value="{{ old('categorie', $agent->categorie) }}" required>
                    </div>
                    <!-- Echelon -->
                    <div class="form-group">
                        <label for="echelon{{ $agent->id }}">Échelon :</label>
                        <input type="number" name="echelon" id="echelon{{ $agent->id }}" class="form-control" min="1"
                            max="10" value="{{ old('echelon', $agent->echelon) }}" required>
                    </div>
                    <!-- Indice -->
                    <div class="form-group">
                        <label for="indice{{ $agent->id }}">Indice :</label>
                        <input type="text" name="indice" id="indice{{ $agent->id }}" class="form-control"
                            value="{{ old('indice', $agent->indice) }}">
                    </div>
                    <!-- Date prise de service -->
                    <div class="form-group">
                        <label for="date_prise_de_service{{ $agent->id }}">Date prise de service :</label>
                        <input type="date" name="date_prise_de_service" id="date_prise_de_service{{ $agent->id }}"
                            class="form-control"
                            value="{{ old('date_prise_de_service', $agent->date_prise_de_service ? $agent->date_prise_de_service->format('Y-m-d') : '') }}">
                    </div>
                    <!-- Rattachement type -->
                    <div class="form-group">
                        <label for="rattachement_type{{ $agent->id }}">Type de rattachement :</label>
                        <select name="rattachement_type" id="rattachement_type{{ $agent->id }}" class="form-control"
                            required>
                            <option value="direction" {{ old('rattachement_type', $agent->service_id ? 'service' :
                                'direction') == 'direction' ? 'selected' : '' }}>Direction</option>
                            <option value="service" {{ old('rattachement_type', $agent->service_id ? 'service' :
                                'direction') == 'service' ? 'selected' : '' }}>Service</option>
                        </select>
                    </div>
                    <!-- Selon type, afficher direction ou service -->
                    <div class="form-group" id="direction-group-{{ $agent->id }}"
                        style="{{ old('rattachement_type', $agent->service_id ? 'service' : 'direction') == 'direction' ? '' : 'display:none;' }}">
                        <label for="rattachement_type_id{{ $agent->id }}">Direction :</label>
                        <select name="rattachement_type_id" id="rattachement_type_id{{ $agent->id }}"
                            class="form-control">
                            <option value="">-- Choisir une direction --</option>
                            @foreach ($directions as $direction)
                            <option value="{{ $direction->id }}" {{ old('rattachement_type_id', $agent->direction_id) ==
                                $direction->id ? 'selected' : '' }}>
                                {{ $direction->name ?? $direction->libelle }}
                            </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group" id="service-group-{{ $agent->id }}"
                        style="{{ old('rattachement_type', $agent->service_id ? 'service' : 'direction') == 'service' ? '' : 'display:none;' }}">
                        <label for="service_id{{ $agent->id }}">Service :</label>
                        <select name="service_id" id="service_id{{ $agent->id }}" class="form-control">
                            <option value="">-- Choisir un service --</option>
                            @foreach ($services as $service)
                            <option value="{{ $service->id }}" {{ old('service_id', $agent->service_id) == $service->id
                                ? 'selected' : '' }}>
                                {{ $service->name ?? $service->libelle }}
                            </option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Fermer</button>
                    <button type="submit" class="btn btn-primary">Enregistrer</button>
                </div>
            </div>
        </form>
    </div>
</div>
@endforeach
@endsection

@push('styles')
<style>
    .info-box-content {
        padding: 10px;
    }

    .label {
        font-weight: normal;
    }

    .table>tbody>tr>td {
        vertical-align: middle;
    }

    .pull-right {
        float: right !important;
    }
</style>
@endpush

@push('scripts')
<script>
    @foreach($agents as $agent)
    $('#rattachement_type{{ $agent->id }}').on('change', function() {
        if ($(this).val() === 'direction') {
            $('#direction-group-{{ $agent->id }}').show();
            $('#service-group-{{ $agent->id }}').hide();
        } else {
            $('#direction-group-{{ $agent->id }}').hide();
            $('#service-group-{{ $agent->id }}').show();
        }
    });
@endforeach
$(function() {
    $('[title]').tooltip({ placement: 'top', trigger: 'hover' });
    $('#createModal').on('show.bs.modal', function() {
        $(this).find('form')[0].reset();
    });
});
</script>
@endpush