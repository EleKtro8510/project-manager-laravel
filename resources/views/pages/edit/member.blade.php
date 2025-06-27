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
                    <label for="role" class="form-label">Rôle</label>
                    <select
                        id="role"
                        name="role"
                        class="form-select"
                        required
                    >
                        <option value="" disabled>-- Sélectionner --</option>
                        <option value="Stagiaire" {{ old('role', $member->role ?? '') == 'Stagiaire' ? 'selected' : '' }}>Stagiaire</option>
                        <option value="Développeur Front-End" {{ old('role', $member->role ?? '') == 'Développeur Front-End' ? 'selected' : '' }}>Développeur Front-End</option>
                        <option value="Développeur Back-End" {{ old('role', $member->role ?? '') == 'Développeur Back-End' ? 'selected' : '' }}>Développeur Back-End</option>
                        <option value="Développeur Full-Stack" {{ old('role', $member->role ?? '') == 'Développeur Full-Stack' ? 'selected' : '' }}>Développeur Full-Stack</option>
                        <option value="Chef de projet" {{ old('role', $member->role ?? '') == 'Chef de projet' ? 'selected' : '' }}>Chef de projet</option>
                        <option value="Designer" {{ old('role', $member->role ?? '') == 'Designer' ? 'selected' : '' }}>Designer</option>
                        <option value="Testeur" {{ old('role', $member->role ?? '') == 'Testeur' ? 'selected' : '' }}>Testeur</option>
                        <option value="Intégrateur Web" {{ old('role', $member->role ?? '') == 'Intégrateur Web' ? 'selected' : '' }}>Intégrateur Web</option>
                        <option value="Rédacteur" {{ old('role', $member->role ?? '') == 'Rédacteur' ? 'selected' : '' }}>Rédacteur</option>
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