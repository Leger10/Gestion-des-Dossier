<aside class="main-sidebar">
    <section class="sidebar">

        <div class="user-panel">
        <div class="pull-left image">
            <img src="{{ asset('img/coat-of-arms-of-burkina-faso.png') }}"  alt="User Image">
        </div>
        <div class="pull-left info">
            {{--  <p> {{Auth::user()->name}}</p>  --}}
            <a href="#"><i class="fa fa-circle text-success"></i> Connecté</a>
        </div>
        </div>
        <form action="#" method="get" class="sidebar-form">
        {{-- <div class="input-group">
            <input type="text" name="q" class="form-control" placeholder="Search...">
                <span class="input-group-btn">
                <button type="submit" name="search" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i>
                </button>
                </span>
        </div> --}}
        </form>
        <ul class="sidebar-menu" data-widget="tree">

        <li class="header">MENU PRINCIPALE</li>

        <li >
        <a href="{{route('accueil')}}">
            <i class="fa fa-home"></i> <span>Accueil</span>
            </a>
        </li>
       {{--  @if (Auth::user()->role <> 'Lecteur')  --}}
       <li>
            <a href="{{route('agent.create')}}">
            <i class="fa fa-user-plus"></i> <span>Nouvel agent</span>
            </a>
        </li>
       {{--  @endif  --}}
        {{--  @if (Auth::user()->is_admin === 1)  --}}
        <li class="header">MES AGENTS SAISIS</li>
       <li>
            <a href="{{route('mesDirectionsAdmin')}}">
            <i class="fa fa-th"></i> <span>Mes agents des  régions CT</span>
            </a>
        </li>
        <li>
            <a href="{{route('mesCommuneSaisirent')}}">
            <i class="fa fa-th"></i> <span>Mes agents des communes</span>
            </a>
        </li>
        <li class="header">TOUS LES AGENTS SAISIS</li>

       {{--  @endif  --}}
        <li>
            <a href="#">
            <i class="fa fa-th"></i> <span>Liste agents des régions CT</span>
            </a>
        </li>
        <li>
            <a href="#">
            <i class="fa fa-th"></i> <span>Liste agents des communes</span>
            </a>
        </li>
        {{--  @if (Auth::user()->is_admin === 1 || Auth::user()->role === 'Lecteur')  --}}
        <li class="treeview">
                <a href="#">
                <i class="fa fa-laptop"></i>
                <span>Tableau de bord</span>
                <span class="pull-right-container">
                    <i class="fa fa-angle-left pull-right"></i>
                </span>
                </a>
                <ul class="treeview-menu">
                    <li><a href="{{route('dashbord.accueil')}}"><i class="fa fa-home"></i> Accueil</a></li>
                    {{--  @if (Auth::user()->role <> 'Lecteur')  --}}
                    <li> @if (Route::has('register'))
                            <a  href="{{ route('register') }}">
                                    <i class="fa fa-user-o"></i> {{ __('Créer un utilisateur') }}
                            </a>
                        {{--  @endif  --}}
                    </li>
                    {{--  @endif  --}}
                    <li><a href="{{route('statistique.region')}}"><i class="fa fa-pie-chart" ></i>Statistiques régions CT</a></li>
                    <li><a href="{{route('statistique.commune')}}"><i class="fa fa-pie-chart" ></i>Statistiques communes</a></li>
                </ul>
            </li>
        {{--  @endif  --}}
        <li class="treeview">
            <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                <i class="fa fa-lock"></i>
                <span>Déconnexion</span>
            </a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                {{--  {{ csrf_field() }}  --}}
            </form>

        </li>
    </section>
</aside>
