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
                                <button type="button" class="btn btn-primary btn-sm" data-toggle="modal"
                                    data-target="#createDirectionModal">
                                    <i class="fa fa-plus"></i> Ajouter direction
                                </button>
                                <button type="button" class="btn btn-success btn-sm" data-toggle="modal"
                                    data-target="#createServiceModal">
                                    <i class="fa fa-plus"></i> Ajouter service
                                </button>
                            </div>
                        </div>
                    </div>
                    
                    
                </div>
            </div>
        </div>

        <section class="content">
            <!-- Statistiques globales -->
            <div class="row">
                <div class="col-md-3 col-sm-6 col-xs-12">
                    <div class="info-box">
                        <span class="info-box-icon bg-blue"><i class="fa fa-building"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">
                                Direction<span class="visible-xs">s</span><span class="hidden-xs">s</span>
                            </span>

                            <span class="info-box-number">{{ $stats['totalDirection'] ?? 0 }}</span>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 col-sm-6 col-xs-12">
                    <div class="info-box">
                        <span class="info-box-icon bg-green"><i class="fa fa-folder"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Services</span>
                            <span class="info-box-number">{{ $stats['totalService'] ?? 0 }}</span>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 col-sm-6 col-xs-12">
                    <div class="info-box">
                        <span class="info-box-icon bg-yellow"><i class="fa fa-users"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Agents</span>
                            <span class="info-box-number">{{ $stats['totalAgents'] ?? 0 }}</span>
                        </div>
                    </div>
                </div>
            </div>

     <div class="row">
    @foreach($directions ?? [] as $direction)
    <div class="col-md-4">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">
                    {{ $direction->name ?? 'Nom inconnu' }}
                    <small>Total agents: {{ ($agentsParDirection[$direction->name] ?? 0) }}</small>
                </h3>
            </div>
            <div class="box-body">
                <ul class="list-group" style="font-size: 14px;">
                    @foreach($direction->services ?? [] as $service)
                    <li class="list-group-item" style="display: flex; justify-content: space-between; align-items: center; padding: 8px 12px;">
                        <div style="flex: 1; min-width: 0; margin-right: 8px; display: flex; align-items: center;">
                            <i class="fas fa-folder" style="margin-right: 8px; color: #4c8bf5;"></i>
                            <div style="word-wrap: break-word; white-space: normal; line-height: 1.4;">
                                {{ $service->name ?? 'Service sans nom' }}
                            </div>
                        </div>
                        <span class="badge bg-blue" style="flex-shrink: 0; padding: 4px 8px; font-size: 13px; margin-left: 8px;">
                            {{ $service->agents_count ?? 0 }} agents
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
        </section>


        <!-- Modals pour la création -->
        @include('admin.structure.modals.create-direction')
        @include('admin.structure.modals.create-service')

        <!-- Modals pour la suppression -->
        @include('admin.structure.modals.delete-direction')
        @include('admin.structure.modals.delete-service')

        <!-- Modals pour l'édition -->
        @include('admin.structure.modals.edit-direction')
        @include('admin.structure.modals.edit-service')
    </section>
</div>
@endsection
@section('scripts')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
<script>
    $(function() {
    // Gestion des clics avec délégation d'événements
    $('body').on('click', '.delete-direction', function(e) {
        e.preventDefault();
        var id = $(this).data('id');
        var name = $(this).data('name');
        
        $('#direction-to-delete').text(name);
        $('#deleteDirectionForm').attr('action', '/admin/directions/' + id);
        $('#deleteDirectionModal').modal('show');
    });

    $('body').on('click', '.delete-service', function(e) {
        e.preventDefault();
        var id = $(this).data('id');
        var name = $(this).data('name');
        
        $('#service-to-delete').text(name);
        $('#deleteServiceForm').attr('action', '/admin/services/' + id);
        $('#deleteServiceModal').modal('show');
    });

    $('body').on('click', '.edit-direction', function(e) {
        e.preventDefault();
        var id = $(this).data('id');
        var name = $(this).data('name');
        var description = $(this).data('description') || '';
        
        $('#editDirectionForm').attr('action', '/admin/directions/' + id);
        $('#edit_direction_name').val(name);
        $('#edit_direction_description').val(description);
        $('#editDirectionModal').modal('show');
    });

    $('body').on('click', '.edit-service', function(e) {
        e.preventDefault();
        var id = $(this).data('id');
        var directionId = $(this).data('direction-id');
        var name = $(this).data('name');
        var description = $(this).data('description') || '';
        
        $('#editServiceForm').attr('action', '/admin/services/' + id);
        $('#edit_service_name').val(name);
        $('#edit_service_direction_id').val(directionId);
        $('#edit_service_description').val(description);
        $('#editServiceModal').modal('show');
    });
});
</script>
@endsection