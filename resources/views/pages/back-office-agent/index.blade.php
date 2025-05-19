@extends('layouts.admin', ['titrePage' => 'DGTPT'])
@section('content')

    @include('partials.back-admin._nav')
    {{-- -----End menu--------- --}}
    <div class="content-wrapper">
    <section class="content-header">
        <h1>Direction générale des collectivités territoriales</h1>
        <ol class="breadcrumb">
        <li class="active"><i class="fa fa-dashboard"></i> Accueil</li>
        @if ($id_zone === '1')
        <li class="active"><i class="fa fa-file-text-o"></i> <b><strong>Liste agents des régions</strong></b></li>
        @else
        <li class="active"><i class="fa fa-file-text-o"></i> <b><strong>Liste agents des communes</strong></b></li>
        @endif
        </ol>
    </section>
    <section class="content">
        
        @include('partials._title')
        @include('partials._notification')

        @if ($listeAgent->count() > 0)
        <div class="row">
                <div class="col-md-12">
                    @if (Auth::user()->is_admin === 1)
                    <div class="box box-primary">
                        <div class="box-header with-border">
                            <h3 class="box-title">Choississez la localité à exporter</h3>
                        </div>
                        <div class="box-body" >
                            <div class="col-md-12">
                                <div class="col-md-12 col-offset-md-3">
                                    @switch($id_zone)
                                        @case(1)
                                            <form action="{{route('export.region')}}" method="post">
                                                @csrf
                                                <div class="form-group">
                                                    <select name="region" class="form-control" id="region" name="region" >
                                                        <option value="" selected disabled>Choisissez le type de téléchargement</option>
                                                        <option style="font-size: 1pt; background-color: #000000;" disabled>&nbsp;</option>
                                                        <option value="TOUTES LES REGIONS" >TOUTES LES REGIONS CT</option>
                                                        <option class="dropdown-divider" disabled>&nbsp;</option>
                                                        <option style="font-size: 1pt; background-color: #000000;" disabled>&nbsp;</option>
                                                        <option disabled>Sélectionner une région</option>
                                                        <option class="dropdown-divider" disabled>&nbsp;</option>
                                                        @foreach ($regions as  $region)
                                                        <option value="{{$region->id}}" >{{$region->libelle}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <button class="btn btn-info pull-right">Exporter la liste</button>
                                            </form>
                                            @break
                                        @case(2)
                                            <form action="{{route('export.commune')}}" method="post">
                                                @csrf
                                                <div class="form-group">
                                                    <select class="form-control" id="collectivite" name="collectivite">
                                                        <option value="" selected disabled>Choisissez le type de téléchargement</option>
                                                        <option style="font-size: 1pt; background-color: #000000;" disabled>&nbsp;</option>
                                                        <option >TOUTES LES COMMNUNES</option>
                                                        <option class="dropdown-divider" disabled>&nbsp;</option>
                                                        <option style="font-size: 1pt; background-color: #000000;" disabled>&nbsp;</option>
                                                        <option value="" selected disabled>Sélectionner la collectivité</option>
                                                        <option class="dropdown-divider" disabled>&nbsp;</option>
                                                        @foreach ($collectivites as  $collectivite)
                                                        <option value="{{$collectivite->id}}" >{{$collectivite->libelle}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <button class="btn btn-info pull-right">Exporter la liste</button>
                                            </form>
                                            {{-- <a href="{{route('export.commune')}}" class="btn btn-info pull-right">Exporter la liste </a> --}}
                                            @break
                                        @default
                                    @endswitch
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif
                </div>
            </div>

            <div class="box">
                <div class="box-header">

                @if ($id_zone === '1')
                <h3 class="box-title">Enregistrement des Agents des Régions CT</h3>
                @elseif ($id_zone === '2')
                <h3 class="box-title">Enregistrement des Agents des Communes </h3>
                @else
                <h3 class="box-title">La Liste Des Agents De La Collectivité Territoriale Enregistré</h3>
                @endif
                </div>

                <div class="box-body">

                    <table id="example" class="table table-hover table-striped" style="width:100%">
                        <thead>
                            <tr class="text-white tr-bg">
                                <th>N°</th>
                                <th>Nom complet</th>
                                <th>Sexe</th>
                                <th>Matricule</th>
                                <th>Emploi</th>
                                <th>Statut</th>
                                <th>Localité</th>
                                @if (Auth::user()->is_admin === 1)
                                <th>Agent crée par </th>
                                @endif
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            <div style="display:none;">{{$n=1}}</div>
                            @foreach ($listeAgent as $agent)
                            <tr >
                                <td > <b>{{$n++}}</b></td>
                                <td >{{$agent->nom}} {{$agent->prenom}}</td>
                                <td>{{ucwords($agent->sexe)}}</td>
                                <td>{{$agent->matricule}}</td>
                                <td>{{ucfirst(strtolower($agent->emploi))}}</td>
                                <td>{{$agent->statut}}</td>
                                <td>{{$agent->libelle}}</td>
                                @if (Auth::user()->is_admin === 1)
                                <td>{{$agent->name}}<br>{{$agent->email}}</td>
                                @endif
                                <td><a href="{{route('agent.show', $agent->id)}}" title="Voir information de l'agent"class="btn btn-info pull-right"><i class="fa fa-eye"></i></a></td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>

                    
                </div>
            </div>
        @else

        <div class="row">
                <div class="col-md-12">

                    <div class="alert alert-success alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                        <h4><i class="icon fa fa-info"></i> Alert!</h4>
                        <h3><p class="text-center">Aucun agent trouvé !</p></h3>
                    </div>

                </div>

              </div>
        @endif

    </section>
    </div>
@endsection
@push('scripts.footer')
<script type="text/javascript" src="{{asset('js/jquery.dataTables.min.js')}}"></script>
<script type="text/javascript" src="{{asset('js/dataTables.bootstrap.min.js')}}"></script>
<script>
$(document).ready(function() {
    $('#example').DataTable();
} );
</script>
@endpush
