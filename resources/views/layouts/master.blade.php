<!DOCTYPE html>
<html lang="fr">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="keywords" content="Collectivité territoriales">
	<meta name="robots" content="">
	<meta name="description" content="">
	<meta property="og:title" content="">
	<meta property="og:description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ $titrePage }}</title>

    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">

	<link rel="stylesheet" type="text/css" href="{{ asset('css/style.css') }}">
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700" rel="stylesheet">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link href="{{asset('images/coat-of-arms-of-burkina-faso.png')}}" rel="icon">
    <link rel="stylesheet" href="{{ asset('css/font-awesome.min.css') }}">
    <style>
        .connexion-noir {
            color: #028743; /* Noir pur */
            text-decoration: none; /* Enlever la sous-ligne si nécessaire */
        }
    </style>
</head>
<body>
  <header>
      <div class="page-wraper">
        <nav class="navbar-expand-lg fixed-top bg-fonce shadow ">
            <div class="container">
                <div class="navbar-brand">
                    <a href="#"> <img src="{{ asset('img/armoirie.png')}}" alt="Burkina Faso">`</a>
                    <h5 class="text-white text-left"> <a href="/" style="color:#FFF;">Ministère de l'Administration Territoriale et de la Sécurité</a><br>
                      <small class="text-muted text-ombre ">Direction générale des transmissions et de l'informatique </small>
                    </h5>
                </div>
            </div>
          </nav>
          <nav class="navbar navbar-default" >
            <div class="container-fluid">
                <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                </div>
                <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                
                <ul class="nav navbar-nav navbar-right" style="font-size: 1.2em;">
                    @if (Route::is('accueil'))
                    <li><a href="{{route('index')}}"><i class="fa fa-home"></i> Accueil</a></li>
                    @endif
                    @auth
                    <li><a href="{{route('accueil')}}">Vous êtes déjà connecté <i class="fa fa-user"></i></a></li>
                    @endauth
                    @guest
<li><a href="{{route('accueil')}}" class="connexion-noir"><i class="fa fa-user"></i> Connexion</a></li>


                    @endguest
                </ul>
                </div>
            </div>
        </nav>
      </div>
  </header>

  <main>
      @yield('content')
       @yield('front-end')
  </main>

    <footer class="page-footer font-small pt-5">
        <div class="container text-center text-white text-md-left">
            <div class="row">
            <div class="col-md-6 mt-md-0 mt-3">
                <a href="/"><img src="{{ asset('img/armoirie.png')}}" alt="Burkina Faso"></a>
                <h5 class="text-uppercase" style="color:#FFF;">Direction générale des transmissions et de l'informatique  </h5>
                <hr />
            </div>
            <div class="footer-copyright text-center py-3 text-light" style="color:#FFF;"><small> Ministère de l'Administration Territoriale et de la Sécurité</small></div>
            {{-- <hr class="clearfix w-100 d-md-none pb-3"> --}}
        </div>
    
        <div class="footer-copyright text-center py-3 text-light" style="color:#FFF;"><small>Copyright &copy; -2025 Tous droits réservés  - Propulsé par <a href="https://www.digihouse10@mail.com" target="_blank"></a>DSI/DGTI</small></div>
    

    </footer>    
          <script src="{{ asset('js/jquery.min.js') }}"></script>
        {{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script> --}}
        <script src="{{ asset('js/bootstrap.min.js') }}"></script>

        @stack('scripts.footer')
</body>
</html>
