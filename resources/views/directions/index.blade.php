@extends('layouts.admin', ['titrePage' => 'DGTI'])

@section('content')
@include('partials.back-admin._nav')

<div class="content-wrapper">
    <section class="content-header">
        <h1>
            Direction générale des transmissions et de l'informatique
            <small>Structures organisationnelles</small>
        </h1>
    </section>

    <section class="content">
        <!-- Notification de succès -->
        @if (session('success'))
        <div class="alert alert-success alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
            <h4><i class="icon fa fa-check"></i> Succès !</h4>
            {{ session('success') }}
        </div>
        @endif

        <!-- Liste des Directions et Services -->
        <div class="row">
            <div class="col-md-12">
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">Structures organisationnelles</h3>
                        <div class="box-tools pull-right">
                            <div class="btn-group">
                                <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#createDirectionModal">
                                    <i class="fa fa-plus"></i> Ajouter direction
                                </button>
                                <button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#createServiceModal">
                                    <i class="fa fa-plus"></i> Ajouter service
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="box-body">
                        <div class="row">
                            @foreach($directionsServices as $direction => $services)
                            <div class="col-md-4">
                                <div class="panel panel-primary">
                                    <div class="panel-heading">
                                        <h3 class="panel-title">
                                            <i class="fa fa-building"></i> {{ $direction }}
                                        </h3>
                                    </div>
                                    <div class="panel-body" style="padding:0;">
                                        <ul class="list-group">
                                            @foreach($services as $service)
                                            <li class="list-group-item">
                                                <i class="fa fa-folder"></i> {{ $service }}
                                                <span class="badge bg-blue pull-right">
                                                    {{ $serviceAgents->where('service', $service)->count() }}
                                                </span>
                                            </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal de création de direction -->
        <div class="modal fade" id="createDirectionModal" tabindex="-1" role="dialog" aria-labelledby="createDirectionModalLabel">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <form action="{{ route('directions.store') }}" method="POST">
                        @csrf
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Fermer">
                                <span aria-hidden="true">&times;</span>
                            </button>
                            <h4 class="modal-title" id="createDirectionModalLabel">
                                <i class="fa fa-plus"></i> Nouvelle Direction
                            </h4>
                        </div>
                        
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="nom">Nom de la direction</label>
                                <input type="text" name="nom" id="nom" class="form-control" required placeholder="Ex: DGTI">
                                <small class="text-muted">Maximum 50 caractères</small>
                            </div>
                        </div>
                        
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">
                                <i class="fa fa-times"></i> Annuler
                            </button>
                            <button type="submit" class="btn btn-primary">
                                <i class="fa fa-save"></i> Enregistrer
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Modal de création de service -->
        <div class="modal fade" id="createServiceModal" tabindex="-1" role="dialog" aria-labelledby="createServiceModalLabel">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <form action="{{ route('services.store') }}" method="POST">
                        @csrf
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Fermer">
                                <span aria-hidden="true">&times;</span>
                            </button>
                            <h4 class="modal-title" id="createServiceModalLabel">
                                <i class="fa fa-plus"></i> Nouveau Service
                            </h4>
                        </div>
                        
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="direction_id">Direction</label>
                                <select name="direction_id" id="direction_id" class="form-control" required>
                                    <option value="">Sélectionnez une direction</option>
                                    @foreach($directions as $direction)
                                    <option value="{{ $direction->id }}">{{ $direction->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="nom">Nom du service</label>
                                <input type="text" name="nom" id="nom" class="form-control" required placeholder="Ex: Secrétariat particulier">
                                <small class="text-muted">Maximum 50 caractères</small>
                            </div>
                        </div>
                        
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">
                                <i class="fa fa-times"></i> Annuler
                            </button>
                            <button type="submit" class="btn btn-success">
                                <i class="fa fa-save"></i> Enregistrer
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Tableau des Directions -->
        <div class="row">
            <div class="col-md-12">
                <div class="box box-solid box-info">
                    <div class="box-header with-border">
                        <h3 class="box-title">
                            <i class="fa fa-list"></i> Liste des Directions
                        </h3>
                        <div class="box-tools">
                            <span class="badge bg-light-blue">{{ $directions->total() }} directions</span>
                            <span class="badge bg-green">{{ $totalServices }} services</span>
                        </div>
                    </div>
                    <div class="box-body table-responsive no-padding">
                        <table class="table table-hover">
                            <thead>
                                <tr class="bg-info">
                                    <th style="width:50%">Nom de la Direction</th>
                                    <th style="width:30%">Nombre de Services</th>
                                    <th style="width:20%">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($directions as $direction)
                                <tr>
                                    <td>
                                        <strong>{{ $direction->name }}</strong>
                                    </td>
                                    <td>
                                        <span class="badge bg-green">
                                            {{ $direction->services->count() }}
                                        </span>
                                    </td>
                                    <td>
                                        <div class="btn-group">
                                            <a href="{{ route('directions.edit', $direction->id) }}" 
                                               class="btn btn-warning btn-xs"
                                               title="Modifier">
                                               <i class="fa fa-edit"></i>
                                            </a>
                                            
                                            <button type="button" 
                                                    class="btn btn-danger btn-xs" 
                                                    title="Supprimer"
                                                    data-toggle="modal" 
                                                    data-target="#deleteModal{{ $direction->id }}">
                                                <i class="fa fa-trash"></i>
                                            </button>
                                            
                                            <!-- Modal de suppression -->
                                            <div class="modal fade" id="deleteModal{{ $direction->id }}" tabindex="-1" role="dialog">
                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                            <h4 class="modal-title">Confirmer la suppression</h4>
                                                        </div>
                                                        <div class="modal-body">
                                                            <p>Êtes-vous sûr de vouloir supprimer la direction "{{ $direction->name }}" ?</p>
                                                            <p class="text-danger"><strong>Tous les services associés seront également supprimés !</strong></p>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <form action="{{ route('directions.destroy', $direction->id) }}" method="POST">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="button" class="btn btn-default" data-dismiss="modal">Annuler</button>
                                                                <button type="submit" class="btn btn-danger">Confirmer</button>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="3" class="text-center text-muted">
                                        <i class="fa fa-info-circle"></i> Aucune direction enregistrée
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="box-footer clearfix">
                        <div class="pull-right">
                            {{ $directions->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection