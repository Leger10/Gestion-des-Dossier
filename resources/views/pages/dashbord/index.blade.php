@extends('layouts.admin', ['titrePage' => 'DGTI'])
@section('content')

    @include('partials.back-admin._nav')
    {{-- -----End menu--------- --}}
    <div class="content-wrapper">
    <section class="content-header">
        <h1>        
            Direction générale des transmissions et de l'informatique
        </h1>
        <ol class="breadcrumb">
            <li class="active"><i class="fa fa-dashboard"></i> Accueil</li>
            @if (/* Condition pour vérifier si c'est une Direction ou un Service */)
                <li class="active"><i class="fa fa-folder-open"></i> <b><strong>Liste agents des directions archivées</strong></b></li>
            @else
                <li class="active"><i class="fa fa-folder-open"></i> <b><strong>Liste agents des services archivés</strong></b></li>
            @endif
        </ol>
    </section>

    <section class="content">
        @include('partials._title')
        @include('partials._notification')

        <div class="box">
            <div class="box-header">
                <h3 class="box-title ">Directions : Liste des agents archivés </h3>
                <h3 class="box-title ">Services : Liste des agents archivés</h3>
            </div>
            <div class="box-body">
                <table id="example" class="table table-striped table-bordered" style="width:100%">
                    <thead>
                        <tr class="text-white tr-bg">
                            <th>N°</th>
                            <th>Nom complet</th>
                            <th>Matricule</th>
                            <th>Archivé par</th>
                            <th>Date</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $n=1; ?>
                        @foreach ($listeAgent as $itemAgent)
                        <tr>
                            <td><b>{{$n++}}</b></td>
                            <td>{{$itemAgent->nom}} {{$itemAgent->prenom}}</td>
                            <td>{{$itemAgent->matricule}}</td>
                            <td>{{$itemAgent->user_delete->name}}<br>{{$itemAgent->user_delete->email}}</td>
                            <td> {{$itemAgent->updated_at->format('d-m-Y H:m')}}</td>
                            <td><a href="{{route('agent.show', $itemAgent)}}" title="Voir information de l'agent" class="btn bg-red pull-right"><i class="fa fa-eye"></i></a></td>
                        </tr>
                        @endforeach
                </table>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="alert alert-success alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    <h4><i class="icon fa fa-info"></i> Alert!</h4>
                    <h3><p class="text-center">Aucun agent trouvé !</p></h3>
                </div>
            </div>
        </div>

    </section>
    </div>
@endsection

@push('scripts.footer')
<script type="text/javascript" src="{{asset('js/jquery.dataTables.min.js')}}"></script>
<script type="text/javascript" src="{{asset('js/dataTables.bootstrap.min.js')}}"></script>
<script>
$(document).ready(function() {
    $('#example').DataTable();
} );
</script>
@endpush
