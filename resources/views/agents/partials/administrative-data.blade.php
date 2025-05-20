<div class="box box-primary">
    <div class="box-header with-border">
        <h3 class="box-title">Données administratives</h3>
    </div>
    <div class="box-body">
        <!-- Recrutement -->
        <div class="form-group">
            <label>Date de recrutement (*)</label>
            <div class="input-group date">
                <div class="input-group-addon">
                    <i class="fa fa-calendar"></i>
                </div>
                <input type="text" class="form-control datepicker" name="date_recrutement" value="{{ old('date_recrutement') }}" required>
            </div>
            {!! $errors->first('date_recrutement', '<span class="error text-error">:message</span>') !!}
        </div>

        <div class="form-group">
            <label>Diplôme de recrutement (*)</label>
            <select class="form-control" name="diplome_recrutement" required>
                <option value="">Sélectionner...</option>
                @foreach(['BAC', 'BAC+2', 'BAC+3', 'BAC+5', 'Autre'] as $diplome)
                    <option value="{{ $diplome }}" {{ old('diplome_recrutement') == $diplome ? 'selected' : '' }}>
                        {{ $diplome }}
                    </option>
                @endforeach
            </select>
            {!! $errors->first('diplome_recrutement', '<span class="error text-error">:message</span>') !!}
        </div>

        <!-- Position administrative -->
        <div class="form-group">
            <label>Statut (*)</label>
            <select class="form-control" name="statut" required>
                <option value="">Sélectionner...</option>
                @foreach(['Actif', 'En congé', 'Détaché', 'Autre'] as $statut)
                    <option value="{{ $statut }}" {{ old('statut') == $statut ? 'selected' : '' }}>
                        {{ $statut }}
                    </option>
                @endforeach
            </select>
            {!! $errors->first('statut', '<span class="error text-error">:message</span>') !!}
        </div>

        <div class="form-group">
            <label>Position (*)</label>
            <select class="form-control" name="position" required>
                <option value="">Sélectionner...</option>
                @foreach(['Titulaire', 'Stagiaire', 'Contractuel', 'Autre'] as $position)
                    <option value="{{ $position }}" {{ old('position') == $position ? 'selected' : '' }}>
                        {{ $position }}
                    </option>
                @endforeach
            </select>
            {!! $errors->first('position', '<span class="error text-error">:message</span>') !!}
        </div>

        <!-- Carrière -->
        <div class="form-group">
            <label>Grade (*)</label>
            <input type="text" class="form-control" name="grade" value="{{ old('grade') }}" required>
            {!! $errors->first('grade', '<span class="error text-error">:message</span>') !!}
        </div>
<div class="form-group">
    <label>Catégorie (*)</label>
    <select class="form-control" name="categorie" required>
        <option value="">Sélectionner...</option>
        @foreach(['I', 'II', 'III', 'Néant'] as $categorie)
            <option value="{{ $categorie }}" {{ old('categorie') == $categorie ? 'selected' : '' }}>
                {{ $categorie }}
            </option>
        @endforeach
    </select>
    {!! $errors->first('categorie', '<span class="error text-error">:message</span>') !!}
</div>
        <div class="form-group">
            <label>Échelon (*)</label>
            <select class="form-control" name="echelon" required>
                <option value="">Sélectionner...</option>
                @for($i = 1; $i <= 10; $i++)
                    <option value="{{ $i }}" {{ old('echelon') == $i ? 'selected' : '' }}>
                        {{ $i }}
                    </option>
                @endfor
            </select>
            {!! $errors->first('echelon', '<span class="error text-error">:message</span>') !!}
        </div>

        <!-- Rémunération -->
        <div class="form-group">
            <label>Indice</label>
            <input type="text" class="form-control" name="indice" value="{{ old('indice') }}">
            {!! $errors->first('indice', '<span class="error text-error">:message</span>') !!}
        </div>

        <!-- Fin de carrière -->
        <div class="form-group">
            <label>Date de prise de service</label>
            <div class="input-group date">
                <div class="input-group-addon">
                    <i class="fa fa-calendar"></i>
                </div>
                <input type="text" class="form-control datepicker" name="date_retraite" value="{{ old('date_retraite') }}">
            </div>
            {!! $errors->first('date_retraite', '<span class="error text-error">:message</span>') !!}
        </div>
    </div>
</div>