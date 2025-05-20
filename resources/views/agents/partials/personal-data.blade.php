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

        <!-- Etat civil -->
        <div class="form-group">
            <label>Date de naissance (*)</label>
            <div class="input-group date">
                <div class="input-group-addon">
                    <i class="fa fa-calendar"></i>
                </div>
                <input type="text" class="form-control datepicker" name="date_naissance" value="{{ old('date_naissance') }}" required>
            </div>
            {!! $errors->first('date_naissance', '<span class="error text-error">:message</span>') !!}
        </div>

        <div class="form-group">
            <label>Lieu de naissance (*)</label>
            <input type="text" class="form-control" name="lieu_naissance" value="{{ old('lieu_naissance') }}" required>
            {!! $errors->first('lieu_naissance', '<span class="error text-error">:message</span>') !!}
        </div>

        <div class="form-group">
            <label>Sexe (*)</label>
            <div>
                <label class="radio-inline">
                    <input type="radio" name="sexe" value="M" {{ old('sexe') == 'M' ? 'checked' : '' }} required> Masculin
                </label>
                <label class="radio-inline">
                    <input type="radio" name="sexe" value="F" {{ old('sexe') == 'F' ? 'checked' : '' }}> Féminin
                </label>
            </div>
            {!! $errors->first('sexe', '<span class="error text-error">:message</span>') !!}
        </div>

        <div class="form-group">
            <label>Situation matrimoniale (*)</label>
            <select class="form-control" name="situation_matrimoniale" required>
                <option value="">Sélectionner...</option>
                <option value="Célibataire" {{ old('situation_matrimoniale') == 'Célibataire' ? 'selected' : '' }}>Célibataire</option>
                <option value="Marié(e)" {{ old('situation_matrimoniale') == 'Marié(e)' ? 'selected' : '' }}>Marié(e)</option>
                <option value="Divorcé(e)" {{ old('situation_matrimoniale') == 'Divorcé(e)' ? 'selected' : '' }}>Divorcé(e)</option>
                <option value="Veuf/Veuve" {{ old('situation_matrimoniale') == 'Veuf/Veuve' ? 'selected' : '' }}>Veuf/Veuve</option>
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
</div>