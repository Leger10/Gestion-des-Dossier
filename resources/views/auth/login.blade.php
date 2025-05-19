@extends('layouts.master', ['titrePage'=>'Connectez-vous'])
@section('content')
<section class="page-content">
        <div class="container  text-white text-md-left">
            <div class="row">    
            <div class="col-md-6 mt-md-0 mt-3">
                <div class="welcome-container">
    <div class="text-3d">
        <span class="letter" data-letter="A">A</span>
        <span class="letter" data-letter="p">p</span>
        <span class="letter" data-letter="p">p</span>
        <!-- Continuez pour chaque lettre -->
        <span class="letter" data-letter="D">D</span>
        <span class="letter" data-letter="G">G</span>
        <span class="letter" data-letter="T">T</span>
        <span class="letter" data-letter="I">I</span>
    </div>
    <p class="connect-text">Pour avoir accès à l'application. Connectez-vous !</p>
</div>

<style>
    .welcome-container {
        perspective: 1000px;
        text-align: center;
        padding: 50px 20px;
    }
    
    .text-3d {
        display: inline-block;
        font-size: 3rem;
        font-weight: bold;
        color: #3498db;
        margin-bottom: 30px;
    }
    
    .letter {
        display: inline-block;
        position: relative;
        transform-style: preserve-3d;
        animation: float 3s ease-in-out infinite;
        margin: 0 2px;
        text-shadow: 2px 2px 4px rgba(0,0,0,0.3);
    }
    
    .connect-text {
        font-size: 1.5rem;
        color: #7f8c8d;
        animation: pulse 2s infinite alternate;
    }
    
    @keyframes float {
        0%, 100% {
            transform: translateY(0) rotateX(0) rotateY(0);
        }
        50% {
            transform: translateY(-15px) rotateX(10deg) rotateY(5deg);
        }
    }
    
    @keyframes pulse {
        from {
            transform: scale(1);
            opacity: 0.8;
        }
        to {
            transform: scale(1.05);
            opacity: 1;
        }
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const letters = document.querySelectorAll('.letter');
        
        letters.forEach((letter, index) => {
            // Applique un délai différent à chaque lettre
            letter.style.animationDelay = `${index * 0.1}s`;
            
            // Effet au survol
            letter.addEventListener('mouseover', () => {
                letter.style.transform = 'translateY(-20px) rotateX(20deg) rotateY(20deg)';
                letter.style.color = '#e74c3c';
            });
            
            letter.addEventListener('mouseout', () => {
                letter.style.transform = '';
                letter.style.color = '#3498db';
            });
        });
    });
</script>
            </div>

            <div class="col-md-6 mt-md-0 mt-3">

                    <div class="card shadow-sm bg-light">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6 col-md-offset-5">
                                        <img src="img/user.png" alt="user_logo" height="120">
                                    </div>
                                </div>
                                <h5 class="card-title text-center">CONNECTEZ-VOUS</h5><hr><br>

                                <div class="login-box">
                                    <form method="POST" action="{{ route('login') }}">
                                        @csrf

                                        <div class="form-group has-feedback">

                                            <input type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" placeholder="Adresse E-mail" required autofocus>
                                            <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
                                            @if ($errors->has('email'))
                                                <span class="invalid-feedback" style="color:red;" role="alert">
                                                    <strong>{{ $errors->first('email') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                        <div class="form-group has-feedback">
                                            <input type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" placeholder="Mot de passe" name="password" required>
                                            <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                                            @if ($errors->has('password'))
                                                <span class="invalid-feedback" style="color:red;" role="alert">
                                                    <strong>{{ $errors->first('password') }}</strong>
                                                </span>
                                            @endif
                                        </div><br>
                                        <div class="row">
                                            {{-- <div class="col-xs-8">
                                                <div class="checkbox icheck">
                                                    <label>
                                                    <input type="checkbox"> Se rappeler de moi
                                                    </label>
                                                </div>
                                            </div> --}}
                                            <div class="col-xs-4 col-sm-offset-8">
                                                <button type="submit" class="btn btn-primary btn-block btn-flat">Se connecter</button>
                                            </div>
                                        </div>
                                    </form>

                                    {{-- @if (Route::has('password.request'))
                                        <a href="{{ route('password.request') }}">
                                            {{ __('Mot de passe oublié ?') }}
                                        </a>
                                    @endif --}}

                                </div>
                            </div>

            </div>


            <hr class="clearfix w-100 d-md-none pb-3">
        </div>
<section>
@endsection
