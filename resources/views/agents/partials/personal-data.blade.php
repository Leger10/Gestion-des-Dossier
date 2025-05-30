<div class="box box-primary">
    <div class="box-header with-border">
        <h3 class="box-title">Données personnelles</h3>
    </div>
    <div class="box-body">
        <!-- Identité -->
        <div class="form-group">
            <label>Nom (*)</label>
            <input type="text" class="form-control" name="nom" value="{{ old('nom') }}" required>
            {!! $errors->first('nom', '<span class="error text-error">:message</span>') !!}
        </div>

        <div class="form-group">
            <label>Prénom(s) (*)</label>
            <input type="text" class="form-control" name="prenom" value="{{ old('prenom') }}" required>
            {!! $errors->first('prenom', '<span class="error text-error">:message</span>') !!}
        </div>

        <!-- Contacts -->
        <div class="form-group">
            <label>Téléphone (*)</label>
            <input type="tel" class="form-control" name="telephone" value="{{ old('telephone') }}" required>
            {!! $errors->first('telephone', '<span class="error text-error">:message</span>') !!}
        </div>

        <div class="mb-3">
            <label for="date_naissance" class="form-label">Date de naissance *</label>
            <input type="date" name="date_naissance" id="date_naissance" class="form-control"
                value="{{ old('date_naissance', $agent->date_naissance ? \Carbon\Carbon::parse($agent->date_naissance)->format('Y-m-d') : '') }}"
                required>
            @error('date_naissance')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>
        <div class="form-group">
            <label>Lieu de naissance (*)</label>
            <input type="text" class="form-control" name="lieu_naissance" value="{{ old('lieu_naissance') }}" required>
            {!! $errors->first('lieu_naissance', '<span class="error text-error">:message</span>') !!}
        </div>

        <!-- Sexe (structure corrigée) -->
        <div class="form-group">
            <label for="sexe" class="form-label">Sexe *</label>
            <select name="sexe" id="sexe" class="form-select @error('sexe') is-invalid @enderror" required>
                <option value="">Sélectionner</option>
                <option value="M" {{ old('sexe')=='M' ? 'selected' : '' }}>Masculin</option>
                <option value="F" {{ old('sexe')=='F' ? 'selected' : '' }}>Féminin</option>
            </select>
            @error('sexe')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div> <!-- Fermeture correcte ici -->

        <div class="form-group">
            <label>Situation matrimoniale (*)</label>
            <select class="form-control" name="situation_matrimoniale" required>
                <option value="">Sélectionner...</option>
                <option value="Célibataire" {{ old('situation_matrimoniale')=='Célibataire' ? 'selected' : '' }}>
                    Célibataire</option>
                <option value="Marié(e)" {{ old('situation_matrimoniale')=='Marié(e)' ? 'selected' : '' }}>Marié(e)
                </option>
                <option value="Divorcé(e)" {{ old('situation_matrimoniale')=='Divorcé(e)' ? 'selected' : '' }}>
                    Divorcé(e)</option>
                <option value="Veuf/Veuve" {{ old('situation_matrimoniale')=='Veuf/Veuve' ? 'selected' : '' }}>
                    Veuf/Veuve</option>
            </select>
            {!! $errors->first('situation_matrimoniale', '<span class="error text-error">:message</span>') !!}
        </div>

        <!-- Identification -->
        <div class="form-group">
            <label>Matricule (*)</label>
            <input type="text" class="form-control" name="matricule" value="{{ old('matricule') }}" required>
            {!! $errors->first('matricule', '<span class="error text-error">:message</span>') !!}
        </div>

        <div class="form-group">
            <label>Nationalité (*)</label>
            <input type="text" class="form-control" name="nationalite" value="{{ old('nationalite') }}" required>
            {!! $errors->first('nationalite', '<span class="error text-error">:message</span>') !!}
        </div>
    </div>
