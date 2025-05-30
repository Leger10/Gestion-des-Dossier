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
                        <input type="hidden" name="agent_id" value="{{ $agent->id }}">

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Type d'acte</label>
                                    <select name="type" class="form-select" required>
                                        <option value="">Sélectionner...</option>
                                        <option value="Arrêté">Arrêté</option>
                                        <option value="Décision">Décision</option>
                                        <option value="Note de service">Note de service</option>
                                    </select>
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Référence</label>
                                    <input type="text" name="reference" 
                                           class="form-control" 
                                           required 
                                           placeholder="EX: ARR-2024-001">
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Date de l'acte</label>
                                    <input type="date" name="date_acte" 
                                           class="form-control" 
                                           required 
                                           value="{{ old('date_acte', now()->format('Y-m-d')) }}">
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="form-group">
                                    <label>Description</label>
                                    <textarea name="description" 
                                              class="form-control" 
                                              rows="4"
                                              placeholder="Contenu de l'acte...">{{ old('description') }}</textarea>
                                </div>
                            </div>

                            <div class="col-12 mt-4">
                                <div class="d-flex justify-content-between">
                                    <a href="{{ url()->previous() }}" class="btn btn-secondary">
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