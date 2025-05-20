
<div class="modal fade" id="createServiceModal" tabindex="-1" role="dialog" aria-labelledby="createServiceModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form action="{{ route('services.store') }}" method="POST">
                @csrf
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Fermer">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h4 class="modal-title" id="createServiceModalLabel">
                        <i class="fa fa-plus"></i> Nouveau Service
                    </h4>
                </div>
                
                <div class="modal-body">
                    <div class="form-group">
                        <label for="service_direction_id">Direction</label>
                        <select name="direction_id" id="service_direction_id" class="form-control" required>
                            <option value="">Sélectionnez une direction</option>
                            @foreach($directions as $direction)
                            <option value="{{ $direction->id }}">{{ $direction->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="service_name">Nom du service</label>
                        <input type="text" name="name" id="service_name" class="form-control" required placeholder="Ex: Secrétariat particulier">
                        <small class="text-muted">Maximum 50 caractères</small>
                    </div>
                    <div class="form-group">
                        <label for="service_description">Description</label>
                        <textarea name="description" id="service_description" class="form-control" rows="2" placeholder="Description optionnelle"></textarea>
                    </div>
                </div>
                
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">
                        <i class="fa fa-times"></i> Annuler
                    </button>
                    <button type="submit" class="btn btn-success">
                        <i class="fa fa-save"></i> Enregistrer
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
