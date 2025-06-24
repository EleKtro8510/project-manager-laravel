@extends('app')

@section('title', 'Modifier un projet')


@section('content')
<div class="container mt-5" style="max-width: 700px;">

    <h1 class="mb-4">Modifier un projet</h1>

    {{-- Affichage des erreurs --}}
    @if($errors->any())
        <div class="alert alert-danger">
            <h5 class="alert-heading">Merci de corriger les erreurs :</h5>
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- Formulaire d'édition --}}
    <div class="card shadow-sm">
        <div class="card-body">
            <form method="POST" action="{{ route('project.update', ['project' => $project]) }}">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label for="name" class="form-label">Nom</label>
                    <input
                        type="text"
                        id="name"
                        name="name"
                        class="form-control"
                        value="{{ old('name', $project->name) }}"
                        maxlength="100"
                        required
                    >
                </div>

                <div class="mb-3">
                    <label for="client" class="form-label">Client</label>
                    <input
                        type="text"
                        id="client"
                        name="client"
                        class="form-control"
                        value="{{ old('client', $project->client) }}"
                        maxlength="100"
                        required
                    >
                </div>

                <div class="mb-3">
                    <label for="description" class="form-label">Description</label>
                    <textarea
                        id="description"
                        name="description"
                        class="form-control"
                        rows="3"
                    >{{ old('description', $project->description) }}</textarea>
                </div>

                <div class="mb-3">
                    <label for="status" class="form-label">Statut</label>
                    <select
                        id="status"
                        name="status"
                        class="form-select"
                        required
                    >
                        <option value="" disabled {{ old('status', $project->status) ? '' : 'selected' }}>-- Sélectionner un statut --</option>
                        <option value="En cours" {{ old('status', $project->status) == 'En cours' ? 'selected' : '' }}>En cours</option>
                        <option value="Terminé" {{ old('status', $project->status) == 'Terminé' ? 'selected' : '' }}>Terminé</option>
                        <option value="En attente" {{ old('status', $project->status) == 'En attente' ? 'selected' : '' }}>En attente</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label for="progression" class="form-label">Progression (%)</label>
                    <input
                        type="number"
                        id="progression"
                        name="progression"
                        class="form-control"
                        min="0"
                        max="100"
                        value="{{ old('progression', $project->progression) }}"
                        required
                    >
                </div>

                <div class="d-flex justify-content-between">
                    <a href="{{ route('project.index') }}" class="btn btn-secondary">Retour à la liste</a>
                    <button type="submit" class="btn btn-primary">Mettre à jour</button>
                </div>

            </form>
        </div>
    </div>

</div>
@endsection