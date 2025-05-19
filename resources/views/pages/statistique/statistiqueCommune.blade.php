@extends('layouts.admin', ['titrePage' => 'DGTPT'])
@section('content')

    @include('partials.back-admin._nav')
    {{-- -----End menu--------- --}}
    <div class="content-wrapper">
    <section class="content-header">
        <h1>Direction générale des collectivités territoriales</h1>
        <ol class="breadcrumb">
            <li class="active"><i class="fa fa-home"></i> Accueil</li>
            <li class="active"><i class="fa fa-dashboard"></i> Dashbord</li>
            <li class="active"><i class="fa fa-pie-chart"></i> <b><strong>Statistiques des communes</strong></b></li>
        </ol>
    </section>
    <section class="content">
        @include('partials._title')
        @include('partials._notification')
            <h3>Liste des communes avec le nombre d'agents</h3>
            <div class="row">
                @foreach ($collectivites as $commune)
                    <div class="col-xs-12 col-md-6 col-lg-3">
                        <div class="card text-center">
                            <br>
                            <div class="card-block">
                                <h4 class="card-title info-box-number">{{$commune->libelle}}</h4>
                                <p class="card-text info-box-number"><small>
                                    @if ($commune->agents->where('rattachement_type_id', 2)->count()<=1)
                                        {{$commune->agents->where('rattachement_type_id', 2)->count()}} Agent
                                    @else
                                    {{$commune->agents->where('rattachement_type_id', 2)->count()}} Agents
                                    @endif
                                </small></p>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="row">
                <div class="pull-right">{{ $collectivites->links() }}</div>
            </div>
        </section>
    </div>
@endsection
