<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Project;
use App\Models\Team;

class ProjectController extends Controller
{
    public function index(){
        $projects = Project::all();
        return view('pages/index/project', ['projects' => $projects]);
    }

    public function create(){
        $teams = Team::all();
        return view('pages/create/project', compact('teams'));
    }

    public function store(Request $request){
        $data = $request->validate([
            'name' => 'required|string|max:100',
            'client' => 'required|string|max:100',
            'description' => 'nullable|string',
            'status' => 'required',
            'progression' => [
                'required',
                function ($attribute, $value, $fail) {
                    // Retire le symbole % si présent
                    $numericValue = str_replace('%', '', $value);

                    // Vérifie que c'est un nombre entier entre 0 et 100
                    if (!ctype_digit($numericValue) || (int)$numericValue < 0 || (int)$numericValue > 100) {
                        $fail('La progression doit être un nombre entre 0 et 100 (avec ou sans %).');
                    }
                }
            ],
            'team_id' => 'nullable|exists:teams,id',
        ]);

    // Nettoyer la valeur pour l’enregistrer correctement
    $data['progression'] = (int) str_replace('%', '', $data['progression']);

        
        $newProject = Project::create($data);
        $newProject->team_id = $request->input('team');
        $newProject->save();


        return redirect(route('project.index'))->with('success', 'Projet ajouté');
    }

    public function edit(Project $project){
        $teams = Team::all();
        return view('pages/edit/project', ['project' => $project, 'teams' => $teams]);
    }

    public function update(Project $project, Request $request){
       $data = $request->validate([
            'name' => 'required|string|max:100',
            'client' => 'required|string|max:100',
            'description' => 'nullable|string',
            'status' => 'required',
            'progression' => [
                'required',
                function ($attribute, $value, $fail) {
                    // Retire le symbole % si présent
                    $numericValue = str_replace('%', '', $value);

                    // Vérifie que c'est un nombre entier entre 0 et 100
                    if (!ctype_digit($numericValue) || (int)$numericValue < 0 || (int)$numericValue > 100) {
                        $fail('La progression doit être un nombre entre 0 et 100 (avec ou sans %).');
                    }
                }
            ],
            'team_id' => 'nullable|exists:teams,id',
        ]);

        $project->update($data);
        $project->team_id = $request->input('team');
        $project->save();

        return redirect(route('project.index'))->with('success', 'Projet mis à jour');
    }

    public function destroy(Project $project){
        $project->delete();
        return redirect(route('project.index'))->with('success', 'Projet supprimé');
    }
}
