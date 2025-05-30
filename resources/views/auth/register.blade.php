@extends('layouts.admin', ['titrePage' => 'DGTI'])

@section('content')
    @include('partials.back-admin._nav')

    <div class="content-wrapper">
        <section class="content-header">
            <h1>
                Direction générale des transmissions et de l'informatique
            </h1>
            <ol class="breadcrumb">
                <li class="active"><i class="fa fa-dashboard"></i></i> <b><strong>Accueil</strong></b></li>
            </ol>
        </section>

        <section class="content">
            @include('partials._title')

            <div class="row">
                @include('partials._notification')

                <div class="col-md-5">
                    <div class="row">
                        <div class="col-md-6 col-md-offset-3">
                            <img src="img/user.png" alt="user_logo" height="250">
                            <div class="h3 fine"></div>
                        </div>
                        <div class="col-md-12">
                            <div class="h3 fine">
                                Pour créer un compte utilisateur, veuillez remplir les champs suivants.
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="box box-primary">
                            <div class="box-body">
                                <div class="form-group">
                                    <h5 class="card-title text-center text-bold text-uppercase">Création compte utilisateur</h5>
                                    <hr><br>

                                    <form method="POST" action="{{ route('register') }}">
                                        @csrf

                                        <div class="form-group row">
                                            <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Nom complet') }}</label>
                                            <div class="col-md-8">
                                                <input id="name" type="text" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" value="{{ old('name') }}" required autofocus>

                                                @if ($errors->has('name'))
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $errors->first('name') }}</strong>
                                                    </span>
                                                @endif
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('Adresse e-mail') }}</label>
                                            <div class="col-md-8">
                                                <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" required>

                                                @if ($errors->has('email'))
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $errors->first('email') }}</strong>
                                                    </span>
                                                @endif
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Mot de passe') }}</label>
                                            <div class="col-md-8">
                                                <input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" required>

                                                @if ($errors->has('password'))
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $errors->first('password') }}</strong>
                                                    </span>
                                                @endif
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label for="password-confirm" class="col-md-4 col-form-label text-md-right">{{ __('Confirmer Mot de passe') }}</label>
                                            <div class="col-md-8">
                                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required>
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label for="role" class="col-md-4 col-form-label text-md-right">{{ __('Rôle') }}</label>
                                            <div class="col-md-8">
                                                <select class="form-control" id="role" name="role">
                                                    <option value="" selected disabled>Sélectionner le rôle</option>
                                                    <option value="Administrateur">Administrateur</option>
                                                    <option value="Superviseur">Superviseur</option>
                                                    <option value="Secretaire">Secrétaire</option>
                                                </select>

                                                @if ($errors->has('role'))
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $errors->first('role') }}</strong>
                                                    </span>
                                                @endif
                                            </div>
                                        </div>

                                        <div class="form-group row mb-0 text-center">
                                            <div class="col-md-12">
                                                <a href="{{ route('dashbord.accueil') }}" class="btn btn-danger">
                                                    <i class="fa fa-close"></i> Annuler
                                                </a>
                                                <button type="submit" class="btn btn-success">
                                                    <i class="fa fa-check"></i> {{ __('Enregistrer') }}
                                                </button>
                                                <br><br>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
