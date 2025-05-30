@extends('layouts.admin', ['titrePage' => 'DGTI'])
@section('content')

    @include('partials.back-admin._nav')
    
    <div class="content-wrapper">
        <section class="content-header">
            <h1>        Direction générale des transmissions et de l'informatique
</h1>
            <ol class="breadcrumb">
                <li class="active"><i class="fa fa-dashboard"></i> Accueil</li>
                <li class="active"><i class="fa fa-users"></i> Gestion des agents</li>
            </ol>
        </section>

        <section class="content">
            @include('partials._notification')

            <div class="row">
                <div class="col-md-12">
                    <div class="box box-primary">
                        <div class="box-header with-border">
                            <h3 class="box-title">Structures organisationnelles</h3>
                            <div class="box-tools pull-right">
                                <button class="btn btn-sm btn-info" data-toggle="modal" data-target="#exportModal">
                                    <i class="fa fa-download"></i> Exporter les agents
                                </button>
                            </div>
                        </div>
                        
                      <div class="box-body">
    <div class="row">
        @foreach($directions as $direction)
        <div class="col-md-4">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <h3 class="panel-title">
                        <i class="fa fa-building"></i> {{ $direction->name }}
                        <span class="badge bg-light-blue pull-right">
                         {{ $direction->agents_count }} agents
                        </span>
                    </h3>
                </div>
                <div class="panel-body" style="padding:0;">
                    <ul class="list-group">
                        @forelse($direction->services as $service)
                        <li class="list-group-item">
                            <div style="display: flex; justify-content: space-between; align-items: center;">
                                <div>
                                    <i class="fa fa-folder"></i> {{ $service->name }}
                                </div>
                                <div style="display: flex; align-items: center;">
                                    <span class="badge bg-blue" style="margin-right: 10px;">
                                       {{ $service->agents_count }} agents
                                    </span>
                                    <a href="{{ route('export.service', $service->id) }}" 
                                       class="btn btn-xs btn-info" 
                                       title="Exporter ce service">
                                        <i class="fa fa-download"></i>
                                    </a>
                                </div>
                            </div>
                        </li>
                        @empty
                        <li class="list-group-item text-muted">Aucun service</li>
                        @endforelse
                    </ul>
                </div>
                <div class="panel-footer">
                    <a href="{{ route('export.direction', $direction->id) }}" 
                       class="btn btn-xs btn-primary" 
                       title="Exporter cette direction">
                        <i class="fa fa-download"></i> Exporter la direction
                    </a>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>
                    </div>
                </div>
            </div>

            <!-- Modal d'export -->
            <div class="modal fade" id="exportModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
         <form id="exportForm" method="GET" action="{{ route('export.agents') }}">
    @csrf
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
        <h4 class="modal-title">Options d'export</h4>
    </div>
    <div class="modal-body">
        <div class="form-group">
            <label>Type d'export</label>
            <select class="form-control" name="type" id="exportType" required>
                <option value="all">Tous les agents</option>
                <option value="direction">Par direction</option>
                <option value="service">Par service</option>
                <option value="statut">Par statut</option>
            </select>
        </div>
        
        <div class="form-group" id="directionField" style="display:none;">
            <label>Direction</label>
            <select class="form-control" name="direction_id" id="directionSelect">
                @foreach($directions as $direction)
                <option value="{{ $direction->id }}">{{ $direction->name }}</option>
                @endforeach
            </select>
        </div>
        
        <div class="form-group" id="serviceField" style="display:none;">
            <label>Service</label>
            <select class="form-control" name="service_id" id="serviceSelect">
                <option value="">Choisir un service</option>
            </select>
        </div>
        
        <div class="form-group" id="statutField" style="display:none;">
            <label>Statut</label>
            <select class="form-control" name="statut">
                <option value="Actif">Actif</option>
                <option value="Inactif">Inactif</option>
                <option value="En congé">En congé</option>
            </select>
        </div>
        
        <div class="form-group">
            <label>Format</label>
            <select class="form-control" name="format" required>
                <option value="xlsx">Excel (.xlsx)</option>
                <option value="csv">CSV (.csv)</option>
            </select>
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Annuler</button>
        <button type="submit" class="btn btn-primary">
            <i class="fa fa-download"></i> Exporter
        </button>
    </div>
</form>
        </div>
        
    </div>
</div>
        </section>
    </div>
@endsection

@push('scripts')
<script>
$(document).ready(function() {
    // Gestion dynamique des champs
    $('#exportType').change(function() {
        $('#directionField, #serviceField, #statutField').hide();
        
        switch($(this).val()) {
            case 'direction':
                $('#directionField').show();
                break;
            case 'service':
                $('#directionField, #serviceField').show();
                loadServices($('#directionField select').val());
                break;
            case 'statut':
                $('#statutField').show();
                break;
        }
    });

    // Chargement des services en fonction de la direction
    $('#directionField select').change(function() {
        if ($('#exportType').val() === 'service') {
            loadServices($(this).val());
        }
    });

    $(document).ready(function() {
    // Gestion dynamique des champs
    $('#exportType').change(function() {
        $('#directionField, #serviceField, #statutField').hide();
        
        switch($(this).val()) {
            case 'direction':
                $('#directionField').show();
                break;
            case 'service':
                $('#directionField, #serviceField').show();
                loadServices($('#directionField select').val());
                break;
            case 'statut':
                $('#statutField').show();
                break;
        }
    });

    // Chargement des services
    $('#directionField select').change(function() {
        if ($('#exportType').val() === 'service') {
            loadServices($(this).val());
        }
    });

    function loadServices(directionId) {
        if (!directionId) return;
        
        $.get('/directions/' + directionId + '/services', function(response) {
            const $select = $('#serviceField select');
            $select.empty().append('<option value="">Choisir un service</option>');
            
            if (response.success && response.services) {
                $.each(response.services, function(index, service) {
                    $select.append(
                        $('<option></option>')
                            .val(service.id)
                            .text(service.name)
                    );
                });
            }
        }).fail(function(xhr) {
            console.error('Erreur:', xhr.responseText);
            $('#serviceField select').empty()
                .append('<option value="">Erreur de chargement</option>');
        });
    }

    /// Utilisez cette approche pour générer les URLs
const routes = {
    all: "{{ route('export.all') }}",
    direction: "{{ route('export.direction', ['direction' => 'DIRECTION_ID']) }}",
    service: "{{ route('export.service', ['service' => 'SERVICE_ID']) }}",
    filter: "{{ route('export.filter') }}"
};

$('#exportForm').submit(function(e) {
    e.preventDefault();
    const type = $('#exportType').val();
    let url = '';
    
    switch(type) {
        case 'all':
            url = routes.all;
            break;
        case 'direction':
            const directionId = $('select[name="direction_id"]').val();
            url = routes.direction.replace('DIRECTION_ID', directionId);
            break;
        case 'service':
            const serviceId = $('select[name="service_id"]').val();
            url = routes.service.replace('SERVICE_ID', serviceId);
            break;
        case 'statut':
            url = routes.filter + '?statut=' + $('select[name="statut"]').val();
            break;
    }
    
    window.location.href = url;
});

</script>
@endpush