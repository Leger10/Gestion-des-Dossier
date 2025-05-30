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

    <title>{{ $titrePage ?? 'Tableau de bord' }}</title>

    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/font-awesome.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/AdminLTE.css') }}">
    <link rel="stylesheet" href="{{ asset('css/_all-skins.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/dataTables.bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/bootstrap-datepicker.css') }}">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">

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

                <div class="navbar-custom-menu">
                    <ul class="nav navbar-nav">
                        <li class="dropdown user user-menu">
                            <a href="{{ route('dashbord.edite', ['id' => 1]) }}" class="dropdown-toggle">

                                <i class="fa fa-user"></i>
                                <span class="hidden-xs">Éditer compte</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </nav>

        </header>

        @yield('content')
        @yield('scripts')

        <footer class="main-footer text-center">
            <strong>Copyright &copy; DSI/DGTI - 2025 - Tous droits réservés -
                <a href="#">Ministère de l'Administration Territoriale de la Décentralisation et de la Sécurité</a>
            </strong>
        </footer>
    </div>
    <!-- Bootstrap 5 JS et Popper.js (CDN) -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
        integrity="sha384-QFzoGiFcj8eCp1mrSKM4YDyUKrx9q7kYFCkx0VqBv0UL1kW8hOcS9ssbL7yjE1xB" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"
        integrity="sha384-+5CxN7D5w0a9zU/h0kFmpUNVYvPtOV6JxLSDpYbqK/Jyhbwvq/rIGCiMdH0OYogS" crossorigin="anonymous">
    </script>

    <script type="text/javascript" src="{{ asset('js/jquery.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('js/bootstrap-datepicker.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/jquery.slimscroll.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/adminlte.min.js') }}"></script>
    @stack('scripts.footer')
</body>

</html>