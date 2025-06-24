@extends('app')

@section('title', 'Ajouter un projet')




@section('content')
<div class="container mt-5">

    <h1 class="mb-4">Ajouter un nouveau projet</h1>

    {{-- Affichage des erreurs --}}
    @if($errors->any())
        <div class="alert alert-danger">
            <h5 class="alert-heading">Erreurs :</h5>
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- Formulaire --}}
    <div class="card shadow-sm">
        <div class="card-body">
            <form method="POST" action="{{ route('project.store') }}">
                @csrf

                <div class="mb-3">
                    <label for="name" class="form-label">Nom du projet</label>
                    <input type="text" name="name" id="name" class="form-control" value="{{ old('name') }}" required>
                </div>

                <div class="mb-3">
                    <label for="client" class="form-label">Client</label>
                    <input type="text" name="client" id="client" class="form-control" value="{{ old('client') }}" required>
                </div>

                <div class="mb-3">
                    <label for="description" class="form-label">Description</label>
                    <textarea name="description" id="description" class="form-control" rows="3">{{ old('description') }}</textarea>
                </div>

                <div class="mb-3">
                    <label for="status" class="form-label">Statut</label>
                    <select name="status" id="status" class="form-select" required>
                        <option value="">-- Sélectionner --</option>
                        <option value="En cours" {{ old('status') == 'En cours' ? 'selected' : '' }}>En cours</option>
                        <option value="Terminé" {{ old('status') == 'Terminé' ? 'selected' : '' }}>Terminé</option>
                        <option value="En attente" {{ old('status') == 'En attente' ? 'selected' : '' }}>En attente</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label for="progression" class="form-label">Progression (%)</label>
                    <input type="text" name="progression" id="progression" class="form-control" value="{{ old('progression') }}"  placeholder="Exemple : 50 ou 50%" required>
                </div>

                <div class="d-flex justify-content-between">
                    <a href="{{ route('project.index') }}" class="btn btn-secondary">Retour à la liste</a>
                    <button type="submit" class="btn btn-primary">Enregistrer le projet</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection