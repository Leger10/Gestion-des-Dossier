@extends('layouts.admin', ['titrePage' => 'DGTI'])
@section('content')
    @include('partials.back-admin._nav')
    <div class="content-wrapper">

    <section class="content-header">
        <h1>
              Direction générale des transmissions et de l'informatique
        </h1>
        <ol class="breadcrumb">
            @switch($detailAgent->rattachement_type_id)
                @case(1)
                    <li class="active"><i class="fa fa-dashboard"></i> Dashbord</li>
                    <li class="active"> <b><strong><span style="color:red;">Direction</span>/ <i class="fa fa-file-text-o"></i> Information personnelle de l'agent</strong></b></li>
                    @break
                @case(2)
                    <li class="active"><i class="fa fa-dashboard"></i> Dashbord</li>
                    <li class="active"> <b><strong><span style="color:red;">Service</span>/ <i class="fa fa-file-text-o"></i> Information personnelle de l'agent</strong></b></li>
                    @break
                @default
            @endswitch
        </ol>
    </section>
    <section class="content">
        @include('partials._title')
        @include('partials._notification')
        <div class="row">
            <div class="col-md-6 pull-right">
                @if (Auth::user()->is_admin == 1)
                    @if (!$detailAgent->trashed())
                    @include('partials._modalDelete')
                    @endif
                @endif
            </div>
        </div><br>
        <div class="row">

            <div class="col-xs-12 col-md-6 col-lg-6">
                <div class="card text-center">
                    <div class="card-block">

                        <div class="box box-primary">
                            <div class="box-header with-border">
                                <h3 class="box-title">Information personnelle de l'agent :</h3>
                            </div>
                        </div>
                        <div class="box-body">
                            <dl >
                                <dt>Nom entier :</dt>  <dd> {{$detailAgent->nom }} {{$detailAgent->prenom }}</dd>
                                <dt>Née :</dt>  <dd> {{ formatDateInFrench($detailAgent->date_naiss) }} {{$detailAgent->lieu_naiss }} </dd>
                                <dt>Contact :</dt>  <dd> {{$detailAgent->contact_fonctionnaire }} </dd>
                                <dt>Sexe :</dt>  <dd> {{ ucwords($detailAgent->sexe) }} </dd>
                                <dt>Nationalité :</dt>  <dd> {{ucwords($detailAgent->nationnalite) }} </dd>
                                <dt title="Situation matrimoniale">Situation matrimoniale :</dt>  <dd> {{ ucwords($detailAgent->situation_matri) }} </dd>
                                <dt>Matricule :</dt>  <dd> {{$detailAgent->matricule }} </dd>
                                <dt title="Diplôme de recrutement">Diplôme de recrutement :</dt>  <dd> {{$detailAgent->diplome_recrutement }} </dd>
                                <dt title="Diplôme obtenu avant ou après le recrutement">Diplôme obtenu avant ou après le recrutement :</dt>  <dd> {{$detailAgent->diplome_obtenu }} </dd>
                                <dt>Niveau d'étude :</dt>  <dd> {{$detailAgent->niveau_etude }} </dd>
                                <dt>Date d'intégration :</dt>  <dd>{{formatDateInFrench($detailAgent->date_integration)}}</dd>
                                <dt title="Références de l'acte intégration">Références de l'acte intégration :</dt>  <dd> {{$detailAgent->ref_acte_integration }} </dd>
                                <dt title="Date de titularisation">Date de titularisation :</dt>  <dd>{{formatDateInFrench($detailAgent->date_titularisation)}} </dd>
                            </dl>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xs-12 col-md-6 col-lg-6">
                <div class="card text-center">
                    <div class="card-block">

                        <div class="box box-primary">
                            <div class="box-header with-border">
                                    <h3 class="box-title">Position dans l'organisation</h3>
                            </div>
                        </div>
                        <div class="box-body">

                            <dl>
                                <dt title="Références de l'acte titularisation">Références de l'acte titularisation :</dt>  <dd> {{$detailAgent->ref_acte_titularisation }} </dd>
                                <dt title="Date de prise de service">Date de prise de service :</dt>  <dd>{{formatDateInFrench($detailAgent->date_service)}} </dd>
                                <dt title="Date probable de départ">Date probable de départ :</dt>  <dd> {{formatDateInFrench($detailAgent->date_probable_depart)}} </dd>
                                <dt>Emploi :</dt>  <dd> {{$detailAgent->emploi }} </dd>
                                <dt title="Cadre des fonctionnaires">Cadre des fonctionnaires :</dt>  <dd> {{$detailAgent->cadre_fonctionnaire }} </dd>
                                <dt>Fonction :</dt>  <dd> {{$detailAgent->fonction }} </dd>
                                <dt>Statut :</dt>  <dd> {{$detailAgent->statut }} </dd>
                                <dt>Formation initiale :</dt><dd> {{$detailAgent->format_initiale }}</dd>
                                 @if($detailAgent->format_initiale === 'Oui') 
                                    <dt title="Diplôme obtenu à l'issue de la formation initiale">Diplôme obtenu à l'issue de la formation initiale</dt><dd>{{$detailAgent->diplome_formation }}</dd>
                                @endif
                                <dt title="Position dans l'organisation">Position dans l'organisation :</dt>  <dd>{{$detailAgent->position_collectivite }}</dd>
                                @if ($detailAgent->sous_activite <> null)
                                <dt>Etat d'activité :</dt><dd>{{$detailAgent->sous_activite }}</dd>
                                @endif
                                <dt title="Situation particulière">Situation particulière :</dt><dd>{{$detailAgent->situa_particuliere }}</dd>
                            </dl>

                        </div>

                    </div>
                </div>
            </div>
        </div><br>

        <div class="row">

                <div class="col-xs-12 col-md-6 col-lg-6">
                    <div class="card text-center">
                        <div class="card-block">

                            <div class="box box-primary">
                                <div class="box-header with-border">
                                    <h3 class="box-title">Affectation organisationnelle</h3>
                                </div>
                            </div>
                            <div class="box-body">

                                <dl>
                                    @if ($detailAgent->rattachement_type_id == 1)
                                    @foreach ($zone as $localite)
                                        <dt>Direction :</dt>  <dd> {{$localite->libelle }} </dd>
                                        <dt> </dt><dd> <br></dd>
                                        <dt> </dt><dd> <br></dd>
                                        <dt> </dt><dd> <br></dd>
                                        <dt> </dt><dd> <br></dd>
                                    @endforeach
                                @else
                                    @foreach ($zone as $localite)
                                        <dt>Service :</dt>  <dd> {{$localite->libelle }} </dd>
                                        @if($localite->type_collectivite === 1)
                                        <dt>Type service :</dt><dd>Technique</dd>
                                        @else
                                        <dt>Type service :</dt><dd>Administratif</dd>
                                        @endif
                                         @if($localite->staut_type_collectivite === 2)
                                        <dt>Statut service :</dt><dd>Spécialisé</dd>
                                        @endif
                                        <dt> </dt><dd> <br></dd>
                                        <dt> </dt><dd> <br></dd>
                                    @endforeach
                                @endif
                                </dl>

                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xs-12 col-md-6 col-lg-6">
                    <div class="card text-center">
                        <div class="card-block">
                            <div class="box box-primary box-header with-border">
                                <h3 class="box-title">Classification catégorielle</h3>
                            </div>
                            <div class="box-body">
                                <dl>
                                    <dt>Catégorie :</dt>  <dd> {{$detailAgent->categorie }} </dd>
                                    <dt>Echelle :</dt>  <dd>  {{$detailAgent->echelle}} </dd>
                                    <dt>Classe :</dt>  <dd>  {{$detailAgent->classe}} </dd>
                                    <dt>Echelon :</dt>  <dd> {{$detailAgent->echelon }} </dd>
                                </dl>
                            </div>
                        </div>
                    </div>
                </div>
                @if ($detailAgent->deleted_at <> null)
                <div class="col-xs-12 col-md-12 col-lg-12">
                        <div class="card text-center">
                            <div class="card-block">
                                <div class="box box-primary box-header with-border">
                                    <h3 class="box-title">Archivage</h3>
                                </div>
                                <div class="box-body">
                                    <dl>
                                        <dt>Type d'archivage :</dt>  <dd> {{$detailAgent->type_archivage }} </dd>
                                        <dt>Motif :</dt>  <dd>  {{$detailAgent->motif}} </dd>
                                    </dl>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            </div><br><br>
            <div class="row">
                <div class="col-md-12">
                    @if (!$detailAgent->trashed())
                    @if (Auth::user()->role <> 'Lecteur')
                    <a href="{{route('agent.edit', $detailAgent)}}" class="btn btn-info btn-lg pull-right"><i class="fa fa-edit"></i> Modifier</a>
                    @endif
                    @endif
                    <a href="{{URL::previous()}}" class="btn btn-danger btn-lg pull-left"><i class="fa fa-reply"></i> Retour</a>
                </div>
            </div>

    </section>
    </div>
@endsection