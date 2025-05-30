@extends('layouts.admin', ['titrePage' => 'DGTI'])
@section('content')
@include('partials.back-admin._nav')

<div class="content-wrapper">
    <section class="content-header">
        <h1>{{ __("Direction générale des transmissions et de l'informatique") }}</h1>
        <ol class="breadcrumb">
            <li class="active"><i class="fa fa-dashboard"></i> Accueil</li>
            <li class="active"><i class="fa fa-user-plus"></i> <strong>Nouvel agent</strong></li>
        </ol>
    </section>

    <section class="content">
        @include('partials._notification')

        <form action="{{ route('agent.store') }}" method="POST">
            @csrf

{{-- Rattachement --}}
    <div class="card mb-4">
        <div class="card-header">
            <h5>Rattachement</h5>
        </div>
        <div class="card-body">
            <div class="row g-3">

                {{-- Type de rattachement --}}
                <div class="col-md-6">
                    <label for="rattachement_type" class="form-label">Type de rattachement *</label>
                    <select name="rattachement_type" id="rattachement_type" class="form-select @error('rattachement_type') is-invalid @enderror" required>
                        <option value="">Sélectionner</option>
                        <option value="direction" {{ old('rattachement_type') == 'direction' ? 'selected' : '' }}>Direction</option>
                        <option value="service" {{ old('rattachement_type') == 'service' ? 'selected' : '' }}>Service</option>
                    </select>
                    @error('rattachement_type')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Direction --}}
                <div class="col-md-6">
                    <label for="direction_id" class="form-label">Direction *</label>
                    <select name="parent_direction_id" id="direction_id" class="form-select @error('parent_direction_id') is-invalid @enderror" required>
                        <option value="">Sélectionner une direction</option>
                        @foreach($directions as $direction)
                            <option value="{{ $direction->id }}" {{ old('parent_direction_id') == $direction->id ? 'selected' : '' }}>
                                {{ $direction->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('parent_direction_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Service --}}
                <div class="col-md-6" id="service_container" style="display:none;">
                    <label for="service_id" class="form-label">Service *</label>
                    <select name="service_id" id="service_id" class="form-select @error('service_id') is-invalid @enderror">
                        <option value="">Sélectionner un service</option>
                        {{-- Les options seront chargées via JS --}}
                    </select>
                    @error('service_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

            </div>
        </div>
    </div>

            <!-- Données de formulaire -->
            <div class="row">
                <div class="col-md-6">
                    @include('agents.partials.personal-data')
                </div>
                 </div>
                 <div class="row">
                <div class="col-md-6">
                    @include('agents.partials.administrative-data')
                </div>
            </div>

            <!-- Boutons -->
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
    document.addEventListener('DOMContentLoaded', function () {
        const rattachementTypeSelect = document.getElementById('rattachement_type');
        const directionSelect = document.getElementById('direction_id');
        const serviceContainer = document.getElementById('service_container');
        const serviceSelect = document.getElementById('service_id');

        // Tous les services par direction, préchargés depuis Blade (ou tu peux aussi faire via AJAX)
        const servicesByDirection = @json($servicesByDirection);

        function updateForm() {
            const type = rattachementTypeSelect.value;
            if (type === 'direction') {
                serviceContainer.style.display = 'none';
                serviceSelect.removeAttribute('required');
                serviceSelect.value = '';
                directionSelect.setAttribute('required', 'required');
            } else if (type === 'service') {
                serviceContainer.style.display = 'block';
                serviceSelect.setAttribute('required', 'required');
                directionSelect.setAttribute('required', 'required');
            } else {
                serviceContainer.style.display = 'none';
                serviceSelect.removeAttribute('required');
                directionSelect.removeAttribute('required');
            }
        }

        function updateServicesOptions() {
            const directionId = directionSelect.value;
            serviceSelect.innerHTML = '<option value="">Sélectionner un service</option>';
            if (directionId && servicesByDirection[directionId]) {
                servicesByDirection[directionId].forEach(service => {
                    const option = document.createElement('option');
                    option.value = service.id;
                    option.textContent = service.name;
                    if ("{{ old('service_id') }}" == service.id) {
                        option.selected = true;
                    }
                    serviceSelect.appendChild(option);
                });
            }
        }

        rattachementTypeSelect.addEventListener('change', () => {
            updateForm();
            // Si on passe à service, on recharge la liste des services
            if (rattachementTypeSelect.value === 'service') {
                updateServicesOptions();
            }
        });

        directionSelect.addEventListener('change', () => {
            if (rattachementTypeSelect.value === 'service') {
                updateServicesOptions();
            }
        });

        // Initial setup au chargement page
        updateForm();
        if (rattachementTypeSelect.value === 'service') {
            updateServicesOptions();
        }



        $('.datepicker').datepicker({
            format: 'dd-mm-yyyy',
            autoclose: true,
            todayHighlight: true
        });
    });
</script>
@endpush
