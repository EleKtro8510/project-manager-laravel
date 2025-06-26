@extends('app')

@section('title', 'Ajouter un membre')




@section('content')
<div class="container mt-5">

    <h1 class="mb-4">Ajouter un nouveau membre</h1>

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
            <form method="POST" action="{{ route('member.store') }}">
                @csrf

                <div class="mb-3">
                    <label for="name" class="form-label">Nom du membre</label>
                    <input type="text" name="name" id="name" class="form-control" value="{{ old('name') }}" required>
                </div>

                <div class="mb-3">
                    <label for="client" class="form-label">Rôle du membre</label>
                    <select name="role" id="role" class="form-select" required>
                        <option value="">-- Sélectionner --</option>
                        <option value="Stagiaire" {{ old('status') == 'Stagiaire' ? 'selected' : '' }}>Stagiaire</option>
                        <option value="Développeur Front-End" {{ old('status') == 'Développeur Front-End' ? 'selected' : '' }}>Développeur Front-End</option>
                        <option value="Développeur Back-End" {{ old('status') == 'Développeur Back-End' ? 'selected' : '' }}>Développeur Back-End</option>
                        <option value="Développeur Full-Stack" {{ old('status') == 'Développeur Full-Stack' ? 'selected' : '' }}>Développeur Full-Stack</option>
                        <option value="Chef de projet" {{ old('status') == 'Chef de projet' ? 'selected' : '' }}>Chef de projet</option>
                        <option value="Designer" {{ old('status') == 'Designer' ? 'selected' : '' }}>Designer</option>
                        <option value="Testeur" {{ old('status') == 'Testeur' ? 'selected' : '' }}>Testeur</option>
                        <option value="Intégrateur Web" {{ old('status') == 'Intégrateur Web' ? 'selected' : '' }}>Intégrateur Web</option>
                        <option value="Rédacteur" {{ old('status') == 'Rédacteur' ? 'selected' : '' }}>Rédacteur</option>
{{--<option value="role" {{ old('status') == 'role' ? 'selected' : '' }}>role</option>--}}                     
                    </select>                
                    <div class="d-flex justify-content-between mt-3">
                        <a href="{{ route('member.index') }}" class="btn btn-secondary">Retour à la liste</a>
                        <button type="submit" class="btn btn-primary">Enregistrer le membre</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    document.getElementById('add-member-btn').addEventListener('click', function() {
        const wrapper = document.getElementById('members-wrapper');
        const newMemberInput = document.createElement('div');
        newMemberInput.classList.add('mb-3', 'member-input');
        newMemberInput.innerHTML = '<input type="text" name="members[]" class="form-control" placeholder="Nom du membre" required>';
        wrapper.appendChild(newMemberInput);
    });
</script>
@endsection