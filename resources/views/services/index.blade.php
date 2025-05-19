{{--  @extends('layouts.admin', ['titrePage' => 'Liste des Services'])

@section('content')
    {{-- navigation (désactive si erreur de route) --}}
    {{--  @include('partials.back-admin._nav')

    <div class="container mt-4">
        <h2 class="mb-4">Liste des Services</h2>

        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <table class="table table-bordered">
            <thead class="table-dark">
                <tr>
                    <th>#</th>
                    <th>Nom du Service</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($services as $service)
                    <tr>
                        <td>{{ $service->id }}</td>
                        <td>{{ $service->nom }}</td>
                        <td>
                            <a href="#" class="btn btn-warning btn-sm">Modifier</a>
                            <a href="#" class="btn btn-danger btn-sm">Supprimer</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <a href="{{ route('services.create') }}" class="btn btn-primary mt-3">Créer un nouveau Service</a>
    </div>
@endsection    --}}
