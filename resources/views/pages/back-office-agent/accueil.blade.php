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
            <li class="active"><i class="fa fa-dashboard"></i> <b><strong>Accueil</strong></b></li>
        </ol>
    </section>

    <section class="content">
        @include('partials._title')

        <div class="row">
            <div class="col-md-12">
                @include('partials._notification')
            </div>
            
            {{-- Statistiques Direction --}}
            <div class="col-md-6 col-sm-6 col-xs-12">
                <div class="box box-primary">
                    <div class="box-body box-profile">
                        <p class="text-muted text-center">Agents de la DGTI</p>
                        <ul class="list-group list-group-unbordered">
                            <li class="list-group-item">
                                <b>Nombre total des agents</b>
                                <a class="pull-right"><b>{{ $totalDirection }}</b></a>
                            </li>
                            <li class="list-group-item">
                                <b>Nombre total d'hommes</b>
                                <a class="pull-right"><b>{{ $directionHommes }}</b></a>
                            </li>
                            <li class="list-group-item">
                                <b>Nombre total de femmes</b>
                                <a class="pull-right"><b>{{ $directionFemmes }}</b></a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

            {{-- Statistiques Service --}}
            <div class="col-md-6 col-sm-6 col-xs-12">
                <div class="box box-primary">
                    <div class="box-body box-profile">
                        <p class="text-muted text-center">Agents Par Service</p>
                        <ul class="list-group list-group-unbordered">
                            <li class="list-group-item">
                                <b>Nombre Total des agents</b>
                                <a class="pull-right"><b>{{ $totalService }}</b></a>
                            </li>
                            <li class="list-group-item">
                                <b>Nombre total d'hommes</b>
                                <a class="pull-right"><b>{{ $serviceHommes }}</b></a>
                            </li>
                            <li class="list-group-item">
                                <b>Nombre total de femmes</b>
                                <a class="pull-right"><b>{{ $serviceFemmes }}</b></a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        {{-- Tableaux détaillés --}}
        <div class="row">
            {{-- Tableaux Direction --}}
            <div class="col-lg-6 col-sm-6">
                <div class="circle-tile">
                    <a href="#">
                        <div class="circle-tile-heading text-muted">
                            <h3>Directions</h3>
                        </div>
                    </a>
                    <div class="circle-tile-content dark-blue"></div>
                </div>
                
                {{-- Hommes Direction --}}
                <table class="table table-hover">
                    <thead>
                        <i class="fas fa-dice-d4 text-muted"><b>Homme</b></i>
                        <tr class="text-white tr-bg">
                            <th>Catégorie</th>
                            <th>I</th>
                            <th>II</th>
                            <th>III</th>
                            <th>Néant</th>
                            <th class="text-right">TOTAL</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php $positions = ['En activité', 'En détachement', 'En disponibilité', 'Mis à disposition', 'Autres']; @endphp
                        @foreach ($positions as $position)
                        <tr>
                            <td><b>{{ $position }}</b></td>
                            <td>{{ $directionAgents->where('sexe', 'Masculin')->where('categorie', 'I')->where('position_agents', $position)->count() }}</td>
                            <td>{{ $directionAgents->where('sexe', 'Masculin')->where('categorie', 'II')->where('position_agents', $position)->count() }}</td>
                            <td>{{ $directionAgents->where('sexe', 'Masculin')->where('categorie', 'III')->where('position_agents', $position)->count() }}</td>
                            <td>{{ $directionAgents->where('sexe', 'Masculin')->where('categorie', 'Néant')->where('position_agents', $position)->count() }}</td>
                            <td class="text-right"><b>{{ $directionAgents->where('sexe', 'Masculin')->where('position_agents', $position)->count() }}</b></td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                
                {{-- Femmes Direction --}}
                <table class="table table-hover">
                    <thead>
                        <i class="fas fa-dice-d4 text-muted"><b>Femme</b></i>
                        <tr class="text-white tr-bg">
                            <th>Catégorie</th>
                            <th>I</th>
                            <th>II</th>
                            <th>III</th>
                            <th>Néant</th>
                            <th class="text-right">TOTAL</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($positions as $position)
                        <tr>
                            <td><b>{{ $position }}</b></td>
                            <td>{{ $directionAgents->where('sexe', 'Feminin')->where('categorie', 'I')->where('position_agents', $position)->count() }}</td>
                            <td>{{ $directionAgents->where('sexe', 'Feminin')->where('categorie', 'II')->where('position_agents', $position)->count() }}</td>
                            <td>{{ $directionAgents->where('sexe', 'Feminin')->where('categorie', 'III')->where('position_agents', $position)->count() }}</td>
                            <td>{{ $directionAgents->where('sexe', 'Feminin')->where('categorie', 'Néant')->where('position_agents', $position)->count() }}</td>
                            <td class="text-right"><b>{{ $directionAgents->where('sexe', 'Feminin')->where('position_agents', $position)->count() }}</b></td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            {{-- Tableaux Service --}}
            <div class="col-lg-6 col-sm-6">
                <div class="circle-tile">
                    <a href="#">
                        <div class="circle-tile-commune text-muted">
                            <h3>Service</h3>
                        </div>
                    </a>
                    <div class="circle-tile-content dark-blue"></div>
                </div>
                
                {{-- Hommes Service --}}
                <table class="table table-hover">
                    <thead>
                        <i class="fas fa-dice-d4 text-muted"><b>Homme</b></i>
                        <tr class="text-white tr-bg">
                            <th>Catégorie</th>
                            <th>I</th>
                            <th>II</th>
                            <th>III</th>
                            <th>Néant</th>
                            <th class="text-right">TOTAL</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($positions as $position)
                        <tr>
                            <td><b>{{ $position }}</b></td>
                            <td>{{ $serviceAgents->where('sexe', 'Masculin')->where('categorie', 'I')->where('position_service', $position)->count() }}</td>
                            <td>{{ $serviceAgents->where('sexe', 'Masculin')->where('categorie', 'II')->where('position_service', $position)->count() }}</td>
                            <td>{{ $serviceAgents->where('sexe', 'Masculin')->where('categorie', 'III')->where('position_service', $position)->count() }}</td>
                            <td>{{ $serviceAgents->where('sexe', 'Masculin')->where('categorie', 'Néant')->where('position_service', $position)->count() }}</td>
                            <td class="text-right"><b>{{ $serviceAgents->where('sexe', 'Masculin')->where('position_service', $position)->count() }}</b></td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>

                {{-- Femmes Service --}}
                <table class="table table-hover">
                    <thead>
                        <i class="fas fa-dice-d4 text-muted"><b>Femme</b></i>
                        <tr class="text-white tr-bg">
                            <th>Catégorie</th>
                            <th>I</th>
                            <th>II</th>
                            <th>III</th>
                            <th>Néant</th>
                            <th class="text-right">TOTAL</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($positions as $position)
                        <tr>
                            <td><b>{{ $position }}</b></td>
                            <td>{{ $serviceAgents->where('sexe', 'Feminin')->where('categorie', 'I')->where('position_service', $position)->count() }}</td>
                            <td>{{ $serviceAgents->where('sexe', 'Feminin')->where('categorie', 'II')->where('position_service', $position)->count() }}</td>
                            <td>{{ $serviceAgents->where('sexe', 'Feminin')->where('categorie', 'III')->where('position_service', $position)->count() }}</td>
                            <td>{{ $serviceAgents->where('sexe', 'Feminin')->where('categorie', 'Néant')->where('position_service', $position)->count() }}</td>
                            <td class="text-right"><b>{{ $serviceAgents->where('sexe', 'Feminin')->where('position_service', $position)->count() }}</b></td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Tableau récapitulatif --}}
        <div class="row">
            <div class="col-lg-12 col-sm-12">
                <div class="circle-tile">
                    <a href="#">
                        <div class="circle-tile-heading text-muted">
                            <h3>Récapitulatif par Directions</h3>
                        </div>
                    </a>
                    <div class="circle-tile-content dark-blue"></div>
                </div>
                <table class="table table-bordered">
                    <thead>
                        <tr class="text-white tr-bg">
                            <th>Directions</th>
                            <th>DGTI</th>
                            <th>DT</th>
                            <th>DSI</th>
                            <th>DASP</th>
                            <th>DSEF</th>
                            <th>DIG</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><b>Total Agents</b></td>
                            <td>{{ $directionAgents->where('direction', 'DGTI')->count() }}</td>
                            <td>{{ $directionAgents->where('direction', 'DT')->count() }}</td>
                            <td>{{ $directionAgents->where('direction', 'DSI')->count() }}</td>
                            <td>{{ $directionAgents->where('direction', 'DASP')->count() }}</td>
                            <td>{{ $directionAgents->where('direction', 'DSEF')->count() }}</td>
                            <td>{{ $directionAgents->where('direction', 'DIG')->count() }}</td>
                        </tr>
                        <tr>
                            <td><b>Hommes</b></td>
                            <td>{{ $directionAgents->where('sexe', 'Masculin')->where('direction', 'DGTI')->count() }}</td>
                            <td>{{ $directionAgents->where('sexe', 'Masculin')->where('direction', 'DT')->count() }}</td>
                            <td>{{ $directionAgents->where('sexe', 'Masculin')->where('direction', 'DSI')->count() }}</td>
                            <td>{{ $directionAgents->where('sexe', 'Masculin')->where('direction', 'DASP')->count() }}</td>
                            <td>{{ $directionAgents->where('sexe', 'Masculin')->where('direction', 'DSEF')->count() }}</td>
                            <td>{{ $directionAgents->where('sexe', 'Masculin')->where('direction', 'DIG')->count() }}</td>
                        </tr>
                        <tr>
                            <td><b>Femmes</b></td>
                            <td>{{ $directionAgents->where('sexe', 'Feminin')->where('direction', 'DGTI')->count() }}</td>
                            <td>{{ $directionAgents->where('sexe', 'Feminin')->where('direction', 'DT')->count() }}</td>
                            <td>{{ $directionAgents->where('sexe', 'Feminin')->where('direction', 'DSI')->count() }}</td>
                            <td>{{ $directionAgents->where('sexe', 'Feminin')->where('direction', 'DASP')->count() }}</td>
                            <td>{{ $directionAgents->where('sexe', 'Feminin')->where('direction', 'DSEF')->count() }}</td>
                            <td>{{ $directionAgents->where('sexe', 'Feminin')->where('direction', 'DIG')->count() }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </section>

    <div class="alert alert-danger">
        <strong>Accès refusé !</strong> Vous n'avez pas la permission d'accéder à cette page.
    </div>  
</div>
@endsection