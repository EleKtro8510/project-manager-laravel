@extends('app')

@section('title', 'Equipes')


@section('content')
<div class="container mt-5">

    <h1 class="mb-4"><a href="{{ route('project.index') }}">Projets</a> / Equipes / <a href="{{ route('member.index') }}">Membres</a></h1>

    
    
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
                    <th>Projets</th>
                    <th>Modifier</th>
                    <th>Supprimer</th>
                </tr>
            </thead>
            <tbody>
                @foreach($teams as $team)
                    <tr class="clickable-row" style="cursor:pointer;">
                        <td>{{ $team->id }}</td>
                        <td>{{ $team->name }}</td>
                        <td>
                            @if($team->projects->isEmpty())
                                Aucun projet
                            @else
                                {{ $team->projects->pluck('name')->join(', ') }}
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('team.edit', ['team' => $team]) }}" class="btn btn-sm btn-warning" onclick="event.stopPropagation();">
                                Modifier
                            </a>
                        </td>
                        <td>
                            <form method="POST" action="{{ route('team.destroy', ['team' => $team]) }}" onsubmit="return confirm('Confirmer la suppression ?')" onclick="event.stopPropagation();">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger">Supprimer</button>
                            </form>
                        </td>
                    </tr>
                    {{-- Ligne membres cachée --}}
                    <tr class="description-row" style="display:none;">
                        <td colspan="7" class="bg-light">
                            <strong>Membres :</strong> 
                            @if($team->members->isEmpty())
                                Aucun membre
                            @else
                                {{ $team->members->pluck('name')->join(', ') }}
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    
    {{-- Bouton ajouter équipe --}}
    <div class="mt-4">
        <a href="{{ route('team.create') }}" class="btn btn-primary">
            Ajouter une nouvelle équipe
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