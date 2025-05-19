@extends('layouts.master', ['titrePage' => 'DGTI'])
@section('content')


@php
    // Définir des valeurs par défaut si les variables n'existent pas
    $serviceHommes = $serviceHommes ?? collect();
    $serviceFemmes = $serviceFemmes ?? collect();
    $direction = $direction ?? collect();
    $service = $service ?? collect();
    $directionHommes = $directionHommes ?? collect();
    $directionFemmes = $directionFemmes ?? collect();
@endphp
<div data-spy="scroll" data-target="#navbar-eservice">
	<div class="container">
		<section>
			<div class="container">
				<div class="row">
					<div class="col-lg-12 col-12">
						<div class="card mb-4">
							<div class="row no-gutters">
								<div class="col-md-12">
									<div class="card-body">
										
</h4>

<h1 class="text-center three-d-animated">
    BIENVENUE SUR LA PLATEFORME DE GESTION DES DOSSIERS PERSONNEL DE LA DGTI
</h1>

<style>
.three-d-animated {
    font-size: 2.8rem;
    font-weight: 900;
    text-transform: uppercase;
    color: #f00;
    text-shadow: 
        0 1px 0 #ccc,
        0 2px 0 #c9c9c9,
        0 3px 0 #bbb,
        0 4px 0 #b9b9b9,
        0 5px 0 #aaa,
        0 6px 1px rgba(0,0,0,0.1),
        0 0 5px rgba(0,0,0,0.1),
        0 1px 3px rgba(0,0,0,0.3),
        0 3px 5px rgba(0,0,0,0.2),
        0 5px 10px rgba(0,0,0,0.25),
        0 10px 10px rgba(0,0,0,0.2),
        0 20px 20px rgba(0,0,0,0.15);
    animation: float 3s ease-in-out infinite;
    transform: perspective(500px) rotateX(15deg);
    margin: 40px 0;
    letter-spacing: 3px;
}

@keyframes float {
    0%, 100% { transform: perspective(500px) rotateX(15deg) translateY(0); }
    50% { transform: perspective(500px) rotateX(15deg) translateY(-10px); }
}
</style>

										<h5 class="card-title text-uppercase text-center" style="color: #f00;">
    Direction Générale des Transmissions et de l'Informatique
</h5>

										<hr>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</section>
		<div class="row">
			<div class="col-lg-6 col-sm-6">
				<div class="circle-tile ">
					<a href="#">
						<div class="circle-tile-heading dark-blue"><i class="fa fa-bar-chart-o"></i></div>
					</a>
					<div class="circle-tile-content dark-blue">
						<div class="circle-tile-description text-faded"> total des directions</div>
						<div class="circle-tile-number text-faded ">{{ $direction ? count($direction) : 0 }}</div>
						<dl class="col-md-offset-3">
							<dt class="circle-tile-description text-faded">Nombre total d'hommes :</dt>
							<dd class="circle-tile-nber text-faded">
								{{ $direction ? count($direction->where('sexe', '=', 'Masculin')) : 0 }}
							</dd>
							<dt class="circle-tile-description text-faded">Nombre total de femmes :</dt>
							<dd class="circle-tile-nber text-faded">
								{{ $direction ? count($direction->where('sexe', '=', 'Feminin')) : 0 }}
							</dd>
						</dl>
						<br><br>
					</div>

				</div>
			</div>

			<div class="col-lg-6 col-sm-6">
				<div class="circle-tile ">
					<a href="#">
						<div class="circle-tile-heading dark-blue"><i class="fa fa-bar-chart-o"></i></div>
					</a>
					<div class="circle-tile-content dark-blue">
						<div class="circle-tile-description text-faded">total  des services</div>
						<div class="circle-tile-number text-faded ">{{ $service ? count($service) : 0 }}</div>
						<dl class="col-md-offset-3">
							<dt class="circle-tile-description text-faded">Nombre total d'hommes :</dt>
							<dd class="circle-tile-nber text-faded">
								{{ $service ? count($service->where('sexe', '=', 'Masculin')) : 0 }}
							</dd>
							<dt class="circle-tile-description text-faded">Nombre total de femmes :</dt>
							<dd class="circle-tile-description text-faded">
								{{ $service ? count($service->where('sexe', '=', 'Feminin')) : 0 }}
							</dd>
						</dl>
						<br><br>
					</div>
				</div>
			</div>
		</div>

		<div class="row">
			<div class="col-lg-6 col-sm-16">
				<div class="circle-tile ">
					<a href="#">
						<div class="circle-tile-heading dark-blue">
                <h3 style="font-size: 18px; margin: 0;">Direction</h3>
            </div>
					</a>
					<div class="circle-tile-content dark-blue"></div>
				</div>
				<table id="example" class="table table-hover">
					<thead>
						<tr class="text-white tr-bg">
							<th>Catégorie</th>
							<th>P</th>
							<th>A</th>
							<th>B</th>
							<th>C</th>
							<th>D</th>
							<th>E</th>
							<th>?</th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td><b>Homme</b></td>
							<td>{{ count($directionHommes->where('categorie', '=', 'P')) }}</td>
							<td>{{ count($directionHommes->where('categorie', '=', 'A et assimilés')) }}</td>
							<td>{{ count($directionHommes->where('categorie', '=', 'B et assimilés')) }}</td>
							<td>{{ count($directionHommes->where('categorie', '=', 'C et assimilés')) }}</td>
							<td>{{ count($directionHommes->where('categorie', '=', 'D et assimilés')) }}</td>
							<td>{{ count($directionHommes->where('categorie', '=', 'E et assimilés')) }}</td>
							<td>{{ count($directionHommes->where('categorie', '=', 'Néant')) }}</td>
						</tr>
						<tr>
							<td><b>Femme</b></td>
							<td>{{count($directionFemmes->where('categorie', '=', 'P')) }}</td>
							<td>{{count($directionFemmes->where('categorie', '=', 'A et assimilés')) }}</td>
							<td>{{count($directionFemmes->where('categorie', '=', 'B et assimilés')) }}</td>
							<td>{{count($directionFemmes->where('categorie', '=', 'C et assimilés')) }}</td>
							<td>{{count($directionFemmes->where('categorie', '=', 'D et assimilés')) }}</td>
							<td>{{count($directionFemmes->where('categorie', '=', 'E et assimilés')) }}</td>
							<td>{{count($directionFemmes->where('categorie', '=', 'Néant')) }}</td>
						</tr>
					</tbody>
				</table>
			</div>

			<div class="col-lg-6 col-sm-6">
				<div class="circle-tile ">
					<a href="#">
						<div class="circle-tile-heading dark-blue">
							<h3>Service</h3>
						</div>
					</a>
					<div class="circle-tile-content dark-blue"></div>
				</div>
				<table id="example" class="table table-hover">
					<thead>
						<tr class="text-white tr-bg">
							<th>Catégorie</th>
							<th>P</th>
							<th>A</th>
							<th>B</th>
							<th>C</th>
							<th>D</th>
							<th>E</th>
							<th>?</th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td><b>Homme</b></td>
							<td>{{ count($serviceHommes->where('categorie', '=', 'P')) }}</td>
							<td>{{ count($serviceHommes->where('categorie', '=', 'A et assimilés')) }}</td>
							<td>{{ count($serviceHommes->where('categorie', '=', 'B et assimilés')) }}</td>
							<td>{{ count($serviceHommes->where('categorie', '=', 'C et assimilés')) }}</td>
							<td>{{ count($serviceHommes->where('categorie', '=', 'D et assimilés')) }}</td>
							<td>{{ count($serviceHommes->where('categorie', '=', 'E et assimilés')) }}</td>
							<td>{{ count($serviceHommes->where('categorie', '=', 'Néant')) }}</td>
						</tr>
						<tr>
							<td><b>Femme</b></td>
							<td>{{ count($serviceFemmes->where('categorie', '=', 'P')) }}</td>
							<td>{{ count($serviceFemmes->where('categorie', '=', 'A et assimilés')) }}</td>
							<td>{{ count($serviceFemmes->where('categorie', '=', 'B et assimilés')) }}</td>
							<td>{{ count($serviceFemmes->where('categorie', '=', 'C et assimilés')) }}</td>
							<td>{{ count($serviceFemmes->where('categorie', '=', 'D et assimilés')) }}</td>
							<td>{{ count($serviceFemmes->where('categorie', '=', 'E et assimilés')) }}</td>
							<td>{{ count($serviceFemmes->where('categorie', '=', 'Néant')) }}</td>
						</tr>
					</tbody>
				</table>
			</div>
		</div>

		<div class="row">
			<div class="col-lg-12 col-sm-12">
				<div class="circle-tile ">
					<a href="#">
						<div class="circle-tile-heading dark-blue">
							<h3>Directions</h3>
						</div>
					</a>
					<div class="circle-tile-content dark-blue"></div>
				</div>
				<div class="table-responsive-custom">
					<table id="example" class="table table-bordered">
						<thead>
							<tr class="text-white tr-bg">
								<th>Directions</th>
								<th>DGTI</th>
								<th>DT</th>
								<th>DSI</th>
								<th>DASP</th>
								<th>DSEF</th>
								<th>DIG</th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<td><b>Homme</b></td>
								<td>{{ count( $direction->where('sexe', '=', 'Masculin')->where('direction_id', '=', 1)
									) }}</td>
								<td>{{ count( $direction->where('sexe', '=', 'Masculin')->where('direction_id', '=', 2)
									) }}</td>
								<td>{{ count($direction->where('sexe', '=', 'Masculin')->where('direction_id', '=', 3))
									}}</td>
								<td> {{ count($direction->where('sexe', '=', 'Masculin')->where('direction_id', '=', 4))
									}}</td>
								<td>{{ count($direction->where('sexe', '=', 'Masculin')->where('direction_id', '=', 5))
									}}</td>
								<td> {{ count($direction->where('sexe', '=', 'Masculin')->where('direction_id', '=', 6))
									}}</td>
							</tr>
							<tr>
								<td><b>Femme</b></td>
								<td>{{ count( $direction->where('sexe', '=', 'Feminin')->where('direction_id', '=', 1) )
									}}</td>
								<td>{{ count( $direction->where('sexe', '=', 'Feminin')->where('direction_id', '=', 2) )
									}}</td>
								<td>{{ count($direction->where('sexe', '=', 'Feminin')->where('direction_id', '=', 3))
									}}</td>
								<td> {{ count($direction->where('sexe', '=', 'Feminin')->where('direction_id', '=', 4))
									}}</td>
								<td>{{ count($direction->where('sexe', '=', 'Feminin')->where('direction_id', '=', 5))
									}}</td>
								<td> {{ count($direction->where('sexe', '=', 'Feminin')->where('direction_id', '=', 6))
									}}</td>
							</tr>
						</tbody>
					</table>
				</div>
			</div>
		</div>


		<div style="padding: 9%;"></div>
	</div>
</div>

@endsection

<style>
	.table-responsive-custom {
		width: 100%;
		overflow-x: auto;
		-webkit-overflow-scrolling: touch;
	}

	.table-responsive-custom table {
		min-width: 800px;
	}
</style>