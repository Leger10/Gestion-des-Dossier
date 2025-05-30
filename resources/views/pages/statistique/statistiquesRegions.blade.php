@extends('layouts.admin', ['titrePage' => 'DGTI'])
@section('content')

@include('partials.back-admin._nav')
    <div class="content-wrapper">
        <section class="content-header">
            <h1>
            Direction générale des transmissions et de l'informatique
            </h1>
            <ol class="breadcrumb">
                <li class="active"><i class="fa fa-home"></i> Accueil</li>
                <li class="active"><i class="fa fa-dashboard"></i> Dashbord</li>
                <li class="active"><i class="fa fa-pie-chart"></i> <b><strong>Statistiques des régions</strong></b></li>
            </ol>
        </section>
        <section class="content">
        <div class="callout callout-info">
            <h4>Gestion de la base de données des effectifs de la DGTI</h4>
        </div>


        <div id="app" style="background: #fff; ">
            {!! $chart->container() !!}
        </div>
    </div>
@endsection
@push('scripts.footer')
 {!! $chart->script() !!}
<script type="text/javascript" src="{{asset('js/Chart.js')}}"></script>
@endpush
