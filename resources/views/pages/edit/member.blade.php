@extends('app')

@section('title', 'Modifier un membre')


@section('content')
<div class="container mt-5" style="max-width: 700px;">

    <h1 class="mb-4">Modifier un membre</h1>

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
            <form method="POST" action="{{ route('member.update', ['member' => $member]) }}">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label for="name" class="form-label">Nom</label>
                    <input
                        type="text"
                        id="name"
                        name="name"
                        class="form-control"
                        value="{{ old('name', $member->name) }}"
                        maxlength="100"
                        required
                    >
                </div>

                <div class="mb-3">
                    <label for="role" class="form-label">Statut</label>
                    <select
                        id="role"
                        name="role"
                        class="form-select"
                        required
                    >
                        <option value="">-- Sélectionner --</option>
                        <option value="Stagiaire">Stagiaire</option>
                        <option value="Développeur Front-End">Développeur Front-End</option>
                        <option value="Développeur Back-End">Développeur Back-End</option>
                        <option value="Développeur Full-Stack">Développeur Full-Stack</option>
                        <option value="Chef de projet">Chef de projet</option>
                        <option value="Designer">Designer</option>
                        <option value="Testeur">Testeur</option>
                        <option value="Intégrateur Web">Intégrateur Web</option>
                        <option value="Rédacteur">Rédacteur</option>
                    </select>
                </div>

                <div class="d-flex justify-content-between">
                    <a href="{{ route('member.index') }}" class="btn btn-secondary">Retour à la liste</a>
                    <button type="submit" class="btn btn-primary">Mettre à jour</button>
                </div>

            </form>
        </div>
    </div>

</div>
@endsection