@extends('app')

@section('title', 'Projets')


@section('content')
<div class="container mt-5">

    <ul class="nav nav-pills mb-4">
        <li class="nav-item">
            <a class="nav-link fs-3 py-3 px-4 {{ request()->routeIs('project.index') ? 'active' : '' }}" >
                Projets
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link fs-3 py-3 px-4 {{ request()->routeIs('team.index') ? 'active' : '' }}" href="{{ route('team.index') }}">
                Équipes
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link fs-3 py-3 px-4 {{ request()->routeIs('member.index') ? 'active' : '' }}" href="{{ route('member.index') }}">
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
                    <th>Client</th>
                    <th>Statut</th>
                    <th>Progression</th>
                    <th>Modifier</th>
                    <th>Supprimer</th>
                </tr>
            </thead>
            <tbody>
                @foreach($projects as $project)
                    <tr class="clickable-row" style="cursor:pointer;">
                        <td>{{ $project->id }}</td>
                        <td>{{ $project->name }}</td>
                        <td>{{ $project->client }}</td>
                        <td>{{ $project->status }}</td>
                        <td>{{ $project->progression }}%</td>
                        <td>
                            <a href="{{ route('project.edit', ['project' => $project]) }}" class="btn btn-sm btn-warning" onclick="event.stopPropagation();">
                                Modifier
                            </a>
                        </td>
                        <td onclick="event.stopPropagation();" >
                            <button type="button" class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#confirmModal-{{ $project->id }}" onclick="event.stopPropagation();" >
                                Supprimer
                            </button>
                            <div class="modal fade" id="confirmModal-{{ $project->id }}" tabindex="-1" aria-labelledby="confirmModalLabel-{{ $project->id }}" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="confirmModalLabel-{{ $project->id }}">Que souhaitez-vous faire ?</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer"></button>
                                </div>
                                <div class="modal-body">
                                    Ce projet peut être marqué comme <strong>Terminé</strong>, <strong>Annulé</strong> ou <strong>Supprimé définitivement</strong>.
                                </div>
                                <div class="modal-footer">

                                    <!-- Marquer comme terminé -->
                                    <form method="POST" action="{{ route('project.markAs', ['project' => $project->id, 'status' => 'Terminé']) }}" style="display:inline;" onclick="event.stopPropagation();" >
                                        @csrf
                                        <button type="submit" class="btn btn-success">Terminé</button>
                                    </form>

                                    <!-- Marquer comme annulé -->
                                    <form method="POST" action="{{ route('project.markAs', ['project' => $project->id, 'status' => 'Annulé']) }}" style="display:inline;" onclick="event.stopPropagation();" >
                                        @csrf
                                        <button type="submit" class="btn btn-warning">Annulé</button>
                                    </form>

                                    <!-- Suppression définitive -->
                                    <form method="POST" action="{{ route('project.destroy', $project->id) }}" style="display:inline;" onclick="event.stopPropagation();" >
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
                    {{-- Ligne description et équipe cachée --}}
                    <tr class="description-row" style="display:none;">
                        <td colspan="7" class="bg-light" style="word-break: break-word; white-space: normal;">
                            <p><strong>Description:</strong> {{ $project->description ?? 'Aucune description' }}</p>
                            <p><strong>Équipe rattachée:</strong> {{ $project->team?->name ?? 'Aucune équipe' }}</p>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    
    {{-- Bouton ajouter projet --}}
    <div class="mt-4">
        <a href="{{ route('project.create') }}" class="btn btn-primary">
            Ajouter un nouveau projet
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