@extends('layouts.admin', ['titrePage' => 'DGTPT'])
@section('content')

    @include('partials.back-admin._nav')

    <div class="content-wrapper">
    <section class="content-header">
        <h1>
        Direction générale des collectivités territoriales
        </h1>
        <ol class="breadcrumb">
            <li class="active"><i class="fa fa-dashboard"></i> Accueil</li>
            <li class="active"><i class="fa fa-user-plus"></i> <b><strong>Agents modifiés</strong></b></li>
        </ol>
    </section>
    <section class="content">
        @include('partials._title')
        @include('partials._notification')
        @if ($listeAgent->count() > 0)
        <div class="col-md-12">
                
            </div><hr><br>
            <div class="box">

                <div class="box-body">

                    <table id="example" class="table table-striped table-bordered" style="width:100%">
                        <thead>
                            <tr class="text-white tr-bg">
                                <th>N°</th>
                                <th>Nom complet</th>
                                <th>Matricule</th>
                                <th>Emploi</th>
                                <th>Statut</th>
                                {{-- <th>Localité</th> --}}
                                <th>Modifier par </th>
                                <th>date de modification</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $n=1; ?>
                            @foreach ($listeAgent as $agents)
                            <tr>
                                <td><b>{{$n++}}</b></td>
                                <td >{{$agents->nom}} {{$agents->prenom}}</td>
                                <td>{{$agents->matricule}}</td>
                                <td>{{$agents->emploi}}</td>
                                <td>{{$agents->statut}}</td>
                                {{-- <td>{{$agents->id}}</td> --}}
                                <td>{{$agents->user_update->name}}<br>{{$agents->user_update->email}}</td>
                                <td> {{$agents->updated_at->diffForHumans()}}</td>
                                <td><a href="{{route('agent.show', $agents)}}" title="Voir information de l'agent"class="btn btn-info pull-right"><i class="fa fa-eye"></i></a></td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        @else

        <div class="row">
                <div class="col-md-12">

                    <div class="alert alert-success alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                        <h4><i class="icon fa fa-info"></i> Alert!</h4>
                        <h3><p class="text-center">Aucun agent trouvé !</p></h3>
                    </div>

                </div>

              </div>
        @endif

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
