@extends('layouts.admin', ['titrePage' => 'Création acte administratif'])

@section('content')
@include('partials.back-admin._nav')
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <h1>
                <i class="fas fa-file-contract text-primary"></i>
                Nouvel acte administratif
            </h1>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">
            <div class="card shadow-lg">
                <div class="card-body">
                    <form action="{{ route('actes_administratifs.store') }}" method="POST">
                        @csrf
                        @if(isset($agent))
                        <input type="hidden" name="agent_id" value="{{ $agent->id }}">
                        @endif

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Type d'acte</label>
                                    <select name="type" class="form-select" required>
                                        <option value="">Sélectionner...</option>
                                        <option value="Arrêté" {{ old('type') == 'Arrêté' ? 'selected' : '' }}>Arrêté</option>
                                        <option value="Décision" {{ old('type') == 'Décision' ? 'selected' : '' }}>Décision</option>
                                        <option value="Note de service" {{ old('type') == 'Note de service' ? 'selected' : '' }}>Note de service</option>
                                    </select>
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Référence <small class="text-muted">(Doit être unique)</small></label>
                                    <input type="text" name="reference" 
                                           class="form-control @error('reference') is-invalid @enderror" 
                                           required 
                                           value="{{ old('reference') }}"
                                           placeholder="EX: ARR-2024-001">
                                    @error('reference')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Date de l'acte</label>
                                    <input type="date" name="date_acte" 
                                           class="form-control @error('date_acte') is-invalid @enderror" 
                                           required 
                                           value="{{ old('date_acte', now()->format('Y-m-d')) }}">
                                    @error('date_acte')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            @if(!isset($agent))
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Agent concerné</label>
                                    <select name="agent_id" class="form-select @error('agent_id') is-invalid @enderror" required>
                                        <option value="">Sélectionner un agent...</option>
                                        @foreach($agents as $agentOption)
                                            <option value="{{ $agentOption->id }}" 
                                                {{ old('agent_id') == $agentOption->id ? 'selected' : '' }}>
                                                {{ $agentOption->nom }} {{ $agentOption->prenom }} 
                                                ({{ $agentOption->matricule }})
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('agent_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            @endif

                            <div class="col-12">
                                <div class="form-group">
                                    <label>Description</label>
                                    <textarea name="description" 
                                              class="form-control @error('description') is-invalid @enderror" 
                                              rows="4"
                                              placeholder="Contenu de l'acte...">{{ old('description') }}</textarea>
                                    @error('description')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-12 mt-4">
                                <div class="d-flex justify-content-between">
                                    <a href="{{ route('actes_administratifs.index') }}" class="btn btn-secondary">
                                        <i class="fas fa-arrow-left"></i> Retour
                                    </a>
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-save"></i> Enregistrer
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection
@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.querySelector('form');
    
    form.addEventListener('submit', function(e) {
        let isValid = true;
        
        // Validation de la référence
        const referenceInput = document.querySelector('input[name="reference"]');
        if (!referenceInput.value.trim()) {
            isValid = false;
            alert('La référence est obligatoire');
        }
        
        // Validation du type
        const typeSelect = document.querySelector('select[name="type"]');
        if (typeSelect.value === "") {
            isValid = false;
            alert('Veuillez sélectionner un type d\'acte');
        }
        
        // Validation de la date
        const dateInput = document.querySelector('input[name="date_acte"]');
        if (!dateInput.value) {
            isValid = false;
            alert('La date de l\'acte est obligatoire');
        }
        
        if (!isValid) {
            e.preventDefault();
        }
    });
});
</script>
@endsection