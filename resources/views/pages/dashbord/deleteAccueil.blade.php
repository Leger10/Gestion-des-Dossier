@extends('layouts.admin', ['titrePage' => 'DGTPT'])
@section('content')
    @include('partials.back-admin._nav')
    {{-- -----End menu--------- --}}
<div class="content-wrapper">
    <section class="content-header">
        <h1>
        {{-- Direction générale des collectivités territoriales --}}
        </h1>
        <ol class="breadcrumb">
        <li class="active"><i class="fa fa-user-plus"></i> <b><strong>Accueil</strong></b></li>
        </ol>
    </section>
    <section class="content">
        <div class="callout callout-info">
            {{-- <h4>Gestion de la base de données des effectifs des collectivités territoriales de la DGFPT</h4> --}}
        </div>

        <section class="content-header">
            <ul class="nav nav-tabs">
                <li class="nav-item">
                    <a  href="#">Dashbord</a>
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
                                <a href="{{route('regions')}}" class="btn btn-primary center-block"><i class="fa fa-edit"></i> Région</a>
                            </div>
                </div>
                <div class="col-md-6">
                        <div class="div2">
                                <a href="{{route('regions')}}" class="btn btn-primary center-block"><i class="fa fa-edit"></i> Commune</a>
                            </div>
                </div>
            </div>

    </div>

    </section>
</div>
@endsection

@push('scripts.footer')
    <script type="text/javascript" src="{{asset('js/chartAnnexe.js')}}"></script>
@endpush
