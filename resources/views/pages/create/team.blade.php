@extends('app')

@section('title', 'Ajouter une équipe')




@section('content')
<div class="container mt-5">

    <h1 class="mb-4">Ajouter une nouvelle équipe</h1>

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
            <form method="POST" action="{{ route('team.store') }}">
                @csrf

                <div class="mb-3">
                    <label for="name" class="form-label">Nom de l'équipe</label>
                    <input type="text" name="name" id="name" class="form-control" value="{{ old('name') }}" required>
                </div>

                <div class="mb-3">
                    <label for="client" class="form-label">Membres</label>
                    <div>
                        <label class="form-label">Nombres de membres : <span id="member-count">0</span></label>
                    </div>

                    <div class="mb-3 mt-3">
                        <button type="button" class="btn btn-light" id="new-member-btn">Créer un nouveau membre</button>
                        <button type="button" class="btn btn-light" id="existing-member-btn">Sélectionner un membre déjà existant</button>
                    </div>

                    <div id="members-wrapper"></div>
                </div>
                <div class="d-flex justify-content-between">
                    <a href="{{ route('team.index') }}" class="btn btn-secondary">Retour à la liste</a>
                    <button type="submit" class="btn btn-primary">Enregistrer l'équipe</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    const wrapper = document.getElementById('members-wrapper');
    const countDisplay = document.getElementById('member-count');

    const newMemberBtn = document.getElementById('new-member-btn');
    const existingMemberBtn = document.getElementById('existing-member-btn');

    function updateCount() {
        countDisplay.textContent = wrapper.querySelectorAll('.member-input').length;
    }

    newMemberBtn.addEventListener('click', function () {
        const div = document.createElement('div');
        div.classList.add('mb-3', 'member-input');
        div.innerHTML = `
            <div class="d-flex gap-2 align-items-center" style="max-width: 800px; width: 100%;">
                <input type="text" name="members[]" class="form-control" placeholder="Nom du membre" style="flex: 1;">
                <select name="roles[]" id="role" class="form-select" style="flex: 1;">
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
                <button type="button" class="btn btn-danger btn-sm remove-member-btn" style="flex-shrink: 0;">-</button>
            </div>
        `;
        wrapper.appendChild(div);
        updateCount();
    });

    existingMemberBtn.addEventListener('click', function () {
        const div = document.createElement('div');
        div.classList.add('mb-3', 'member-input');
        div.innerHTML = `
        <div class="d-flex gap-2 align-items-center" style="max-width: 800px; width: 100%;">
            <select name="existing_members[]" class="form-select" required style="flex: 1;">
                <option value="">-- Sélectionner --</option>
                @foreach($availableMembers as $member)
                    <option value="{{ $member->id }}">{{ $member->name }}</option>
                @endforeach
            </select>
            <button type="button" class="btn btn-danger btn-sm remove-member-btn" style="flex-shrink: 0;">-</button>
        </div>
        `;
        wrapper.appendChild(div);
        updateCount();
    });

    document.getElementById('members-wrapper').addEventListener('click', function(e) {
        if(e.target && e.target.classList.contains('remove-member-btn')) {
            const memberDiv = e.target.closest('.member-input');
            if(memberDiv) {
                memberDiv.remove();
            }
        }
        updateCount();
    });

    updateCount();
</script>
@endsection