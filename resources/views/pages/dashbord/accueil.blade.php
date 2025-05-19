@extends('layouts.admin', ['titrePage' => 'DGTI'])
@section('content')
    @include('partials.back-admin._nav')
    {{-- -----End menu--------- --}}
<div class="content-wrapper">
    <section class="content-header">
        <h1>
        Direction generale des transmissions et de l'informatique
        </h1>
        <ol class="breadcrumb">
        <li class="active"><i class="fa fa-dashboard"></i></i> <b><strong>Dashbord</strong></b></li>
        </ol>
    </section>
    <section class="content">
        @include('partials._title')

        <div class="row">

            @if (Auth::user()->role <> 'Lecteur')
            <div class="col-lg-3 col-xs-6">
                    <div class="small-box bg-aqua">
                        <div class="inner">
                        <h3>compte</h3>
    
                        <p>Création de compte agents</p>
                        </div>
                        <div class="icon">
                            <i class="fa fa-user-plus"></i>
                        </div>
                        <a href="{{ route('register') }}" class="small-box-footer">
                        Voir <i class="fa fa-arrow-circle-right"></i>
                        </a>
                    </div>
                </div>
    
                <div class="col-lg-3 col-xs-6">
                    <div class="small-box bg-green">
                        <div class="inner">
                        <h3>Agents</h3>
    
                        <p>La liste des agents</p>
                        </div>
                        <div class="icon">
                            <i class="fa fa-user"></i>
                        </div>
                        <a href="{{ route('dashbord.utilisateur') }}" class="small-box-footer">
                        Voir <i class="fa fa-arrow-circle-right"></i>
                        </a>
                    </div>
                </div> 
            @endif

            <div class="col-lg-3 col-xs-6">
                <div class="small-box bg-green">
                    <div class="inner">
                    <h3>Agents archivés</h3>

                    <p>Liste des agents par direction archivés</p>
                    </div>
                    <div class="icon">
                        <i class="fa fa-archive"></i>
                    </div>
                    <a href="{{route('dashbord.region')}}" class="small-box-footer">
                    Voir <i class="fa fa-arrow-circle-right"></i>
                    </a>
                </div>
            </div>

            <div class="col-lg-3 col-xs-6">
                <div class="small-box bg-aqua">
                    <div class="inner">
                    <h3>Agents archivés</h3>

                    <p>Liste des agents archivés</p>
                    </div>
                    <div class="icon">
                        <i class="fa fa-archive"></i>
                    </div>
                    <a href="{{route('dashbord.commune')}}" class="small-box-footer">
                    Voir <i class="fa fa-arrow-circle-right"></i>
                    </a>
                </div>
            </div>

        </div>

        <div class="row">

            <div class="col-lg-4 col-xs-6">
                <div class="small-box bg-green">
                    <div class="inner">
                    <h3>Agents modifiés</h3>
                    <p>La liste des agents modifiés</p>
                    </div>
                    <div class="icon">
                        <i class="fa fa-user"></i>
                    </div>
                    <a href="{{route('dashbord.updat')}}" class="small-box-footer">
                    Voir <i class="fa fa-arrow-circle-right"></i>
                    </a>
                </div>
            </div>
            <div class="col-lg-4 col-xs-6">
                    <div class="small-box bg-aqua">
                        <div class="inner">
                        <h3>Statistiques<br>Directions</h3>
                        <p>Statistiques par directions</p>
                        </div>
                        <div class="icon">
                            <i class="fa fa-bar-chart"></i>
                        </div>
                        <a href="{{route('statistique.region')}}" class="small-box-footer">
                        Voir <i class="fa fa-arrow-circle-right"></i>
                        </a>
                    </div>
                </div>
                <div class="col-lg-4 col-xs-6">
                    <div class="small-box bg-green">
                        <div class="inner">
                        <h3>Statistiques<br>Services</h3>
                        <p>Statistiques par services</p>
                        </div>
                        <div class="icon">
                            <i class="fa fa-bar-chart"></i>
                        </div>
                        <a href="{{route('statistique.commune')}}" class="small-box-footer">
                        Voir <i class="fa fa-arrow-circle-right"></i>
                        </a>
                    </div>
                </div>

        </div>
    </section>
</div>
@endsection