@extends('layouts.admin', ['titrePage' => 'DGTPT'])
@section('content')
    @include('partials.back-admin._nav')
    {{-- -----End menu--------- --}}
    <div class="content-wrapper">
    <section class="content-header">
        <h1>
        Direction générale des collectivités territoriales
        </h1>
        <ol class="breadcrumb">
            <li class="active"><i class="fa fa-dashboard"></i> Accueil</li>
            <li class="active"><i class="fa fa-user-plus"></i> <b><strong>Nouvel agent</strong></b></li>
        </ol>
    </section>
    <section class="content">
        @include('partials._title')
        <form action="{{route('agent.store')}}" method="post">
            @csrf
            <div class="row">
                <div class="col-md-12">
                    @include('partials._notification')
                </div>
                <div class="col-md-12">
                    <div class="box box-primary">
                        <div class="box-header with-border">
                            <h3 class="box-title">Choisissez la zone</h3>
                        </div>
                        <div class="box-body" >
                            <div class="col-md-4">
                                {!! $errors->first('region', '<span class="error text-error">Sélectionner la région</span>') !!}
                                {!! $errors->first('collectivite', '<span class="error text-error">Sélectionner la collectivité</span>') !!}
                                <div class="form-group">
                                    <label> Champs obligatoires (*)</label><br>
                                    <label>
                                        <input type="radio" name="radio_type" value=1 onclick="zone(0)" <?php if(old('radio_type')== "1") { echo 'checked'; } ?>>
                                        Régions CT
                                    </label><br>
                                    <label>
                                        <input type="radio" name="radio_type" value=2  onclick="zone(1)" <?php if(old('radio_type')== "2") { echo 'checked'; } ?>>
                                        Communes
                                    </label>
                                </div>
                                {!! $errors->first('radio_type', '<span class="error text-error">:message</span>') !!}
                            </div>

                        </div>
                    </div>
                </div>
            </div>
            <div class="box box-primary"  id="region" style="display:none;">
                <div class="box-header with-border">
                    <h3 class="box-title">Région CT de l'agent</h3>
                </div>
                <div class="box-body" >
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Région CT :</label>
                            <select class="form-control" id="direction" name="direction">
                                <option value="" selected disabled>Sélectionner la région</option>
                                @foreach ($direction as  $items)
                                <option {{ old('direction') == $items->id ? 'selected' : '' }} value="{{$items->id}}" >{{$items->libelle}}</option>
                                @endforeach
                            </select>
                        </div>
                        {!! $errors->first('direction', '<span class="error text-error">:message</span>') !!}
                    </div>
                </div>
            </div>
            <div class="box box-primary"  id="commune" style="display:none;">
                    <div class="box-header with-border">
                        <h3 class="box-title">Commune</h3>
                    </div>
                        <!-- <div class="box-body" >
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="radio-inline">
                                        <input type="radio" name="statutCommune" value="Rurale" {{ (old('statutCommune') == 'Rurale') ? 'checked' : '' }}  >
                                        Rurale
                                    </label>
                                    <label class="radio-inline">
                                        <input type="radio" name="statutCommune" value="Urbaine" {{ (old('statutCommune') == 'Urbaine') ? 'checked' : '' }}   >
                                        Urbaine
                                    </label>
                                    <label class="radio-inline">
                                        <input type="radio" name="statutCommune" value="Urbaine à statut particulier" {{ (old('statutCommune') == "Urbaine à statut particulier") ? 'checked' : '' }}   >
                                        Urbaine à statut particulier
                                    </label>
                                </div>
                                {!! $errors->first('statutCommune', '<span class="error text-error">:message</span>') !!}
                            </div>
                        </div> -->
                    <div class="box-body" >
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Région :</label>
                                    <select class="form-control" id="regCommune" name="regCommune">
                                        <option value="" selected disabled>Sélectionner une région pour voir les provinces associées</option>
                                        @foreach ($direction as  $items)
                                            <option {{ old('regCommune') == $items->id ? 'selected' : '' }} value="{{$items->id}}">{{$items->libelle}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Province :</label>
                                    <select class="form-control" id="provinces" name="provinces">
                                        <option  value="" selected disabled>Province</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Collectivité :</label>
                                    <select class="form-control" id="collectivite" name="collectivite">
                                        <option value="" selected disabled>Commune</option>
                                    </select>
                                </div>
                            {!! $errors->first('collectivite', '<span class="error text-error">:message</span>') !!}
                            </div>

                        </div>
                </div>

            <div class="row">

                <div class="col-md-6">
                    <div class="box box-primary">
                        <div class="box-header with-border">
                            <h3 class="box-title"> Les données personnelles de l'agent</h3>
                        </div>

                        <div class="box-body">
                            <div class="form-group">
                                <label>Nom: (*)</label>
                                <input type="text" class="form-control" name="nom" value="{{ old('nom') }}" placeholder="Saisir nom ...">
                                {!! $errors->first('nom', '<span class="error text-error">:message</span>') !!}
                            </div>
                            <div class="form-group">
                                <label>Prénom (s): (*)</label>
                                <input type="text" class="form-control" name="prenom" value="{{ old('prenom') }}" placeholder="Saisir prénom ...">
                                {!! $errors->first('prenom', '<span class="error text-error">:message</span>') !!}
                            </div>
                            <div class="form-group">
                                <label>Contact du fonctionnaire: (*)</label>
                                <input type="tel" class="form-control" name="contactFonctionnaire" value="{{ old('contactFonctionnaire') }}" placeholder="Saisir contacts du fonctionnaire ...">
                                <!-- {!! $errors->first('contactFonctionnaire', '<span class="error text-error">:message</span>') !!} -->
                            </div>
                            <div class="form-group">
                                <label>Date de naissance: (*)</label>
                                <div class="input-group date">
                                    <div class="input-group-addon">
                                    <i class="fa fa-calendar"></i>
                                    </div>
                                    <!-- <input class="datepicker" > -->
                                    <input name="datenaiss" value="{{ old('datenaiss') }}" class="form-control pull-right datepicker" placeholder='dd-mm-yyyy' >
                                </div>
                                <!-- {!! $errors->first('datenaiss', '<span class="error text-error">:message</span>') !!} -->
                            </div>
                            <div class="form-group">
                                <label>Lieu de naissance: (*)</label>
                                <input type="text" class="form-control" name="lieunaiss" value="{{ old('lieunaiss') }}" placeholder="Saisir lieu de naissance...">
                                <!-- {!! $errors->first('lieunaiss', '<span class="error text-error">:message</span>') !!} -->
                            </div>
                            <div class="form-group">
                                <label>Sexe: (*)</label>
                                <div class="radio">
                                    <label>
                                    <input type="radio" name="sexe"  id="optionsRadios1" value="masculin" <?php if(old('sexe')== "masculin") { echo 'checked'; } ?> >
                                    Masculin
                                    </label>
                                </div>
                                <div class="radio">
                                    <label>
                                    <input type="radio" name="sexe" id="optionsRadios2" value="feminin" <?php if(old('sexe')== "feminin") { echo 'checked'; } ?> >
                                    Feminin
                                    </label>
                                </div>
                                <!-- {!! $errors->first('sexe', '<span class="error text-error">:message</span>') !!} -->
                            </div>
                            <div class="form-group">
                                <label>Nationalité: (*)</label>
                                <input type="text" class="form-control" name="nationalite" value="{{ old('nationalite') }}" placeholder="Saisir la nationalité ...">
                                <!-- {!! $errors->first('nationalite', '<span class="error text-error">:message</span>') !!} -->
                            </div>
                            <div class="form-group">
                                <label>Situation matrimoniale: (*)</label>
                                <div class="radio">
                                    <label>
                                    <input type="radio" name="situaMatri" id="optionsRadios1"  value="célibataire" <?php if(old('situaMatri')== "célibataire") { echo 'checked'; } ?> >
                                    Célibataire
                                    </label>
                                </div>
                                <div class="radio">
                                    <label>
                                    <input type="radio" name="situaMatri" id="optionsRadios2" value="marié (é)" <?php if(old('situaMatri')== "marié (é)") { echo 'checked'; } ?> >
                                    Marié (é)
                                    </label>
                                </div>
                                <div class="radio">
                                    <label>
                                    <input type="radio" name="situaMatri" id="optionsRadios2" value="divorcé (é)" <?php if(old('situaMatri')== "divorcé (é)") { echo 'checked'; } ?>>
                                    Divorcé (e)
                                    </label>
                                </div>
                                <div class="radio">
                                    <label>
                                    <input type="radio" name="situaMatri" id="optionsRadios2" value="veuf (ve)" <?php if(old('situaMatri')== "veuf (ve)") { echo 'checked'; } ?> >
                                    Veuf (ve)
                                    </label>
                                </div>
                                <!-- {!! $errors->first('situaMatri', '<span class="error text-error">:message</span>') !!} -->
                            </div>

                            <div class="form-group">
                                <label>Matricule: (*)</label>
                                <input type="text" class="form-control" name="matricule" value="{{ old('matricule') }}" placeholder="Saisir Matricule...">
                                <!-- {!! $errors->first('matricule', '<span class="error text-error">:message</span>') !!} -->
                            </div>
                            <div class="form-group">
                                <label>Diplôme de recrutement: (*)</label>
                                <select class="form-control" id="niveauRecru" name="niveauRecru">
                                    <option value="" selected disabled>Sélectionner le diplôme de recrutement</option>
                                    @foreach (diplomes() as $diplome)
                                        <option {{ old('niveauRecru') == $diplome ? 'selected' : '' }}  value="{{$diplome}}">{{$diplome}}</option>
                                    @endforeach
                                </select>
                                {!! $errors->first('niveauRecru', '<span class="error text-error">:message</span>') !!}
                            </div>
                            <div class="form-group" id="diplomeRecruteAutre" style="display:none;">
                             
                                <div class="form-group">
                                    <div class="form-group">
                                        <textarea id="diplomeRecruteAutre" placeholder="Saisir autre diplôme obtenu" class="form-control" name="diplomeRecruteAutre" rows="3">{{ old('diplomeRecruteAutre') }}</textarea>
                                    </div>
                                </div>
                                
                            </div>
                            <div class="form-group">
                                <label>Diplôme obtenu avant ou après le recrutement: </label>
                                <select class="form-control" id="diplomeObtenu" name="diplomeObtenu">
                                    <option value="" selected disabled>Sélectionner le diplôme de recrutement</option>
                                    @foreach (diplomes() as $diplome)
                                        <option {{ old('diplomeObtenu') == $diplome ? 'selected' : '' }} value="{{$diplome}}">{{$diplome}}</option>
                                    @endforeach
                                </select>
                                {!! $errors->first('diplomeObtenu', '<span class="error text-error">:message</span>') !!}                            </div>
                            <div class="form-group" id="diplomeObtenuAutre" style="display:none;">
                                <div class="form-group">
                                    <div class="form-group">
                                        <textarea id="diplomeObtenuAutre" placeholder="Saisir autre diplôme obtenu" class="form-control" name="diplomeObtenuAutre" rows="3">{{ old('diplomeObtenuAutre') }}</textarea>
                                    </div>
                                </div>
                                
                            </div>
                            <div class="form-group">
                                <label>Niveau d'étude:</label>
                                <input type="text" class="form-control" name="niveauEtude" value="{{ old('niveauEtude') }}" placeholder="Saisir le niveau d'étude ...">
                                {!! $errors->first('niveauEtude', '<span class="error text-error">:message</span>') !!}
                            </div><br><br><br><br><br><br><br><br><br><br><br><br><br>
                        </div>
                        

                    </div>
                </div>

                <div class="col-md-6">
                    <div class="box box-primary">
                        <div class="box-header with-border">
                            <h3 class="box-title"> Les données administratives de l'agent</h3>
                        </div>
                        <div class="box-body">

                            <div class="form-group">
                                <label>Date d’Intégration/Engagement: (*)</label>
                                <div class="input-group date">
                                    <div class="input-group-addon">
                                    <i class="fa fa-calendar"></i>
                                    </div>
                                    <input name="dateIntegration" value="{{ old('dateIntegration') }}" class="form-control pull-right datepicker" placeholder='dd-mm-yyyy'>
                                </div>
                                <!-- {!! $errors->first('dateIntegration', '<span class="error text-error">:message</span>') !!} -->
                            </div>
                            <div class="form-group">
                                <label>Références de l'Acte d'Intégration/Engagement: </label>
                                <input type="text" class="form-control" name="refActeIntegration" value="{{ old('refActeIntegration') }}" placeholder="Saisir la Références de l'Acte d'Intégration/Engagement ...">
                                <!-- {!! $errors->first('refActeIntegration', '<span class="error text-error">:message</span>') !!} -->
                            </div> 
                            <div class="form-group">
                                <label>Date de titularisation:</label>
                                <div class="input-group date">
                                    <div class="input-group-addon">
                                    <i class="fa fa-calendar"></i>
                                    </div>
                                    <input name="dateTitularisation" value="{{ old('dateTitularisation') }}" class="form-control pull-right datepicker" placeholder='dd-mm-yyyy'>
                                </div>
                                <!-- {!! $errors->first('dateTitularisation', '<span class="error text-error">:message</span>') !!} -->
                            </div>
                            <div class="form-group">
                                <label>Références de l'Acte de Titularisation:</label>
                                <input type="text" class="form-control" name="refActTitularisation" value="{{ old('refActTitularisation') }}" placeholder="Saisir la Références de l'Acte de Titularisation ...">
                                <!-- {!! $errors->first('refActTitularisation', '<span class="error text-error">:message</span>') !!} -->
                            </div>                          
                            <div class="form-group">
                                <label>Date de prise de service au niveau de la CT (le 1er certificat de prise de service ):</label>
                                <div class="input-group date">
                                    <div class="input-group-addon">
                                    <i class="fa fa-calendar"></i>
                                    </div>
                                    <input name="dateService" value="{{ old('dateService') }}" class="form-control pull-right datepicker" placeholder='dd-mm-yyyy'>
                                </div>
                                <!-- {!! $errors->first('dateService', '<span class="error text-error">:message</span>') !!} -->
                            </div>
                            <div class="form-group">
                                <label>Date probable de départ à la retraite:</label>
                                <div class="input-group date">
                                    <div class="input-group-addon">
                                    <i class="fa fa-calendar"></i>
                                    </div>
                                    <input name="dateProbDepart" value="{{ old('dateProbDepart') }}" class="form-control pull-right datepickerAfterTodays" placeholder='dd-mm-yyyy'>
                                </div>
                                <!-- {!! $errors->first('dateProbDepart', '<span class="error text-error">:message</span>') !!} -->
                            </div>
                            <div class="form-group">
                                <label>Emploi: (*)</label>
                                <input type="text" class="form-control" name="emploi" value="{{ old('emploi') }}" placeholder="Saisir emploi...">
                                <!-- {!! $errors->first('emploi', '<span class="error text-error">:message</span>') !!} -->
                            </div>
                            <div class="form-group">
                                <label>Cadre des fonctionnaires:</label>
                                <input type="text" class="form-control" name="cadreFonctionnaire" value="{{ old('cadreFonctionnaire') }}" placeholder="Saisir Cadre des fonctionnaires...">
                                {!! $errors->first('cadreFonctionnaire', '<span class="error text-error">:message</span>') !!}
                            </div>
                            <div class="form-group">
                                <label>Fonction: (*)</label>
                                <input type="text" class="form-control" name="fonction" value="{{ old('fonction') }}" placeholder="Saisir fonction...">
                                {!! $errors->first('fonction', '<span class="error text-error">:message</span>') !!}
                            </div>
                            <div class="form-group">
                                <label id="statut" >Statut: (*)</label>
                                <select class="form-control" id="statut" name="statut">
                                    <option value="" selected disabled>Sélectionner le Statut</option>
                                    @foreach (statuts() as $statut)
                                        <option {{ old('statut') == $statut ? 'selected' : '' }} value="{{$statut}}">{{$statut}}</option>
                                    @endforeach
                                </select>
                                {!! $errors->first('statut', '<span class="error text-error">:message</span>') !!}
                            </div>
                            <div class="form-group" id="autre" style="display:none;">
                                <div class="form-group">
                                    <textarea id="statutAutres" placeholder="Saisir autre statut" class="form-control" name="statut_autre" rows="3">{{ old('statutAutres') }}</textarea>
                                </div>
                                {!! $errors->first('statut_autres', '<span class="error text-error">:message</span>') !!}
                                
                            </div>
                            <div class="form-group">
                                <label>Catégorie: (*)</label>
                                <select class="form-control" id="categorie" name="categorie">
                                    <option value="" selected disabled>Sélectionner la catégorie</option>
                                    @foreach (categories() as $categorie)
                                    <option {{ old('categorie') == $categorie ? 'selected' : '' }} value="{{$categorie}}">{{ $categorie}}</option>
                                    @endforeach
                                </select>
                                {!! $errors->first('categorie', '<span class="error text-error">:message</span>') !!}
                            </div>
                            <div class="form-group">
                                <label>Echelle:</label>
                                <select class="form-control" id="echelle" name="echelle">
                                    <option value="" selected disabled>Sélectionner l'echelle</option>
                                    @foreach (echelles() as $echelle)
                                    <option {{ old('echelle') == $echelle ? 'selected' : '' }} value="{{$echelle}}">{{$echelle}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Classe:</label>
                                <select class="form-control" id="classe" name="classe">
                                    <option value="" selected disabled>Sélectionner la classe</option>
                                    @foreach (classes() as $classe)
                                    <option {{ old('classe') == $classe ? 'selected' : '' }} value="{{$classe}}">{{$classe}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label id="echelon" >Echelon: (*)</label>
                                <select class="form-control" id="echelon" name="echelon">
                                    <option value="" selected disabled>Sélectionner l'échelon </option>
                                    <option value="Néant">Néant </option>
                                    @for($echelon = 1; $echelon <= 20; $echelon++ ) 
                                    <option {{ old('echelon') == $echelon ? 'selected' : '' }} value="{{$echelon}}">{{$echelon}}</option>
                                    @endfor
                                </select>
                                {!! $errors->first('echelon', '<span class="error text-error">:message</span>') !!}
                            </div>
                            <div class="form-group">
                                <label id="formInit" >Formation initiale: (*)</label>
                                <select class="form-control" id="formInit" name="formInit">
                                    <option value="" selected disabled>Sélectionner </option>
                                    <option {{ old('formInit') == 'Oui' ? 'selected' : '' }} value="Oui" >Oui</option>
                                    <option {{ old('formInit') == 'Non' ? 'selected' : '' }} value="Non" >Non</option>
                                </select>
                                {!! $errors->first('formInit', '<span class="error text-error">:message</span>') !!}
                            </div>
                            <div class="form-group" id="diplomeFormation" style="display:none;">
                                <label id="diplomeFormation" >Diplôme obtenu à l'issue de la formation initiale: (*)</label>
                                <input type="text" class="form-control" name="diplomeFormation" value="{{ old('diplomeFormation') }}" placeholder="Saisir le diplôme obtenu à l'issue de la formation initiale...">
                            </div>
                            <div class="form-group">
                                <label id="position" >Position dans la collectivité: (*)</label>
                                <select class="form-control" id="position" name="position">
                                    <option value="" selected disabled>Sélectionner la Position </option>
                                    @foreach (positions() as $position)
                                    <option {{ old('position') == $position ? 'selected' : '' }} value="{{$position}}">{{$position}}</option>
                                    @endforeach
                                </select>
                                {!! $errors->first('position', '<span class="error text-error">:message</span>') !!}
                            </div>
                            <div class="form-group" id="activite" style="display:none;">
                                <label id="sousActivite" >Etat d'activité: (*)</label>
                                <select class="form-control" id="sousActivite" name="sousActivite">
                                    <option value="" selected disabled>Sélectionner la Position </option>
                                    @foreach (sousActivites() as $sousActivite)
                                    <option {{ old('sousActivite') == $sousActivite ? 'selected' : '' }} value="{{$sousActivite}}">{{$sousActivite}}</option>
                                    @endforeach
                                </select>
                                {!! $errors->first('position', '<span class="error text-error">:message</span>') !!}
                            </div>
                            <div class="form-group" id="autres" style="display:none;">
                               
                                <!-- {!! $errors->first('position', '<span class="error text-error">:message</span>') !!} -->
                                <div class="form-group">
                                    <div class="form-group">
                                        <textarea id="statutAutres" placeholder="Saisir autre statut" class="form-control" name="position_autre" rows="3">{{ old('statutAutres') }}</textarea>
                                    </div>
                                    <!-- {!! $errors->first('statut_autres', '<span class="error text-error">:message</span>') !!} -->
                                </div>
                            </div>
                            <div class="form-group">
                                
                                <label id="situationParti" >Situation particulière: </label>
                                <select class="form-control" id="situationParti" name="situationParti">
                                    <option value="" selected disabled>Sélectionner la Position </option>
                                    @foreach (situationParticuliaires() as $situationParticuliaire)
                                    <option {{ old('situationParti') == $situationParticuliaire ? 'selected' : '' }} value="{{$situationParticuliaire}}">{{$situationParticuliaire}}</option>
                                    @endforeach
                                </select>
                                {!! $errors->first('situationParti', '<span class="error text-error">:message</span>') !!}
                            </div>
                            <div class="form-group" id="situa_part_autre" style="display:none;">
                                <div class="form-group">
                                    <textarea id="statutAutres" placeholder="Saisir autre situation particulière" class="form-control" name="situationPartiAutre" rows="3">{{ old('statutAutres') }}</textarea>
                                </div>
                                {!! $errors->first('statut_autres', '<span class="error text-error">:message</span>') !!}   
                            </div>
                            
                            
                        </div>
                        

                    </div>
                </div>

                

                

            </div>

            <div class="container">

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

<script>


    function zone(x){
        if (x==0) {
            document.getElementById('region').style.display='block';
            document.getElementById('commune').style.display='none';
        } else {
            document.getElementById('commune').style.display='block';
            document.getElementById('region').style.display='none';
            return;
        }
    }

    $(document).ready(function() {
        
        $('.datepicker').datepicker({
            format: 'dd-mm-yyyy',
            endDate: '1d'
        });

         $('.datepickerAfterTodays').datepicker({
            format: 'dd-mm-yyyy',
            startDate: '1d'
           
        });

        $('input[name="date"]').mask('00/00/0000');
        $('input[name="postal-code"]').mask('S0S 0S0');
        $('input[name="contactFonctionnaire"]').mask('+226 00 00 00 00');

        $('input[name="postal-code"]').focusout(function() {
        $('input[name="postal-code"]').val( this.value.toUpperCase() );
        });

        $('select[name="niveauRecru"]').on('change', function() {
            var position = $(this).val();
            if (position == 'Autres') {
                document.getElementById('diplomeRecruteAutre').style.display='block';
            } else {
                document.getElementById('diplomeRecruteAutre').style.display='none';
                return;
            }
        });

        $('select[name="diplomeObtenu"]').on('change', function() {
            var position = $(this).val();
            if (position == 'Autres') {
                document.getElementById('diplomeObtenuAutre').style.display='block';
            } else {
                document.getElementById('diplomeObtenuAutre').style.display='none';
                return;
            }
        });

        $('select[name="statut"]').on('change', function() {
            var position = $(this).val();
            if (position == 'Autres') {
                document.getElementById('autre').style.display='block';
            } else {
                document.getElementById('autre').style.display='none';
                return;
            }
        });

        $('select[name="formInit"]').on('change', function() {
            var position = $(this).val();
            if (position == 'Oui') {
                document.getElementById('diplomeFormation').style.display='block';
            } else {
                document.getElementById('diplomeFormation').style.display='none';
                return;
            }
        });

        $('select[name="position"]').on('change', function() {
            var position = $(this).val();
            
            switch (position) {
                case 'En activité':
                    document.getElementById('activite').style.display='block';
                    document.getElementById('autres').style.display='none';
                    break;
                case 'Autres':
                    document.getElementById('autres').style.display='block';
                    document.getElementById('activite').style.display='none';
                    break;
            
                default:
                    document.getElementById('autres').style.display='none';
                    document.getElementById('activite').style.display='none';
                    break;
            }
        });

        $('select[name="situationParti"]').on('change', function() {
            var position = $(this).val();
            if (position == 'Autres') {
                document.getElementById('situa_part_autre').style.display='block';
            } else {
                document.getElementById('situa_part_autre').style.display='none';
                return;
            }
        });

        $('select[name="regCommune"]').on('change', function() {
            var regionID = $(this).val();
            if(regionID) {
                $.ajax({
                    url:'/ListeProvinceAjax/'+regionID,
                    type:'GET',
                    dataType:'json',
                    success:function(reponse){
                        $('select[name="provinces"]').empty();
                        $('select[name="provinces"]').append('<option value="" selected disabled>Sélectionner la province </option>');
                        $.each(reponse, function(key, value) {
                            $('select[name="provinces"]').append('<option value="'+ value.id +'">'+ value.libelle +'</option>');
                        });
                    }
                })
            }else{
                $('select[name="provinces"]').empty();
            }
        });

        $('select[name="provinces"]').on('change', function() {
            var provinceID = $(this).val();
            if(provinceID) {
                $.ajax({
                    url:'/ListeCommuneAjax/'+provinceID,
                    type:'GET',
                    dataType:'json',
                    success:function(reponse){
                        $('select[name="collectivite"]').empty();
                        $('select[name="collectivite"]').append('<option value="" selected disabled>Sélectionner la commune</option>');
                        $.each(reponse, function(key, value) {
                            $('select[name="collectivite"]').append('<option value="'+ value.id +'">'+ value.libelle +'</option>');
                        });

                    }
                })
            }else{
                $('select[name="provinces"]').empty();
            }
        });
        

    });
    
</script>

@endpush
