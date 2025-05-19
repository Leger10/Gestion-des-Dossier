@extends('layouts.admin', ['titrePage' => 'DGTI'])
@section('content')
    @include('partials.back-admin._nav')
    {{-- -----End menu--------- --}}
    <div class="content-wrapper">
    <section class="content-header">
        <h1>
        Direction générale des transmissions et de l'informatique
        </h1>
        <ol class="breadcrumb">
            <li class="active"><i class="fa fa-dashboard"></i> Accueil</li>
            <li class="active"><i class="fa fa-user-plus"></i> <b><strong>Nouvel agent</strong></b></li>
        </ol>
    </section>
    <section class="content">
        @include('partials._title')
        <form action="{{route('agent.store')}}" method="post" class="animated-form">
            @csrf
            <div class="row">
                <div class="col-md-12">
                    @include('partials._notification')
                </div>
                <div class="col-md-12">
                    <div class="box box-primary">
                        <div class="box-header with-border">
                            <h3 class="box-title">Rattachement organisationnel</h3>
                        </div>
                        <div class="box-body">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Direction :</label>
                                    <select class="form-control" name="direction_id" required>
                                        <option value="" selected disabled>Sélectionner la direction</option>
                                        @foreach ($directions as $direction)
                                        <option value="{{$direction->id}}">{{$direction->libelle}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Service :</label>
                                    <select class="form-control" name="service_id" required>
                                        <option value="" selected disabled>Sélectionner le service</option>
                                        @foreach ($services as $service)
                                        <option value="{{$service->id}}">{{$service->libelle}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Type de rattachement :</label>
                                    <select class="form-control" name="rattachement_type_id">
                                        <option value="" selected disabled>Sélectionner le type</option>
                                        <option value="1">Direction</option>
                                        <option value="2">Service</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="box box-primary">
                        <div class="box-header with-border">
                            <h3 class="box-title">Informations personnelles</h3>
                        </div>
                        <div class="box-body">
                            <div class="form-group">
                                <label>Matricule: (*)</label>
                                <input type="text" class="form-control" name="matricule" value="{{ old('matricule') }}" placeholder="Saisir matricule..." required>
                                {!! $errors->first('matricule', '<span class="error text-error">:message</span>') !!}
                            </div>
                            <div class="form-group">
                                <label>Nom: (*)</label>
                                <input type="text" class="form-control" name="nom" value="{{ old('nom') }}" placeholder="Saisir nom..." required>
                                {!! $errors->first('nom', '<span class="error text-error">:message</span>') !!}
                            </div>
                            <div class="form-group">
                                <label>Prénom(s): (*)</label>
                                <input type="text" class="form-control" name="prenom" value="{{ old('prenom') }}" placeholder="Saisir prénom..." required>
                                {!! $errors->first('prenom', '<span class="error text-error">:message</span>') !!}
                            </div>
                            <div class="form-group">
                                <label>Sexe: (*)</label>
                                <select class="form-control" name="sexe" required>
                                    <option value="" selected disabled>Sélectionner</option>
                                    <option value="Masculin" {{ old('sexe') == 'Masculin' ? 'selected' : '' }}>Masculin</option>
                                    <option value="Feminin" {{ old('sexe') == 'Feminin' ? 'selected' : '' }}>Feminin</option>
                                </select>
                                {!! $errors->first('sexe', '<span class="error text-error">:message</span>') !!}
                            </div>
                            <div class="form-group">
                                <label>Date de naissance: (*)</label>
                                <div class="input-group date">
                                    <div class="input-group-addon">
                                        <i class="fa fa-calendar"></i>
                                    </div>
                                    <input name="date_naiss" value="{{ old('date_naiss') }}" class="form-control pull-right datepicker" placeholder='dd-mm-yyyy' required>
                                </div>
                                {!! $errors->first('date_naiss', '<span class="error text-error">:message</span>') !!}
                            </div>
                            <div class="form-group">
                                <label>Lieu de naissance: (*)</label>
                                <input type="text" class="form-control" name="lieu_naiss" value="{{ old('lieu_naiss') }}" placeholder="Saisir lieu de naissance..." required>
                                {!! $errors->first('lieu_naiss', '<span class="error text-error">:message</span>') !!}
                            </div>
                            <div class="form-group">
                                <label>Situation matrimoniale: (*)</label>
                                <select class="form-control" name="situation_matri" required>
                                    <option value="" selected disabled>Sélectionner</option>
                                    <option value="Célibataire" {{ old('situation_matri') == 'Célibataire' ? 'selected' : '' }}>Célibataire</option>
                                    <option value="Marié(e)" {{ old('situation_matri') == 'Marié(e)' ? 'selected' : '' }}>Marié(e)</option>
                                    <option value="Divorcé(e)" {{ old('situation_matri') == 'Divorcé(e)' ? 'selected' : '' }}>Divorcé(e)</option>
                                    <option value="Veuf(ve)" {{ old('situation_matri') == 'Veuf(ve)' ? 'selected' : '' }}>Veuf(ve)</option>
                                </select>
                                {!! $errors->first('situation_matri', '<span class="error text-error">:message</span>') !!}
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="box box-primary">
                        <div class="box-header with-border">
                            <h3 class="box-title">Informations professionnelles</h3>
                        </div>
                        <div class="box-body">
                            <div class="form-group">
                                <label>Date de prise de service: (*)</label>
                                <div class="input-group date">
                                    <div class="input-group-addon">
                                        <i class="fa fa-calendar"></i>
                                    </div>
                                    <input name="date_prise_de_service" value="{{ old('date_prise_de_service') }}" class="form-control pull-right datepicker" placeholder='dd-mm-yyyy' required>
                                </div>
                                {!! $errors->first('date_prise_de_service', '<span class="error text-error">:message</span>') !!}
                            </div>
                            <div class="form-group">
                                <label>Niveau de recrutement: (*)</label>
                                <input type="text" class="form-control" name="niveau_recrutement" value="{{ old('niveau_recrutement') }}" placeholder="Saisir niveau de recrutement..." required>
                                {!! $errors->first('niveau_recrutement', '<span class="error text-error">:message</span>') !!}
                            </div>
                            <div class="form-group">
                                <label>Emploi: (*)</label>
                                <input type="text" class="form-control" name="emploi" value="{{ old('emploi') }}" placeholder="Saisir emploi..." required>
                                {!! $errors->first('emploi', '<span class="error text-error">:message</span>') !!}
                            </div>
                            <div class="form-group">
                                <label>Fonction: (*)</label>
                                <input type="text" class="form-control" name="fonction" value="{{ old('fonction') }}" placeholder="Saisir fonction..." required>
                                {!! $errors->first('fonction', '<span class="error text-error">:message</span>') !!}
                            </div>
                            <div class="form-group">
                                <label>Statut: (*)</label>
                                <input type="text" class="form-control" name="statut" value="{{ old('statut') }}" placeholder="Saisir statut..." required>
                                {!! $errors->first('statut', '<span class="error text-error">:message</span>') !!}
                            </div>
                            <div class="form-group">
                                <label>Catégorie: (*)</label>
                                <input type="text" class="form-control" name="categorie" value="{{ old('categorie') }}" placeholder="Saisir catégorie..." required>
                                {!! $errors->first('categorie', '<span class="error text-error">:message</span>') !!}
                            </div>
                            <div class="form-group">
                                <label>Grade:</label>
                                <input type="text" class="form-control" name="grade" value="{{ old('grade') }}" placeholder="Saisir grade...">
                                {!! $errors->first('grade', '<span class="error text-error">:message</span>') !!}
                            </div>
                            <div class="form-group">
                                <label>Classe:</label>
                                <input type="text" class="form-control" name="classe" value="{{ old('classe') }}" placeholder="Saisir classe...">
                                {!! $errors->first('classe', '<span class="error text-error">:message</span>') !!}
                            </div>
                            <div class="form-group">
                                <label>Echelon:</label>
                                <input type="text" class="form-control" name="echelon" value="{{ old('echelon') }}" placeholder="Saisir échelon...">
                                {!! $errors->first('echelon', '<span class="error text-error">:message</span>') !!}
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="box box-primary">
                        <div class="box-header with-border">
                            <h3 class="box-title">Documents associés</h3>
                        </div>
                        <div class="box-body">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Autorisation d'absence:</label>
                                    <input type="text" class="form-control" name="autorisation_absence" value="{{ old('autorisation_absence') }}" placeholder="Référence...">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Demande de congé:</label>
                                    <input type="text" class="form-control" name="demande_conge" value="{{ old('demande_conge') }}" placeholder="Référence...">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Demande d'explication:</label>
                                    <input type="text" class="form-control" name="demande_explication" value="{{ old('demande_explication') }}" placeholder="Référence...">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Félicitation/Reconnaissance:</label>
                                    <input type="text" class="form-control" name="felicitation_reconnaissance" value="{{ old('felicitation_reconnaissance') }}" placeholder="Référence...">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Sanctions:</label>
                                    <input type="text" class="form-control" name="sanctions" value="{{ old('sanctions') }}" placeholder="Référence...">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Autre situation:</label>
                                    <input type="text" class="form-control" name="autre_situation" value="{{ old('autre_situation') }}" placeholder="Référence...">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <a href="{{URL::previous()}}" class="btn btn-danger btn-lg pull-left"><i class="fa fa-reply"></i> Retour</a>
                    <button type="submit" class="btn btn-info btn-lg pull-right"><i class="fa fa-check"></i> Valider</button>
                </div>
            </div>
        </form>
    </section>
    </div>
@endsection

@push('scripts.footer')
<script src="{{ asset('js/jquery.mask.js') }}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/animejs/3.2.1/anime.min.js"></script>

<style>
    .animated-form {
        perspective: 1000px;
    }
    .animated-form .box {
        transition: all 0.5s ease;
        transform-style: preserve-3d;
    }
    .animated-form .box:hover {
        transform: translateY(-5px) rotateX(5deg);
        box-shadow: 0 10px 20px rgba(0,0,0,0.2);
    }
    .animated-form .btn {
        transition: all 0.3s ease;
    }
    .animated-form .btn:hover {
        transform: scale(1.05);
    }
</style>

<script>
    // Animation 3D au chargement de la page
    document.addEventListener('DOMContentLoaded', function() {
        anime({
            targets: '.animated-form .box',
            translateY: [20, 0],
            opacity: [0, 1],
            duration: 800,
            delay: anime.stagger(100),
            easing: 'easeOutExpo'
        });
        
        anime({
            targets: '.animated-form .btn',
            scale: [0.9, 1],
            opacity: [0, 1],
            duration: 500,
            delay: 800,
            easing: 'easeOutExpo'
        });
    });

    $(document).ready(function() {
        $('.datepicker').datepicker({
            format: 'dd-mm-yyyy',
            autoclose: true
        });

        // Masque pour les numéros de téléphone
        $('input[name="contact"]').mask('+226 00 00 00 00');
        
        // Chargement dynamique des services en fonction de la direction sélectionnée
        $('select[name="direction_id"]').on('change', function() {
            var directionId = $(this).val();
            if(directionId) {
                $.ajax({
                    url: '/get-services/' + directionId,
                    type: 'GET',
                    dataType: 'json',
                    success: function(data) {
                        $('select[name="service_id"]').empty();
                        $('select[name="service_id"]').append('<option value="" selected disabled>Sélectionner le service</option>');
                        $.each(data, function(key, value) {
                            $('select[name="service_id"]').append('<option value="'+ key +'">'+ value +'</option>');
                        });
                    }
                });
            } else {
                $('select[name="service_id"]').empty();
                $('select[name="service_id"]').append('<option value="" selected disabled>Sélectionner le service</option>');
            }
        });
    });
</script>
@endpush