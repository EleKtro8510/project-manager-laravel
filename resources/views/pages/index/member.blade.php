@extends('app')

@section('title', 'Membres')


@section('content')
<div class="container mt-5">

    <h1 class="mb-4"><a href="{{ route('project.index') }}">Projets</a> / <a href="{{ route('team.index') }}">Equipes</a> / Membres</h1>

    
    
    {{-- Message succès --}}
    @if(session()->has('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    {{-- Table responsive --}}
    <div class="table-responsive">
        <table class="table table-striped table-hover align-middle">
            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>Nom</th>
                    <th>Rôle</th>
                    <th>Equipe</th>
                    <th>Modifier</th>
                    <th>Supprimer</th>
                </tr>
            </thead>
            <tbody>
                @foreach($members as $member)
                    <tr class="clickable-row" style="cursor:pointer;">
                        <td>{{ $member->id }}</td>
                        <td>{{ $member->name }}</td>
                        <td>{{ $member->role }}</td>
                        <td>{{ $member->team?->name ?? 'Aucune équipe' }}</td>
                        <td>
                            <a href="{{ route('member.edit', ['member' => $member]) }}" class="btn btn-sm btn-warning" onclick="event.stopPropagation();">
                                Modifier
                            </a>
                        </td>
                        <td>
                            <form method="POST" action="{{ route('member.destroy', ['member' => $member]) }}" onsubmit="return confirm('Confirmer la suppression ?')" onclick="event.stopPropagation();">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger">Supprimer</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    
    {{-- Bouton ajouter membre --}}
    <div class="mt-4">
        <a href="{{ route('member.create') }}" class="btn btn-primary">
            Ajouter un nouveau membre
        </a>
    </div>
</div>

<script>
    document.querySelectorAll('tr.clickable-row').forEach(row => {
        row.addEventListener('click', () => {
            const allDescriptions = document.querySelectorAll('tr.description-row');
            const nextRow = row.nextElementSibling;

            // Si la description est déjà visible, la masquer et ne rien afficher d'autre
            if (nextRow && nextRow.classList.contains('description-row') && nextRow.style.display === 'table-row') {
                nextRow.style.display = 'none';
                return;
            }

            // Sinon, masquer toutes les descriptions puis afficher celle cliquée
            allDescriptions.forEach(descRow => descRow.style.display = 'none');

            if (nextRow && nextRow.classList.contains('description-row')) {
                nextRow.style.display = 'table-row';
            }
        });
    });
</script>

@endsection