

<div class="modal fade" id="editDirectionModal" tabindex="-1" role="dialog" aria-labelledby="editDirectionModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form id="editDirectionForm" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Fermer">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h4 class="modal-title" id="editDirectionModalLabel">
                        <i class="fa fa-edit"></i> Modifier Direction
                    </h4>
                </div>
                
                <div class="modal-body">
                    <div class="form-group">
                        <label for="edit_direction_name">Nom de la direction</label>
                        <input type="text" name="name" id="edit_direction_name" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="edit_direction_description">Description</label>
                        <textarea name="description" id="edit_direction_description" class="form-control" rows="2"></textarea>
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
