<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Project;

class ProjectController extends Controller
{
    public function index(){
        $projects = Project::all();
        return view('pages/index', ['projects' => $projects]);
    }

    public function create(){
        return view('pages/create');
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
        ]);

    // Nettoyer la valeur pour l’enregistrer correctement
    $data['progression'] = (int) str_replace('%', '', $data['progression']);

        
        $newProject = Project::create($data);

        return redirect(route('project.index'))->with('success', 'Projet ajouté');
    }

    public function edit(Project $project){
       return view('pages.edit', ['project' => $project]);
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
        ]);

        $project->update($data);

        return redirect(route('project.index'))->with('success', 'Projet mis à jour');
    }

    public function destroy(Project $project){
        $project->delete();
        return redirect(route('project.index'))->with('success', 'Projet supprimé');
    }
}
