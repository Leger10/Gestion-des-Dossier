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
            <i class="fa fa-th"></i> <span>Mes servives par directions</span>
            </a>
        </li>
        <li>
 
            <a href="{{ route('admin.agents.dashboard') }}">
            <i class="fa fa-th"></i> <span>Liste des agents </span>
            </a>
        </li>
        <li class="header">Tous les agents</li>

       {{--  @endif  --}}
        <li>
            <a href="{{route('directions.index')}}">
            <i class="fa fa-th"></i> <span>Listes  personnels par Directions</span>
            </a>
        </li>
         <li>
            <a href="{{route('directions.index')}}">
            <i class="fa fa-th"></i> <span>Listes  personnels par services</span>
            </a>
        </li>
        <li class="treeview">
    <a href="#">
        <i class="fa fa-th"></i> <span>Créer</span>
        <i class="fa fa-angle-left pull-right"></i>
    </a>
    <ul class="treeview-menu">
        <li><a href="{{ route('directions.index') }}"><i class="fa fa-angle-right"></i> Direction</a></li>
        <li><a href="{{ route('directions.index') }}"><i class="fa fa-angle-right"></i> Service</a></li>
    </ul>
</li>
 <li>
           <li class="{{ request()->routeIs('dashboard.agents') ? 'active' : '' }}">
    <a href="{{ route('dashboard.agents') }}">
        <i class="fa fa-th"></i> <span>Dossiers Personnel</span>
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
                    {{--  <li> @if (Route::has('register'))  --}}
                            <a  href="{{ route('register') }}">
                                    <i class="fa fa-user-o"></i> {{ __('Créer un utilisateur') }}
                            </a>
                        {{--  @endif  --}}
                    </li>
                    {{--  @endif  --}}
                    <li><a href="{{route('statistique.region')}}"><i class="fa fa-pie-chart" ></i>Statistiques par Direction</a></li>
                    <li><a href="{{route('statistique.commune')}}"><i class="fa fa-pie-chart" ></i>Statistiques par service</a></li>
                </ul>
            </li>
        {{--  @endif  --}}
        <li class="treeview">
           <form action="{{ route('logout') }}" method="post">
            @csrf
            <button type="submit" class="btn btn-link" style="color: #fff; text-decoration: none;">
                <i class="fa fa-sign-out"></i> Déconnexion
            </button>
           </form>

        </li>
    </section>
</aside>
