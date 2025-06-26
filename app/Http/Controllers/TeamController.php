<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Team;
use App\Models\Member;
use App\Models\Project;

class TeamController extends Controller
{
    public function index(){
        $teams = Team::all();
        return view('pages/index/team', ['teams' => $teams]);
    }

    public function create() {
    $availableMembers = Member::whereNull('team_id')->get();
    return view('pages/create/team', compact('availableMembers'));
    }

    public function store(Request $request){
        $data = $request->validate([
            'name' => 'required|string|max:100',
            'members' => 'sometimes|array|min:1',      
            'members.*' => 'required|string|max:100',
            'roles' => 'sometimes|array|min:1',
            'roles.*' => 'required|string|max:100',
            'existing_members' => 'sometimes|array', 
            'existing_members.*' => 'integer|exists:members,id',
        ]);

        $newTeam = Team::create([
            'name' => $data['name'],
        ]);

        if (!empty($data['members'])) {
            foreach ($data['members'] as $index => $memberName) {
                $memberRole = $data['roles'][$index] ?? null;

                $newTeam->members()->create([
                    'name' => $memberName,
                    'role' => $memberRole,
                ]);
            }
        }
        
        if (!empty($data['existing_members'])) {
            Member::whereIn('id', $data['existing_members'])
                ->update(['team_id' => $newTeam->id]);
        }

        return redirect(route('team.index'))->with('success', 'Equipe ajoutée');
    }

    public function edit(Team $team) {
        $availableMembers = Member::whereNull('team_id')->get();
        $teamMembers = Member::where('team_id', $team->id)->get();

        return view('pages.edit.team', [
            'team' => $team,
            'availableMembers' => $availableMembers,
            'teamMembers' => $teamMembers,
        ]);
    }

    public function destroy(Team $team){
        $team->delete();
        return redirect(route('team.index'))->with('success', 'Equipe supprimée');
    }

    public function update(Team $team, Request $request){
        $data = $request->validate([
            'name' => 'required|string|max:100',
            'members' => 'sometimes|array',
            'members.*' => 'required|string|max:100',
            'roles' => 'sometimes|array',
            'roles.*' => 'required|string|max:100',
            'existing_members' => 'sometimes|array', 
            'existing_members.*' => 'integer|exists:members,id',
        ]);

        $team->update(['name' => $data['name']]);

        $currentMemberIds = $team->members()->pluck('id')->toArray();

        $selectedMemberIds = $data['existing_members'] ?? [];

        $membersToDetach = array_diff($currentMemberIds, $selectedMemberIds);

        Member::whereIn('id', $membersToDetach)->update(['team_id' => null]);

        if (!empty($data['members'])) {
            foreach ($data['members'] as $index => $memberName) {
                $memberRole = $data['roles'][$index] ?? null;

                $newMember = $team->members()->create([
                    'name' => $memberName,
                    'role' => $memberRole,
                    'team_id' => $team->id,
                ]);
            }
        }

        if (!empty($data['existing_members'])) {
            Member::whereIn('id', $data['existing_members'])
                ->update(['team_id' => $team->id]);
        }

        return redirect(route('team.index'))->with('success', 'Équipe mise à jour');
    }
}