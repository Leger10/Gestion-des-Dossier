<div id="myModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">Archivage de l'agent</h4>
            </div>
            <form action="{{route('agent.destroy', $detailAgent)}}" method="POST">
                    @csrf
                    {{@method_field('DELETE')}}
            <div class="modal-body">
                <h4>Voulez-vous archiver l'agent : {{$detailAgent->prenom }} {{$detailAgent->nom }} ?</h4>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label>Type d'archivage :</label>
                            <select class="form-control" id="archive" name="typeArchive">
                                <option value="" selected disabled>Sélectionner le type d'archivage</option>
                                <option value="Décédé" >Décédé</option>
                                <option value="Démissionné" >Démissionné</option>
                                <option value="Licencié" >Licencié</option>
                                <option value="Rétraité" >Rétraité</option>
                                <option value="Revoqué" >Revoqué</option>
                                <option value="Autres" >Autres</option>
                                {{-- <option value="Licencié" >Licencié</option> --}}
                            </select>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label>Motif: </label>
                            <textarea class="form-control" placeholder="Motif..." name="motif" id="" cols="20" rows="10"></textarea>
                            {{-- <input type="text" class="form-control" name="nom" value="{{ old('nom') }}" placeholder="Saisir nom ..."> --}}
                            {!! $errors->first('nom', '<span class="error text-error">:message</span>') !!}
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                
                <button type="button" class="btn btn-primary btn-lg" data-dismiss="modal"><i class="fa fa-close"></i> Annuler</button>
                <button type="submit" class="btn btn-danger btn-lg" ><i class="fa fa-archive"></i> Archiver</button>
               
            </div>
        </form>
        </div>
    </div>
</div>
<button class="btn btn-danger btn-lg pull-right" data-toggle="modal" data-target="#myModal">
    <i class="fa fa-archive"></i>  Archiver
</button>
