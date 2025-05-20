@extends('layouts.admin', ['titrePage' => 'DGTPT'])
@section('content')
    @include('partials.back-admin._nav')
    {{-- -----End menu--------- --}}
    <div class="content-wrapper">
    <section class="content-header">
        <h1>
        Direction générale des Transmissions et de l'informatique
        </h1>
        <ol class="breadcrumb">
        <li class="active"><i class="fa fa-user-plus"></i> <b><strong>Nouvel agent</strong></b></li>
        </ol>
    </section>
    <section class="content">
        <div class="callout callout-info">
            <h4>Gestion du personnel et des dossiers individuel</h4>
        </div>

        <div id="app">
                {!! $chart->container() !!}
            </div>
            <script src="https://unpkg.com/vue"></script>
            <script>
                var app = new Vue({
                    el: '#app',
                });
            </script>
            <script src=https://cdnjs.cloudflare.com/ajax/libs/echarts/4.0.2/echarts-en.min.js charset=utf-8></script>
            {!! $chart->script() !!}


        <form action="{{route('agent.store')}}" method="post">
            @csrf
            <div class="row">
                <div class="col-md-6">
                    <div class="box box-primary">
                        <div class="box-header with-border">
                            <h3 class="box-title">Information personnelle de l'agent</h3>
                        </div>
                        <div class="box-body">
                            <div class="form-group">
                                <label>Nom:</label>
                                <input type="text" class="form-control" name="nom" placeholder="Saisir nom ...">
                            </div>
                            <div class="form-group">
                                <label>Prénom:</label>
                                <input type="text" class="form-control" name="prenom" placeholder="Saisir prénom ...">
                            </div>
                            <div class="form-group">
                                <label>Lieu de naissance:</label>
                                <input type="text" class="form-control" name="lieunaiss" placeholder="Saisir lieu de naissance...">
                            </div>

                            <div class="form-group">
                                <label>Date de naissance:</label>

                                <div class="input-group date">
                                    <div class="input-group-addon">
                                    <i class="fa fa-calendar"></i>
                                    </div>
                                    <input type="date" name="datenaiss" class="form-control pull-right" id="datepicker">
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Sexe:</label>
                                <div class="radio">
                                    <label>
                                    <input type="radio" name="sexe" id="optionsRadios1" value="masculin" checked>
                                    Masculin
                                    </label>
                                </div>
                                <div class="radio">
                                    <label>
                                    <input type="radio" name="sexe" id="optionsRadios2" value="feminin">
                                    Feminin
                                    </label>
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Situation matrimoniale:</label>
                                <div class="radio">
                                    <label>
                                    <input type="radio" name="situaMatri" id="optionsRadios1" value="célibataire" checked>
                                    Célibataire
                                    </label>
                                </div>
                                <div class="radio">
                                    <label>
                                    <input type="radio" name="situaMatri" id="optionsRadios2" value="marié (é)">
                                    Marié (é)
                                    </label>
                                </div>
                                <div class="radio">
                                    <label>
                                    <input type="radio" name="situaMatri" id="optionsRadios2" value="divorcé (é)">
                                    Divorcé (e)
                                    </label>
                                </div>
                                <div class="radio">
                                    <label>
                                    <input type="radio" name="situaMatri" id="optionsRadios2" value="veuf (ve)">
                                    Veuf (ve)
                                    </label>
                                </div>
                            </div>

                            <div class="form-group">
                                <label>Matricule:</label>
                                <input type="text" class="form-control" name="matricule" placeholder="Saisir Matricule...">
                            </div>
                            <div class="form-group">
                                <label>Niveau de recrutement</label>
                                <input type="text" class="form-control" name="niveauRecru" placeholder="Saisir niveau de recrutement...">
                            </div>
                            <div class="form-group">
                                <label>Date d'engagement:</label>

                                <div class="input-group date">
                                    <div class="input-group-addon">
                                    <i class="fa fa-calendar"></i>
                                    </div>
                                    <input type="date" name="dateEngagmt" class="form-control pull-right" id="datepicker">
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Emploi</label>
                                <input type="text" class="form-control" name="emploi" placeholder="Saisir emploi...">
                            </div>
                            <div class="form-group">
                                <label>Fonction</label>
                                <input type="text" class="form-control" name="fonction" placeholder="Saisir fonction...">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">

                    <div class="box box-primary">
                        <div class="box-header with-border">
                            <h3 class="box-title">Statut de l'agent</h3>
                        </div>
                        <div class="box-body">
                            <div class="form-group">
                                <label>Statut:</label>
                                <input type="text" class="form-control" name="statut" placeholder="Saisir statut...">
                            </div>

                        </div>
                        <div class="box box-danger box-header with-border">
                            <h3 class="box-title">Classification catégorielle</h3>
                        </div>
                        <div class="box-body">
                            <div class="form-group">
                                <label>Catégorie:</label>
                                <input type="text" class="form-control" name="categorie" placeholder="Saisir catégorie...">
                            </div>
                            <div class="form-group">
                                <label>Echelle:</label>
                                <input type="text" class="form-control" name="echelle" placeholder="Saisir echelle...">
                            </div>
                            <div class="form-group">
                                <label>Classe:</label>
                                <input type="text" class="form-control" name="classe" placeholder="Saisir classe...">
                            </div>
                            <div class="form-group">
                                <label>Echelon:</label>
                                <input type="text" class="form-control" name="echelon" placeholder="Saisir echelon...">
                            </div>
                        </div>
                        <div class="box box-danger box-header with-border">
                            <h3 class="box-title">Position dans la collectivité</h3>
                        </div>
                        <div class="box-body">
                            <div class="form-group">
                                <label>Recruté par la CT:</label>
                                <input type="text" class="form-control" name="recruteCT" placeholder="Saisir recruté par la CT...">
                            </div>
                            <div class="form-group">
                                <label>Agent ex province rédéployé dans la CT:</label>
                                <input type="text" class="form-control" name="agentCT" placeholder="Saisir agent ex province rédéployé dans la CT...">
                            </div>
                            <div class="form-group">
                                <label>Agents formés dans la IRA:</label>
                                <input type="text" class="form-control" name="agentForme" placeholder="Saisir agents formés dans la IRA...">
                            </div>
                            <div class="form-group">
                                <label>Mis à disposition:</label>
                                <input type="text" class="form-control" name="agentDisposition" placeholder="Saisir mis à disposion...">
                            </div>
                            <div class="form-group">
                                <label>Position de détachement:</label>
                                <input type="text" class="form-control" name="agentDetachmt" placeholder="Saisir position de détachement...">
                            </div>
                            <div class="form-group">
                                <label>Autre situation:</label>
                                <input type="text" class="form-control" name="agentAutrePosition" placeholder="Saisir autre situation...">
                            </div>
                        </div>

                    </div>

                </div>

            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="box-footer">
                        <button type="submit" class="btn btn-info btn-lg pull-right">Valider</button>
                    </div>
                </div>
            </div>

        </form>

    </section>
    </div>
@endsection
