@extends('layouts.admin', ['titrePage' => 'Détails acte administratif'])

@section('content')

@include('partials.back-admin._nav')
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="d-flex justify-content-between align-items-center">
                <h1>
                    <i class="fas fa-file-contract text-primary"></i>
                    Détails de l'acte administratif
                </h1>
                <a href="{{ route('actes_administratifs.index') }}" class="btn btn-light">
                    <i class="fas fa-arrow-left"></i> Retour
                </a>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">
            <div class="card shadow-lg">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <dl class="row">
                                <dt class="col-sm-4">Agent concerné :</dt>
                                <dd class="col-sm-8">{{ $acte->agent->nom_complet }}</dd>

                                <dt class="col-sm-4">Type d'acte :</dt>
                                <dd class="col-sm-8">
                                    <span class="badge bg-primary">
                                        {{ $acte->type }}
                                    </span>
                                </dd>

                                <dt class="col-sm-4">Référence :</dt>
                                <dd class="col-sm-8">
                                    <code>{{ $acte->reference }}</code>
                                </dd>
                            </dl>
                        </div>

                        <div class="col-md-6">
                            <dl class="row">
                                <dt class="col-sm-4">Date de l'acte :</dt>
                                <dd class="col-sm-8">
                                    {{ $acte->date_acte->format('d/m/Y') }}
                                </dd>

                                <dt class="col-sm-4">Créé le :</dt>
                                <dd class="col-sm-8">
                                    {{ $acte->created_at->format('d/m/Y H:i') }}
                                </dd>

                                <dt class="col-sm-4">Dernière mise à jour :</dt>
                                <dd class="col-sm-8">
                                    {{ $acte->updated_at->format('d/m/Y H:i') }}
                                </dd>
                            </dl>
                        </div>

                        <div class="col-12">
                            <div class="border-top mt-3 pt-3">
                                <h5 class="mb-3">
                                    <i class="fas fa-align-left"></i> Description
                                </h5>
                                <div class="bg-light p-3 rounded">
                                    {!! $acte->description ?? '<em>Aucune description disponible</em>' !!}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="card-footer bg-transparent d-flex justify-content-end gap-2">
                    <a href="{{ route('actes_administratifs.edit', $acte) }}" 
                       class="btn btn-warning">
                        <i class="fas fa-edit"></i> Modifier
                    </a>
                    
                    <form action="{{ route('actes_administratifs.destroy', $acte) }}" 
                          method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger" 
                                onclick="return confirm('Confirmer la suppression ?')">
                            <i class="fas fa-trash-alt"></i> Supprimer
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection