@extends('layouts.admin', ['titrePage' => 'DGTPT'])
@section('content')

    @include('partials.back-admin._nav')
    {{-- -----End menu--------- --}}
    <div class="content-wrapper">
    <section class="content-header">
        <h1>Direction générale des collectivités territoriales</h1>
        <ol class="breadcrumb">
        <li class="active"><i class="fa fa-dashboard"></i> Accueil</li>
        {{-- @if ($id_zone === '1')
        <li class="active"><i class="fa fa-folder-open"></i> <b><strong>Agents des régions supprimés</strong></b></li>
        @else
        <li class="active"><i class="fa fa-folder-open"></i> <b><strong>Agents des communes supprimés</strong></b></li>
        @endif --}}
        </ol>
    </section>
    <section class="content">
        @include('partials._title')
        @include('partials._notification')
        @if ($users->count() > 0)

            <div class="box">
                <div class="box-header">
                <h3 class="box-title">La Liste Des Utilisateurs </h3>
            </div>

            <div class="box-body">

                <table id="example" class="table table-striped table-bordered" style="width:100%">
                    <thead>
                        <tr class="text-white tr-bg">
                        <th>N°</th>
                        <th>Nom complet</th>
                        <th>E-mail</th>
                        <th>Statut </th>
                        <th>date de modification</th>
                        <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $n=1; ?>
                        @foreach ($users as $user)
                        <tr>
                            <td><b>{{$n++}}</b></td>
                            <td>{{$user->name}}</td>
                            <td>{{$user->email}}</td>
                            @if ($user->is_admin === 1)
                            <td>{{$user->role}}</td>
                            @else
                            <td>{{$user->role}}</td>
                            @endif
                            <td> {{\Carbon\Carbon::parse($user->updated_at)->diffForHumans() }} </td>
                            <td><a href="{{route('dashbord.edite', $user)}}" title="Voir information de l'agent" class="btn btn-info pull-right"><i class="fa fa-eye"></i></a></td>
                        </tr>
                        @endforeach
                    </tbody>    
                </table>
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
