


<div class="modal fade" id="createDirectionModal" tabindex="-1" role="dialog" aria-labelledby="createDirectionModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form action="{{ route('directions.store') }}" method="POST">
                @csrf
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Fermer">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h4 class="modal-title" id="createDirectionModalLabel">
                        <i class="fa fa-plus"></i> Nouvelle Direction
                    </h4>
                </div>
                
                <div class="modal-body">
                    <div class="form-group">
                        <label for="direction_name">Nom de la direction</label>
                        <input type="text" name="name" id="direction_name" class="form-control" required placeholder="Ex: DGTI">
                        <small class="text-muted">Maximum 50 caractères</small>
                    </div>
                    <div class="form-group">
                        <label for="direction_description">Description</label>
                        <textarea name="description" id="direction_description" class="form-control" rows="2" placeholder="Description optionnelle"></textarea>
                    </div>
                </div>
                
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">
                        <i class="fa fa-times"></i> Annuler
                    </button>
                    <button type="submit" class="btn btn-primary">
                        <i class="fa fa-save"></i> Enregistrer
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
