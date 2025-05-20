

<div class="modal fade" id="editServiceModal" tabindex="-1" role="dialog" aria-labelledby="editServiceModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form id="editServiceForm" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Fermer">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h4 class="modal-title" id="editServiceModalLabel">
                        <i class="fa fa-edit"></i> Modifier Service
                    </h4>
                </div>
                
                <div class="modal-body">
                    <div class="form-group">
                        <label for="edit_service_direction_id">Direction</label>
                        <select name="direction_id" id="edit_service_direction_id" class="form-control" required>
                            @foreach($directions as $direction)
                                <option value="{{ $direction->id }}">{{ $direction->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="edit_service_name">Nom du service</label>
                        <input type="text" name="name" id="edit_service_name" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="edit_service_description">Description</label>
                        <textarea name="description" id="edit_service_description" class="form-control" rows="2"></textarea>
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
