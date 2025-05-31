@extends('layouts.admin', ['titrePage' => 'Modifier acte administratif'])

@section('content')
@include('partials.back-admin._nav')

<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="d-flex justify-content-between align-items-center">
                <h1>
                    <i class="fas fa-file-contract text-primary"></i>
                    Modifier l'acte administratif
                </h1>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">
            <div class="card shadow-lg">
                <div class="card-body">
                    <form action="{{ route('actes_administratifs.update', $acte->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Type d'acte</label>
                                    <select name="type" class="form-select" required>
                                        <option value="">Sélectionner...</option>
                                        <option value="Arrêté" {{ $acte->type == 'Arrêté' ? 'selected' : '' }}>Arrêté</option>
                                        <option value="Décision" {{ $acte->type == 'Décision' ? 'selected' : '' }}>Décision</option>
                                        <option value="Note de service" {{ $acte->type == 'Note de service' ? 'selected' : '' }}>Note de service</option>
                                    </select>
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Référence <small class="text-muted">(Doit être unique)</small></label>
                                    <input type="text" name="reference" 
                                           class="form-control @error('reference') is-invalid @enderror" 
                                           required 
                                           value="{{ old('reference', $acte->reference) }}"
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
                                           value="{{ old('date_acte', $acte->date_acte->format('Y-m-d')) }}">
                                    @error('date_acte')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Agent concerné</label>
                                    <select name="agent_id" class="form-select @error('agent_id') is-invalid @enderror" required>
                                        <option value="">Sélectionner un agent...</option>
                                        @foreach($agents as $agentOption)
                                            <option value="{{ $agentOption->id }}" 
                                                {{ $acte->agent_id == $agentOption->id ? 'selected' : '' }}>
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

                            <div class="col-12">
                                <div class="form-group">
                                    <label>Description</label>
                                    <textarea name="description" 
                                              class="form-control @error('description') is-invalid @enderror" 
                                              rows="4"
                                              placeholder="Contenu de l'acte...">{{ old('description', $acte->description) }}</textarea>
                                    @error('description')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-12 mt-4">
                                <div class="d-flex justify-content-between">
                                    <a href="{{ route('actes_administratifs.index') }}" class="btn btn-secondary">
                                        <i class="fas fa-arrow-left"></i> Annuler
                                    </a>
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-save"></i> Mettre à jour
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