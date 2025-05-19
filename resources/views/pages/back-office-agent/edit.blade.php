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
            @switch($detailAgent->rattachement_type_id)
                @case(1)
                    <li class="active"><i class="fa fa-dashboard"></i> Dashbord</li>
                    <li class="active"> <b><strong><span style="color:red;">Région</span>/ <i class="fa fa-file-text-o"></i> Editer information agent</strong></b></li>
                    @break
                @case(2)
                    <li class="active"><i class="fa fa-dashboard"></i> Dashbord</li>
                    <li class="active"> <b><strong><span style="color:red;">Commune</span>/ <i class="fa fa-file-text-o"></i> Editer information agent</strong></b></li>
                    @break
                @default

            @endswitch
        </ol>
    </section>
    <section class="content">
        @include('partials._title')

        <form action="{{route('agent.update', $detailAgent)}}" method="post">
            @csrf
            <input name="_method" type="hidden" value="PATCH">

            @if ($detailAgent->rattachement_type_id === 1)
                <div class="box box-primary"  id="region">
                    <div class="box-header with-border">
                        <h3 class="box-title">Région</h3>
                    </div>
                    <div class="box-body" >
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Région :</label>
                                <select class="form-control" id="region" name="region" >
                                    @foreach (regions() as $listeRegions)
                                        <option value="{{$listeRegions->id}}" @if ($listeRegions->libelle == $region->libelle) {{'selected'}} @endif> {{$listeRegions->libelle}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            @else
            <div class="box box-primary"  id="commune">
                    <div class="box-header with-border">
                        <h3 class="box-title">Commune</h3>
                    </div>
                    <div class="box-body" >
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Région :</label>
                                <select class="form-control" id="regCommune" name="regCommune">
                                    @foreach (regions() as $ListeRegions)
                                    <option value="{{$ListeRegions->id}}" @if ($ListeRegions->libelle == $region->libelle) {{'selected'}} @endif> {{$ListeRegions->libelle}}</option>
                                    @endforeach

                                </select>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Province :</label>
                                <select class="form-control" id="provinces" name="provinces">
                                    @foreach (provinces($region->id) as $provinces)
                                        <option value="" @if ($provinces->libelle == $province->libelle) {{'selected'}} @endif >{{$provinces->libelle}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Collectivité :</label>
                                <select class="form-control" id="collectivite" name="collectivite">
                                    <option value="" selected disabled>{{$collectivite->libelle}}</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            <div class="row">
                <div class="col-md-6">
                    <div class="box box-primary">
                        <div class="box-header with-border">
                            <h3 class="box-title">Information personnelle de l'agent</h3>
                        </div>
                        <div class="box-body">
                            <div class="form-group">
                                <label>Nom:</label>
                                <input type="text" class="form-control" name="nom" value="{{$detailAgent->nom }} " >
                            </div>
                            <div class="form-group">
                                <label>Prénom:</label>
                                <input type="text" class="form-control" name="prenom" value="{{$detailAgent->prenom }}" >
                            </div>
                            <div class="form-group">
                                <label>Contacts du fonctionnaire: (*)</label>
                                <input type="tel" class="form-control" name="contactFonctionnaire" value="{{$detailAgent->contact_fonctionnaire }}" placeholder="Saisir contacts du fonctionnaire ...">
                                {!! $errors->first('contactFonctionnaire', '<span class="error text-error">:message</span>') !!}
                            </div>
                            <div class="form-group">
                                <label>Date de naissance:</label>

                                <div class="input-group date">
                                    <div class="input-group-addon">
                                    <i class="fa fa-calendar"></i>
                                    </div>
                                    <input name="datenaiss" value="{{ formatDateInFrench($detailAgent->date_naiss) }}" class="form-control pull-right datepicker" placeholder='dd-mm-yyyy'>
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Lieu de naissance:</label>
                                <input type="text" class="form-control" name="lieunaiss" value="{{$detailAgent->lieu_naiss }}" >
                            </div>
                            <div class="form-group">
                                <label>Sexe:</label>
                                <div class="radio">
                                    <label>
                                        <input type="radio" name="sexe" id="optionsRadios1" value="Masculin" <?php if($detailAgent->sexe == 'Masculin') { echo 'checked="checked"' ; } ?> >
                                    Masculin
                                    </label>
                                </div>
                                <div class="radio">
                                    <label>
                                        <input type="radio" name="sexe" id="optionsRadios1" value="Feminin" <?php if($detailAgent->sexe == 'Feminin') { echo 'checked="checked"' ; } ?> >
                                    Feminin
                                    </label>
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Nationalité: (*)</label>
                                <input type="text" class="form-control" name="nationalite" value="{{$detailAgent->nationnalite }}" placeholder="Saisir la nationalité ...">
                                {!! $errors->first('nationalite', '<span class="error text-error">:message</span>') !!}
                            </div>
                            <div class="form-group">
                                <label>Situation matrimoniale:</label>
                                <div class="radio">
                                    <label>
                                    <input type="radio" name="situaMatri" id="optionsRadios1" value="Célibataire" <?php if($detailAgent->situation_matri == 'Célibataire') { echo 'checked="checked"' ; } ?> >
                                    Célibataire
                                    </label>
                                </div>
                                <div class="radio">
                                    <label>
                                    <input type="radio" name="situaMatri" id="optionsRadios2" value="Marié (é)" <?php if($detailAgent->situation_matri == 'Marié (é)') { echo 'checked="checked"' ; } ?> >
                                    Marié (é)
                                    </label>
                                </div>
                                <div class="radio">
                                    <label>
                                    <input type="radio" name="situaMatri" id="optionsRadios2" value="Divorcé (é)" <?php if($detailAgent->situation_matri == 'Divorcé (é)') { echo 'checked="checked"' ; } ?> >
                                    Divorcé (e)
                                    </label>
                                </div>
                                <div class="radio">
                                    <label>
                                    <input type="radio" name="situaMatri" id="optionsRadios2" value="Veuf (ve)" <?php if($detailAgent->situation_matri == 'Veuf (ve)') { echo 'checked="checked"' ; } ?> >
                                    Veuf (ve)
                                    </label>
                                </div>
                            </div>

                            <div class="form-group">
                                <label>Matricule:</label>
                                <input type="text" class="form-control" name="matricule" value="{{$detailAgent->matricule }}" >
                            </div>
                            
                            <div class="form-group">
                                <label>Diplome de recrutement: (*)</label>
                                <select class="form-control" id="niveauRecru" name="niveauRecru">
                                    <option value="{{$detailAgent->diplome_recrutement }}" {{'selected'}}>{{$detailAgent->diplome_recrutement }}</option>
                                    @foreach (diplomes() as $diplome)
                                    @if ( $diplome <> $detailAgent->diplome_recrutement)
                                    <option value="{{$diplome}}">{{$diplome}}</option>
                                    @endif
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group" id="diplomeRecruteAutre" style="display:none;">
                             
                                <div class="form-group">
                                    <div class="form-group">
                                        <textarea id="diplomeRecruteAutre" placeholder="Saisir autre diplôme de recrutement" class="form-control" name="diplomeRecruteAutre" rows="3">{{ old('diplomeRecruteAutre') }}</textarea>
                                    </div>
                                    {!! $errors->first('diplomeRecruteAutre', '<span class="error text-error">:message</span>') !!}
                                </div>
                                
                            </div>
                            <div class="form-group">
                                <label>Diplôme obtenu avant ou après le recrutement:</label>
                                <select class="form-control" id="diplomeObtenu" name="diplomeObtenu">
                                    <option value="{{$detailAgent->diplome_obtenu }}" {{'selected'}}>{{$detailAgent->diplome_obtenu }}</option>
                                    @foreach (diplomes() as $diplome)
                                    @if ( $diplome <> $detailAgent->diplome_obtenu)
                                    <option value="{{$diplome}}">{{$diplome}}</option>
                                    @endif
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group" id="diplomeObtenuAutre" style="display:none;">
                             
                                <div class="form-group">
                                    <div class="form-group">
                                        <textarea id="diplomeObtenuAutre" placeholder="Saisir autre diplôme obtenu" class="form-control" name="diplomeObtenuAutre" rows="3">{{ old('diplomeObtenuAutre') }}</textarea>
                                    </div>
                                    {!! $errors->first('diplomeObtenuAutre', '<span class="error text-error">:message</span>') !!}
                                </div>
                                
                            </div>

                            <div class="form-group">
                                <label>Niveau d'étude :</label>
                                <input type="text" class="form-control" name="niveauEtude" value="{{$detailAgent->niveau_etude }}" placeholder="Saisir le niveau d'étude ...">
                                {!! $errors->first('classe', '<span class="error text-error">:message</span>') !!}
                            </div><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>

                            
                        </div>
                    </div>
                </div>


                <div class="col-md-6">

                    <div class="box box-primary">
                        <div class="box-header with-border">
                            <h3 class="box-title">Les données administratives de l'agent</h3>
                        </div>
                        <div class="box-body">
                            <div class="form-group">
                                <label>Date d’Intégration/Engagement: (*)</label>
                                <div class="input-group date">
                                    <div class="input-group-addon">
                                    <i class="fa fa-calendar"></i>
                                    </div>
                                    <input name="dateIntegration" value="{{ formatDateInFrench($detailAgent->date_integration) }}" class="form-control pull-right datepicker" placeholder='dd-mm-yyyy' >
                                    {!! $errors->first('dateIntegration', '<span class="error text-error">:message</span>') !!}
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Références de l'Acte d'Intégration/Engagement: </label>
                                <input type="text" class="form-control" name="refActeIntegration" value="{{$detailAgent->ref_acte_integration }}" placeholder="Saisir la Références de l'Acte d'Intégration/Engagement ...">
                                {!! $errors->first('refActeIntegration', '<span class="error text-error">:message</span>') !!}
                            </div>
                            <div class="form-group">
                                <label>Date de titularisation:</label>
                                <div class="input-group date">
                                    <div class="input-group-addon">
                                    <i class="fa fa-calendar"></i>
                                    </div>
                                    <input name="dateTitularisation" value="{{ formatDateInFrench($detailAgent->date_titularisation) }}" class="form-control pull-right datepicker" placeholder='dd-mm-yyyy'>
                                    {!! $errors->first('dateTitularisation', '<span class="error text-error">:message</span>') !!}
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Références de l'Acte de Titularisation:</label>
                                <input type="text" class="form-control" name="refActTitularisation" value="{{$detailAgent->ref_acte_titularisation }}" >
                                {!! $errors->first('refActTitularisation', '<span class="error text-error">:message</span>') !!}
                            </div>
                            <div class="form-group">
                                <label>Date de prise de service au niveau de la CT (le 1er certificat de prise de service ):</label>
                                <div class="input-group date">
                                    <div class="input-group-addon">
                                    <i class="fa fa-calendar"></i>
                                    </div>
                                    <input name="dateService" value="{{ formatDateInFrench($detailAgent->date_service) }}" class="form-control pull-right datepicker" placeholder='dd-mm-yyyy'>
                                    {!! $errors->first('dateService', '<span class="error text-error">:message</span>') !!}
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Date probable de départ à la retraite:</label>
                                <div class="input-group date">
                                    <div class="input-group-addon">
                                    <i class="fa fa-calendar"></i>
                                    </div>
                                    <input name="dateProbDepart" value="{{ formatDateInFrench($detailAgent->date_probable_depart) }}" class="form-control pull-right datepickerAfterTodays"placeholder='dd-mm-yyyy' >
                                    {!! $errors->first('dateProbDepart', '<span class="error text-error">:message</span>') !!}
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Emploi:</label>
                                <input type="text" class="form-control" name="emploi" value="{{$detailAgent->emploi }}" >
                            </div>
                            <div class="form-group">
                                <label>Cadre des fonctionnaires:</label>
                                <input type="text" class="form-control" name="cadreFonctionnaire" value="{{$detailAgent->cadre_fonctionnaire }}" placeholder="Saisir Cadre des fonctionnaires...">
                                {!! $errors->first('cadreFonctionnaire', '<span class="error text-error">:message</span>') !!}
                            </div>
                            <div class="form-group">
                                <label>Fonction:</label>
                                <input type="text" class="form-control" name="fonction" value="{{$detailAgent->fonction }}" >
                            </div>
                            <div class="form-group">
                                <label id="statut" >Statut: (*)</label>
                                <select class="form-control" id="statut" name="statut">
                                    <option value="{{$detailAgent->statut }}" {{'selected'}}>{{$detailAgent->statut }}</option>
                                    @foreach (statuts() as $statut)
                                    @if ($statut <> $detailAgent->statut )
                                    <option value="{{$statut}}">{{$statut}}</option>
                                    @endif
                                    @endforeach
                                </select>
                                {!! $errors->first('statut', '<span class="error text-error">:message</span>') !!}
                            </div>
                            <div class="form-group" id="autre" style="display:none;">
                             
                                <div class="form-group">
                                    <div class="form-group">
                                        <textarea id="statutAutres" placeholder="Saisir autre statut" class="form-control" name="statut_autre" rows="3">{{ old('statutAutres') }}</textarea>
                                    </div>
                                    {!! $errors->first('statut_autres', '<span class="error text-error">:message</span>') !!}
                                </div>
                            </div>

                            <div class="form-group">
                                <label>Catégorie:</label>
                                <select class="form-control" id="categorie" name="categorie">
                                    <option value="{{$detailAgent->categorie }}" {{'selected'}}>{{$detailAgent->categorie }}</option>
                                    @foreach (categories() as $categorie)
                                    @if ( $categorie <> $detailAgent->categorie)
                                    <option value="{{$categorie}}">{{$categorie}}</option>
                                    @endif
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Echelle:</label>
                                <select class="form-control" id="echelle" name="echelle">
                                    <option value="{{$detailAgent->echelle }}" {{'selected'}}>{{$detailAgent->echelle }}</option>
                                    @foreach (echelles() as $echelle)
                                    @if ( $echelle <> $detailAgent->echelle)
                                    <option value="{{$echelle}}">{{$echelle}}</option>
                                    @endif
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Classe:</label>
                                <select class="form-control" id="classe" name="classe">
                                    <option value="{{$detailAgent->classe }}" {{'selected'}}>{{$detailAgent->classe }}</option>
                                    @foreach (classes() as $classe)
                                    @if ( $classe <> $detailAgent->classe)
                                    <option value="{{$classe}}">{{$classe}}</option>
                                    @endif
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label id="echelon" >Echelon: (*)</label>
                                <select class="form-control" id="echelon" name="echelon">
                                    <option value="" selected disabled>Sélectionner l'échelon </option>
                                    <option value="Néant">Néant </option>
                                    <option value="{{$detailAgent->echelon }}" {{'selected'}}>{{$detailAgent->echelon }}</option>
                                    @for($echelon = 1; $echelon <= 20; $echelon++ )
                                     @if ( $echelon <> $detailAgent->echelon)
                                    <option value="{{$echelon}}">{{$echelon}}</option>
                                    @endif 
                                    @endfor
                                </select>
                                {!! $errors->first('echelon', '<span class="error text-error">:message</span>') !!}
                            </div>
                            <div class="form-group">
                                <label id="formInit" >Formation initiale: (*)</label>
                                <select class="form-control" id="formInit" name="formInit">
                                    <option value="" selected disabled>Sélectionner </option>
                                    <option value="{{$detailAgent->format_initiale }}" {{'selected'}}>{{$detailAgent->format_initiale }}</option>
                                    @if ($detailAgent->format_initiale === 'Oui')
                                    <option value="Non" >Non</option>
                                    @else
                                    <option value="Oui" >Oui</option>
                                    @endif
                                </select>
                                {!! $errors->first('formInit', '<span class="error text-error">:message</span>') !!}
                            </div>
                            <div class="form-group" id="diplomeFormation" style="display:none;">
                                <label id="diplomeFormation" >Diplôme obtenu à l'issue de la formation initiale: (*)</label>
                                <input type="text" class="form-control" name="diplomeFormation" value="{{ old('diplomeFormation') }}" placeholder="Saisir le diplôme obtenu à l'issue de la formation initiale...">
                            </div>
                             @if ($detailAgent->format_initiale == 'Oui')
                            <div class="form-group" id="diplomeFormation">
                                <label id="diplomeFormation" >Diplôme obtenu à l'issue de la formation initiale: (*)</label>
                                <input type="text" class="form-control" name="diplomeFormation" value="{{$detailAgent->diplome_formation }}" placeholder="Saisir le diplôme obtenu à l'issue de la formation initiale...">
                            </div>
                            @endif 

                            <div class="form-group">
                                <label id="position" >Position dans la collectivité: (*)</label>
                                <select class="form-control" id="position" name="position">
                                    <option value="{{$detailAgent->position_collectivite }}" {{'selected'}}>{{$detailAgent->position_collectivite }}</option>
                                    @foreach (positions() as $position)
                                    @if ( $position <> $detailAgent->position_collectivite)
                                    <option value="{{$position}}">{{$position}}</option>
                                    @endif
                                    @endforeach
                                </select>
                                {!! $errors->first('position', '<span class="error text-error">:message</span>') !!}
                            </div>
                            <div class="form-group" id="autres" style="display:none;">
                               
                                {!! $errors->first('position', '<span class="error text-error">:message</span>') !!}
                                <div class="form-group">
                                    <div class="form-group">
                                        <textarea id="statutAutres" placeholder="Saisir autre statut" class="form-control" name="position_autre" rows="3">{{ old('statutAutres') }}</textarea>
                                    </div>
                                    {!! $errors->first('statut_autres', '<span class="error text-error">:message</span>') !!}
                                </div>
                            </div>
                            <div class="form-group" id="activite" style="display:none;">
                                <label id="sousActivite" >Etat d'activité: (*)</label>
                                <select class="form-control" id="sousActivite" name="sousActivite">
                                    <option value="{{$detailAgent->sous_activite }}" {{'selected'}}>{{$detailAgent->sous_activite }}</option>
                                    @foreach (sousActivites() as $sousActivite)
                                    @if ($sousActivite <> $detailAgent->sous_activite)
                                    <option value="{{$sousActivite}}">{{$sousActivite}}</option>
                                    @endif
                                    @endforeach
                                </select>
                                {!! $errors->first('position', '<span class="error text-error">:message</span>') !!}
                            </div>
                            <div class="form-group">
                                <label id="situationParti" >Situation particulière: </label>
                                <select class="form-control" id="situationParti" name="situationParti">
                                    <option value="{{$detailAgent->situa_particuliere }}" {{'selected'}}>{{$detailAgent->situa_particuliere }}</option>
                                    @foreach (situationParticuliaires() as $situationParticuliaire)
                                    @if ($situationParticuliaire <> $detailAgent->situa_particuliere)
                                    <option value="{{$situationParticuliaire}}">{{$situationParticuliaire}}</option>
                                    @endif
                                    @endforeach
                                </select>
                                {!! $errors->first('situationParti', '<span class="error text-error">:message</span>') !!}
                            </div>
                            <div class="form-group" id="situa_part_autre" style="display:none;">
                             
                                <div class="form-group">
                                    {{-- <label>Autres:</label> --}}
                                    <div class="form-group">
                                        <textarea id="statutAutres" placeholder="Saisir autre situation particulière" class="form-control" name="situationPartiAutre" rows="3">{{ old('statutAutres') }}</textarea>
                                    </div>
                                    {!! $errors->first('statut_autres', '<span class="error text-error">:message</span>') !!}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
            <div class="row">
                <div class="col-md-12">
                    <a href="{{URL::previous()}}" class="btn btn-danger btn-lg pull-left"><i class="fa fa-reply"></i> Retour</a>
                    <button type="submit" class="btn btn-info btn-lg pull-right"><i class="fa fa-refresh"></i> Mettre à jour</button>
                </div>
            </div>

        </form>

    </section>
    </div>


@endsection
@push('scripts.footer')

<script>
    $(document).ready(function() {

         $('.datepicker').datepicker({
            format: 'dd-mm-yyyy',
            endDate: '1d'
        });

         $('.datepickerAfterTodays').datepicker({
            format: 'dd-mm-yyyy',
            startDate: '1d'
           
        });


        $('select[name="niveauRecru"]').on('change', function() {
            var position = $(this).val();
            if (position == 'AUTRES') {
                document.getElementById('diplomeRecruteAutre').style.display='block';
            } else {
                document.getElementById('diplomeRecruteAutre').style.display='none';
                return;
            }
        });

        $('select[name="diplomeObtenu"]').on('change', function() {
            var position = $(this).val();
            if (position == 'AUTRES') {
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

        $('select[name="position"]').attr('src', function() {
            var position = $(this).val();
            if (position == 'En activité') {
                document.getElementById('activite').style.display='block';
            } else {
                document.getElementById('activite').style.display='none';
                return;
            }
        });

        $('select[name="position"]').on('change', function() {
            var position = $(this).val();
            if (position == 'En activité') {
                document.getElementById('activite').style.display='block';
            } else {
                document.getElementById('activite').style.display='none';
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
                        $('select[name="collectivite"]').append('<option value="" selected disabled>Sélectionnez la commune</option>');
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
