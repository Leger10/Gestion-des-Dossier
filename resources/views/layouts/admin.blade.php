<!DOCTYPE html>
<html lang="fr">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="keywords" content="">
	<meta name="author" content="">
	<meta name="robots" content="">
	<meta name="description" content="">
	<meta property="og:title" content="">
	<meta property="og:description" content="">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

    <title>{{ $titrePage }}</title>

    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">

    <link rel="stylesheet" href="{{ asset('css/font-awesome.min.css') }}">

    <link rel="stylesheet" href="{{ asset('css/AdminLTE.css') }}">

    <link rel="stylesheet" href="{{ asset('css/_all-skins.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/dataTables.bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/bootstrap-datepicker.css') }}">

    <link rel="stylesheet" href="{{ asset('css/font-awesome.min.css') }}">
</head>
<body class="hold-transition skin-blue fixed sidebar-mini">
    <div class="wrapper">
        <header class="main-header">

            <a href="#" class="logo">
                <span class="logo-mini"><b>DGTI</b></span>
                <span class="logo-lg"><b>DGTI</b></span>
            </a>
            <nav class="navbar navbar-static-top">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                </a>

                <div class="navbar-custom-menu">
                <ul class="nav navbar-nav">

                    <li class="dropdown user user-menu">
                        {{-- <a class="dropdown-item" href="{{route('dashbord.edite', Auth::user() )}}"
                            onclick="event.preventDefault();
                                          document.getElementById('logout-form').submit();">
                            <i class="fa fa-user"></i>
                             {{ __(Auth::user()->name ) }}
                         </a>

                         <form id="logout-form" action="{{route('dashbord.edite', Auth::user() )}}" method="POST" style="display: none;">
                             @csrf
                         </form> --}}

                        <a href="{{route('dashbord.edite', Auth::user() )}}"  class="dropdown-toggle">
                            <i class="fa fa-user"></i>
                            <span class="hidden-xs">Editer compte</span>
                        </a>

                    </li>

                </ul>
                </div>
            </nav>

        </header>

        @yield('content')

        <footer class="main-footer text-center">
            <strong>Copyright &copy; DSI/DGTI -2025 - Tous droits réservés - <a href="#">Ministère de l'Administration Territoriale de la decentralisation et de la sécurité</a></strong>
        </footer>
    </div>
    <script type="text/javascript" src="{{asset('js/jquery.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('js/bootstrap.min.js')}}"></script>
    <script src="{{ asset('js/bootstrap-datepicker.min.js') }}"></script>
    <script type="text/javascript" src="{{asset('js/jquery.slimscroll.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('js/adminlte.min.js')}}"></script>
    @stack('scripts.footer')
</body>
</html>
