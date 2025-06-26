@extends('app')

@section('title', 'Projets')


@section('content')
<div class="container mt-5">

    <h1 class="mb-4">Projets / <a href="{{ route('team.index') }}">Equipes</a> / <a href="{{ route('member.index') }}">Membres</a></h1>

    
    
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
                        <td>
                            <form method="POST" action="{{ route('project.destroy', ['project' => $project]) }}" onsubmit="return confirm('Confirmer la suppression ?')" onclick="event.stopPropagation();">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger">Supprimer</button>
                            </form>
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