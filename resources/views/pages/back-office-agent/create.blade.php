@extends('layouts.admin', ['titrePage' => 'DGTPT'])
@section('content')
    @include('partials.back-admin._nav')
    
    <div class="content-wrapper">
        <section class="content-header">
            <h1>Direction générale des collectivités territoriales</h1>
            <ol class="breadcrumb">
                <li class="active"><i class="fa fa-dashboard"></i> Accueil</li>
                <li class="active"><i class="fa fa-user-plus"></i> <strong>Nouvel agent</strong></li>
            </ol>
        </section>

        <section class="content">
            @include('partials._notification')
            
            <form action="{{ route('agent.store') }}" method="post">
                @csrf
                
                <!-- Section Direction/Service de rattachement -->
                <div class="row">
                    <div class="col-md-12">
                        <div class="box box-primary">
                            <div class="box-header with-border">
                                <h3 class="box-title">Rattachement administratif</h3>
                            </div>
                            <div class="box-body">
                                <div class="col-md-4">
                                    {!! $errors->first('direction', '<span class="error text-error">:message</span>') !!}
                                    <div class="form-group">
                                        <label>Type de rattachement (*)</label><br>
                                        <label class="radio-inline">
                                            <input type="radio" name="rattachement_type" value="direction" 
                                                   {{ old('rattachement_type') == "direction" ? 'checked' : '' }}>
                                            Direction
                                        </label><br>
                                        <label class="radio-inline">
                                            <input type="radio" name="rattachement_type" value="service" 
                                                   {{ old('rattachement_type') == "service" ? 'checked' : '' }}>
                                            Service
                                        </label>
                                    </div>
                                    {!! $errors->first('rattachement_type', '<span class="error text-error">:message</span>') !!}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Section Direction (visible si direction sélectionnée) -->
                <div class="box box-primary" id="direction-section" style="display:{{ old('rattachement_type') == 'direction' ? 'block' : 'none' }};">
                    <div class="box-header with-border">
                        <h3 class="box-title">Direction de rattachement</h3>
                    </div>
                    <div class="box-body">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Direction (*)</label>
                                <select class="form-control" name="direction_id" required>
                                    <option value="">Sélectionner une direction</option>
                                    @foreach ($directions as $direction)
                                        <option value="{{ $direction->id }}" {{ old('direction_id') == $direction->id ? 'selected' : '' }}>
                                            {{ $direction->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            {!! $errors->first('direction_id', '<span class="error text-error">:message</span>') !!}
                        </div>
                    </div>
                </div>

                <!-- Section Service (visible si service sélectionné) -->
                <div class="box box-primary" id="service-section" style="display:{{ old('rattachement_type') == 'service' ? 'block' : 'none' }};">
                    <div class="box-header with-border">
                        <h3 class="box-title">Service de rattachement</h3>
                    </div>
                    <div class="box-body">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Direction (*)</label>
                                <select class="form-control" id="direction-select" name="parent_direction_id" required>
                                    <option value="">Sélectionner une direction</option>
                                    @foreach ($directions as $direction)
                                        <option value="{{ $direction->id }}" {{ old('parent_direction_id') == $direction->id ? 'selected' : '' }}>
                                            {{ $direction->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Service (*)</label>
                                <select class="form-control" id="service-select" name="service_id" required>
                                    <option value="">Sélectionner un service</option>
                                    @if(old('service_id') && $selectedService = \App\Models\Service::find(old('service_id')))
                                        <option value="{{ old('service_id') }}" selected>
                                            {{ $selectedService->name }}
                                        </option>
                                    @endif
                                </select>
                                {!! $errors->first('service_id', '<span class="error text-error">:message</span>') !!}
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Données personnelles et administratives -->
                <div class="row">
                    <div class="col-md-6">
                        @include('agents.partials.personal-data')
                    </div>
                    
                    <div class="col-md-6">
                        @include('agents.partials.administrative-data')
                    </div>
                </div>

                <!-- Boutons de soumission -->
                <div class="row">
                    <div class="col-md-12">
                        <a href="{{ URL::previous() }}" class="btn btn-danger btn-lg pull-left">
                            <i class="fa fa-reply"></i> Retour
                        </a>
                        <button type="submit" class="btn btn-primary btn-lg pull-right">
                            <i class="fa fa-save"></i> Enregistrer
                        </button>
                    </div>
                </div>
            </form>
        </section>
    </div>
@endsection
@push('scripts.footer')
<script>
    $(document).ready(function() {
        // Afficher/masquer les sections
        function toggleSections() {
            const type = $('input[name="rattachement_type"]:checked').val();
            $('#direction-section').toggle(type === 'direction');
            $('#service-section').toggle(type === 'service');
            
            // Gestion des champs requis
            $('#direction_id').prop('required', type === 'direction');
            $('#parent_direction_id, #service-select').prop('required', type === 'service');
        }

        // Initialiser les sections
        toggleSections();
        
        // Écouter les changements de type de rattachement
        $('input[name="rattachement_type"]').change(toggleSections);

        // Charger les services quand une direction est sélectionnée
        $('#direction-select').on('change', function() {
            const directionId = $(this).val();
            const $serviceSelect = $('#service-select');
            
            $serviceSelect.empty().append('<option value="">Sélectionner un service</option>');
            
            if (directionId) {
                $.ajax({
                    url: `/api/directions/${directionId}/services`,
                    type: 'GET',
                    dataType: 'json',
                    success: function(services) {
                        services.forEach(service => {
                            $serviceSelect.append(
                                $('<option></option>')
                                    .val(service.id)
                                    .text(service.name)
                            );
                        });
                        
                        // Sélectionner l'ancienne valeur si elle existe
                        const oldServiceId = "{{ old('service_id') }}";
                        if (oldServiceId) {
                            $serviceSelect.val(oldServiceId);
                        }
                    },
                    error: function(xhr) {
                        console.error('Erreur:', xhr.responseText);
                        alert('Impossible de charger les services');
                    }
                });
            }
        });

        // Si une direction est déjà sélectionnée (après erreur de validation)
        @if(old('parent_direction_id'))
            $('#direction-select').val("{{ old('parent_direction_id') }}").trigger('change');
        @endif

        // Datepicker
        $('.datepicker').datepicker({
            format: 'dd-mm-yyyy',
            autoclose: true,
            todayHighlight: true
        });
    });
</script>

@endpush