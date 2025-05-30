@extends('layouts.admin', ['titrePage' => 'DGTI'])
@section('content')
    @include('partials.back-admin._nav')
    {{-- -----End menu--------- --}}
    <div class="content-wrapper">
        <section class="content-header">
            <h1>
                {{--         Direction générale des transmissions et de l'informatique --}}
            </h1>
            <ol class="breadcrumb">
                <li class="active"><i class="fa fa-user-plus"></i> <b><strong>Accueil</strong></b></li>
            </ol>
        </section>
        <section class="content">
            <div class="callout callout-info">
                {{-- <h4>Gestion de la base de données des effectifs des collectivités territoriales de la DGTI</h4> --}}
            </div>

            <section class="content-header">
                <ul class="nav nav-tabs">
                    <li class="nav-item">
                        <a href="#">Dashbord</a>
                    </li>
                    <li class="nav-item">
                        <a class="act" href="#">Agent supprimé</a>
                    </li>
                </ul>
            </section><br>

            <div class="container">
                <div class="row">
                    <div class="col-md-6">
                        <div class="div2">
                            <a href="{{route('directions')}}" class="btn btn-primary center-block">
                                <i class="fa fa-edit"></i> Région
                            </a>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="div2">
                            <a href="{{route('services')}}" class="btn btn-primary center-block">
                                <i class="fa fa-edit"></i> Commune
                            </a>
                        </div>
                    </div>
                </div>

                {{-- Ajout d'une section d'archivage pour les agents --}}
                <div class="row mt-5">
                    <div class="col-md-12">
                        <h4>Gestion des Agents Archivés</h4>
                        {{-- Liste des agents avec un bouton pour archiver --}}
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Nom</th>
                                    <th>Email</th>
                                    <th>Rôle</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($agents as $agent)
                                    <tr>
                                        <td>{{ $agent->name }}</td>
                                        <td>{{ $agent->email }}</td>
                                        <td>{{ $agent->role }}</td>
                                        <td>
                                            {{-- Bouton pour archiver un agent --}}
                                            <form action="{{ route('agents.archive', $agent->id) }}" method="POST" style="display: inline;">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit" class="btn btn-warning">
                                                    <i class="fa fa-archive"></i> Archiver
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </section>
    </div>
@endsection

@push('scripts.footer')
    <script type="text/javascript" src="{{asset('js/chartAnnexe.js')}}"></script>
@endpush
