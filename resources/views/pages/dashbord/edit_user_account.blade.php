@extends('layouts.admin', ['titrePage' => 'DGTPT'])
@section('content')
    @include('partials.back-admin._nav')
    {{-- -----End menu--------- --}}
    <div class="content-wrapper">
    <section class="content-header">
        <h1>
        Direction générale des collectivités territoriales
        </h1>
        <ol class="breadcrumb">
        <li class="active"><i class="fa fa-edit"></i> <b><strong>Editer compte</strong></b></li>
        </ol>
    </section>
    <section class="content">
        @include('partials._title')
        <form action="{{route('dashbord.user_upadate', $user)}}" method="POST">
            @csrf
           
            <div class="row">
                <div class="col-md-6">
                    <div class="box box-primary">
                        <div class="box-header with-border">
                            <h3 class="box-title">Information personnelle de l'agent</h3>
                        </div>
                        <div class="box-body">
                            <div class="form-group">
                                <label>Nom complet:</label>
                                <input type="text" class="form-control" name="nom" value="{{$user->name }} " >
                                {!! $errors->first('nom', '<span class="error text-error">:message</span>') !!}
                            </div>
                            <div class="form-group">
                                <label id="email">Adresse e-mail:</label>
                                <input id="email" type="text" class="form-control" name="email" value="{{$user->email }}" readonly>
                                {!! $errors->first('email', '<span class="error text-error">:message</span>') !!}
                            </div>

                            <div class="form-group">
                                <label>Date de creation:</label>
                                <input type="text" class="form-control"  value="{{$user->created_at->format('d/m/Y') }}" readonly>
                            </div>

                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    @if (Auth::user()->is_admin === 1 )
                    <div class="box box-primary">
                        <div class="box-header with-border">
                            <h3 class="box-title">Statut du Compte</h3>
                        </div>
                        <div class="box-body">
                        <div class="form-group">
                            <label>
                                <input type="radio" name="radio_type" value=1  <?php if($user->is_admin === 1) { echo 'checked'; } ?>>
                                Administrateur
                            </label><br>
                            <label>
                                <input type="radio" name="radio_type" value=0  <?php if($user->is_admin === 0) { echo 'checked'; } ?>>
                                Utilisateur
                            </label>
                            {!! $errors->first('radio_type', '<span class="error text-error">:message</span>') !!}
                        </div>
                        </div>
                    </div>
                    @endif
                    <div class="box box-primary">
                        <div class="box-header with-border">
                            <h3 class="box-title">Modifier votre mot de paase</h3>
                        </div>
                        <div class="box-body">
                            <div class="form-group row"><br>
                                <input type="hidden" name="password" class="form-control" value="{{$user->password}}" >
                                <label for="password-confirm" class="col-md-6 col-form-label text-md-right">
                                    <input type="checkbox" id="check" onclick="detecter()">
                                    Cocher pour modifier le mot de passe</label>
                                <div class="col-md-12">
                                    <div style="display:none;" id="bloc">
                                        <div class="box-body">
                                            <div class="form-group">
                                                <label>Nouveau mot de passe:</label>
                                                <input type="password" class="form-control" name="newsPassword"  >
                                                {!! $errors->first('newsPassword', '<span class="error text-error">:message</span>') !!}
                                            </div>
                                            <div class="form-group">
                                                <label>Confirmer mot de passe:</label>
                                                <input type="password" class="form-control" name="replyPassword" >
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <a href="{{URL::previous()}}" class="btn btn-danger btn-lg pull-left"><i class="fa fa-reply"></i> Retour</a>
                    <button type="submit" class="btn btn-info btn-lg pull-right"><i class="fa fa-refresh"></i> Mettre à jour</button>
                </div>
            </div>

        </form>

    </section>
    </div>
@endsection
@push('scripts.footer')
<script>
    function detecter(){
        if(document.getElementById('check').checked){
            document.getElementById('bloc').style.display='inline';
        }
        else{
            document.getElementById('bloc').style.display='none';
        }
    }
</script>
@endpush
