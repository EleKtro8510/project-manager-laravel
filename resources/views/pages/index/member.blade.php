@extends('app')

@section('title', 'Membres')


@section('content')
<div class="container mt-5">

    <ul class="nav nav-pills mb-4">
        <li class="nav-item">
            <a class="nav-link fs-3 py-3 px-4 {{ request()->routeIs('project.index') ? 'active' : '' }}" href="{{ route('project.index') }}">
                Projets
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link fs-3 py-3 px-4 {{ request()->routeIs('team.index') ? 'active' : '' }}" href="{{ route('team.index') }}">
                Équipes
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link fs-3 py-3 px-4 {{ request()->routeIs('member.index') ? 'active' : '' }}" >
                Membres
            </a>
        </li>
    </ul>
    
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
                        <td onclick="event.stopPropagation();" >
                            <button type="button" class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#confirmModal-{{ $member->id }}" onclick="event.stopPropagation();" >
                                Supprimer
                            </button>
                            <div class="modal fade" id="confirmModal-{{ $member->id }}" tabindex="-1" aria-labelledby="confirmModalLabel-{{ $member->id }}" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="confirmModalLabel-{{ $member->id }}">Que souhaitez-vous faire ?</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer"></button>
                                        </div>
                                        <div class="modal-body">
                                            Etes-vous sûr de vouloir <strong>supprimer définitivement</strong> ce membre?
                                        </div>
                                        <div class="modal-footer">
                                            <!-- Annulation -->
                                            <button type="button" class="btn btn-light" data-bs-dismiss="modal" aria-label="Fermer">Annuler</button>
                                            
                                            <!-- Suppression définitive -->
                                            <form method="POST" action="{{ route('member.destroy', $member->id) }}" style="display:inline;" onclick="event.stopPropagation();" >
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger">Supprimer</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
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