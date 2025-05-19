@extends('layouts.master', ['titrePage'=>'Connectez-vous'])
@section('content')
<section class="page-content">
        <div class="container">
            <div class="row">
                <div class="col-md-5">
                    <div class="h3 fine"> <br><br><br>
                        Réinitialiser votre mot de passe pour Demande Attestation de Soumission au Marché Public
                    </div>
                </div>
                <div class="col-md-7">
                    <div class="card shadow-sm bg-light">
                        <div class="card-body">
                            <h5 class="card-title text-center">SAISISSEZ VOTRE ADRESSE E-MAIL</h5><hr><br>

                            <div class="card-body">
                                @if (session('status'))
                                    <div class="alert alert-success" role="alert">
                                        {{ session('status') }}
                                    </div>
                                @endif

                                <form method="POST" action="{{ route('password.email') }}">
                                    @csrf

                                    <div class="form-group row">
                                        <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('Adresse E-mail') }}</label>

                                        <div class="col-md-6">
                                            <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" required>

                                            @if ($errors->has('email'))
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('email') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="form-group row mb-0">
                                        <div class="col-md-6 offset-md-4">
                                            <button type="submit" class="btn btn-success">
                                               <i class="material-icons right">send</i> {{ __('Soumettre') }}
                                            </button>
                                        </div>
                                    </div>
                                </form>

                        </div>
                    </div>
                </div>
            </div>
            {{-- <div class="row">
                <div class="col-md-12">
                    <h1><br></h1>
                </div>
            </div> --}}
        </div>
    <section>
@endsection
