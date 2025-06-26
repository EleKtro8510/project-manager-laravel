@extends('app')

@section('title', 'Modifier une équipe')


@section('content')
<div class="container mt-5" style="max-width: 700px;">

    <h1 class="mb-4">Modifier une équipe</h1>

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
            <form method="POST" action="{{ route('team.update', ['team' => $team]) }}">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label for="name" class="form-label">Nom de l'équipe</label>
                    <input
                        type="text"
                        id="name"
                        name="name"
                        class="form-control"
                        value="{{ old('name', $team->name) }}"
                        maxlength="100"
                        required
                    >
                </div>

                <div class="mb-3">
                    <label for="client" class="form-label">Membres</label>

                    <div id="members-wrapper">
                        {{-- Membres déjà dans l'équipe --}}
                        @foreach ($team->members as $member)
                            <div class="d-flex gap-2 align-items-center mb-2 existing-member-input">
                                {{-- Champ réellement envoyé au serveur --}}
                                <input type="hidden" name="existing_members[]" value="{{ $member->id }}">

                                {{-- Sélecteur visible mais non modifiable --}}
                                <select class="form-select" disabled style="max-width: 400px;">
                                    <option value="">-- Sélectionner --</option>
                                    @foreach ($teamMembers as $teamMember)
                                        <option value="{{ $teamMember->id }}" {{ $teamMember->id === $member->id ? 'selected' : '' }}>
                                            {{ $teamMember->name }}
                                        </option>
                                    @endforeach
                                </select>

                                <button type="button" class="btn btn-danger btn-sm remove-member-btn">-</button>
                            </div>
                        @endforeach
                    </div>
                    <div id="existing-members-wrapper">

                    </div>

                    {{-- Boutons d'ajout --}}
                    <button type="button" class="btn btn-light" id="new-member-btn">Créer un nouveau membre</button>
                    <button type="button" class="btn btn-light" id="existing-member-btn">Sélectionner un membre déjà existant</button>
                </div>

                <div class="d-flex justify-content-between">
                    <a href="{{ route('team.index') }}" class="btn btn-secondary">Retour à la liste</a>
                    <button type="submit" class="btn btn-primary">Mettre à jour</button>
                </div>
            </form>
        </div>
    </div>

<script>
    const membersWrapper = document.getElementById('members-wrapper');
    const existingMembersWrapper = document.getElementById('existing-members-wrapper');
    const memberCountSpan = document.getElementById('member-count');
    const existingMemberBtn = document.getElementById('existing-member-btn');
    const newMemberBtn = document.getElementById('new-member-btn');

    function updateMemberCount() {
        const newMembers = membersWrapper.querySelectorAll('.member-input').length;
        const existingMembers = existingMembersWrapper.querySelectorAll('.existing-member-input').length;
        memberCountSpan.textContent = newMembers + existingMembers;
    }

    document.addEventListener('click', function(e) {
        if (e.target.classList.contains('remove-member-btn')) {
            e.target.closest('.member-input, .existing-member-input').remove();
            updateMemberCount();
        }
    });

    newMemberBtn.addEventListener('click', function() {
        const div = document.createElement('div');
        div.classList.add('d-flex', 'gap-2', 'align-items-center', 'mb-2', 'member-input');
        div.innerHTML = `
            <input
                type="text"
                name="members[]"
                class="form-control"
                placeholder="Nom du membre"
                required
                style="max-width: 300px;"
            >
            <select
                name="roles[]"
                class="form-select"
                required
                style="max-width: 250px;"
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
            <button type="button" class="btn btn-danger btn-sm remove-member-btn">-</button>
        `;
        membersWrapper.appendChild(div);
        updateMemberCount();
    });

    existingMemberBtn.addEventListener('click', function () {
        const div = document.createElement('div');
        div.classList.add('d-flex', 'gap-2', 'align-items-center', 'mb-2', 'existing-member-input');
        div.style.maxWidth = "800px";
        div.style.width = "100%";
        div.innerHTML = `
            <select name="existing_members[]" class="form-select" required style="flex: 1;">
                <option value="">-- Sélectionner --</option>
                @foreach($availableMembers as $member)
                    <option value="{{ $member->id }}">{{ $member->name }}</option>
                @endforeach
            </select>
            <button type="button" class="btn btn-danger btn-sm remove-member-btn" style="flex-shrink: 0;">-</button>
        `;
        existingMembersWrapper.appendChild(div);
        updateMemberCount();
    });

    updateMemberCount();
</script>
@endsection