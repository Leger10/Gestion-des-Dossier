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
        <nav class="navbar-expanded-top bg-fonce shadow ">
            <div class="container">-lg fix
                <div class="navbar-brand">
                    <a href="/"> <img src="{{ asset('img/armoirie.png')}}" alt="Burkina Faso">`</a>
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
            
                    <li><a href="{{route('index')}}"><i class="fa fa-home"></i> Accueil</a></li>
                
                    @auth
                    <li><a href="{{route('accueil')}}">Vous êtes déjà connecté <i class="fa fa-user"></i></a></li>
                    @endauth
                    @guest
<li><a href="{{route('login')}}" class="connexion-noir"><i class="fa fa-user"></i> Connexion</a></li>


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
                <a href="/">
    <img src="{{ asset('img/armoirie.png') }}" alt="Burkina Faso">
</a>

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

 <!-- Modal d'information amélioré -->
<div class="modal fade" id="infoModal" tabindex="-1" role="dialog" aria-labelledby="infoModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content shadow-lg">
      <div class="modal-header bg-indigo text-white py-3">
        <h5 class="modal-title font-weight-bold" id="infoModalLabel" style="letter-spacing: 1px;">
          <i class="fas fa-folder-open mr-2"></i>DOSSIER INDIVIDUEL DU POLICIER
        </h5>
        <button type="button" class="close text-white" data-dismiss="modal">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      
      <div class="modal-body py-4" style="line-height: 1.8;">
        <div class="alert alert-light-blue mb-4">
          <p class="mb-0 text-dark">
            <i class="fas fa-info-circle mr-2 text-indigo"></i>
            Document administratif officiel contenant l'historique complet de la carrière policière.
          </p>
        </div>

        <h5 class="text-indigo mb-3 font-weight-bold">
          <i class="fas fa-file-alt mr-2"></i>Composition du dossier :
        </h5>
        
        <ul class="list-unstyled">
          <li class="mb-3 pl-4 position-relative">
            <i class="fas fa-check-circle text-success position-absolute" style="left: 0; top: 4px;"></i>
            Actes de <strong class="text-primary">nomination</strong> et d'<strong class="text-primary">affectation</strong>
          </li>
          <li class="mb-3 pl-4 position-relative">
            <i class="fas fa-check-circle text-success position-absolute" style="left: 0; top: 4px;"></i>
            Décisions de <strong class="text-primary">bonification d'échelon</strong>
          </li>
          <li class="mb-3 pl-4 position-relative">
            <i class="fas fa-check-circle text-success position-absolute" style="left: 0; top: 4px;"></i>
            <strong class="text-primary">Fiches d'évaluation</strong> périodiques
          </li>
          <li class="mb-3 pl-4 position-relative">
            <i class="fas fa-check-circle text-success position-absolute" style="left: 0; top: 4px;"></i>
            Dossier des <strong class="text-primary">sanctions disciplinaires</strong>
          </li>
          <li class="mb-4 pl-4 position-relative">
            <i class="fas fa-check-circle text-success position-absolute" style="left: 0; top: 4px;"></i>
            <strong class="text-primary">Récompenses</strong> et distinctions honorifiques
          </li>
        </ul>

        <div class="callout bg-light-indigo p-4 rounded">
          <h5 class="text-dark mb-3">
            <i class="fas fa-shield-alt mr-2 text-indigo"></i>Votre attention est importante :
          </h5>
          <p class="mb-0 text-dark">
            Ce dossier constitue la mémoire officielle de votre carrière. 
            <span class="d-block mt-2">
              Veillez à <strong class="text-indigo">vérifier régulièrement</strong> son exactitude et 
              <strong class="text-indigo">signaler</strong> toute anomalie.
            </span>   <span class="d-block "> Veuillez fermer cette fenètre et connectez-vous a la plateforme.</span>
          </p>
        </div>
      </div>

      <div class="modal-footer bg-light">
        <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">
          <i class="fas fa-times mr-2"></i>Fermer
        </button>
        
      </div>
    </div>
  </div>
</div>

<style>
.bg-indigo {
  background-color: #3f51b5 !important;
}

.bg-light-indigo {
  background-color: #e8eaf6 !important;
}

.text-indigo {
  color: #3f51b5 !important;
}

.modal-content {
  border: 2px solid rgba(63, 81, 181, 0.1);
  border-radius: 0.5rem;
}

.modal-header {
  border-bottom: 2px solid rgba(255, 255, 255, 0.1);
}

.callout {
  border-left: 4px solid #3f51b5;
}
</style>
<script>
    $(document).ready(function () {
        $('#infoModal').modal('show');
    });
</script>

</body>
</html>
