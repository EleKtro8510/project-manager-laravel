<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Member;

class MemberController extends Controller
{
    public function index(){
        $members = Member::all();
        return view('pages/index/member', ['members' => $members]);
    }

    public function create(){
        return view('pages/create/member');
    }

    public function store(Request $request){
        $data = $request->validate([
            'name' => 'required|string|max:100',
            'role' => 'required|string',
        ]);
        $newMember = Member::create($data);

        return redirect(route('member.index'))->with('success', 'Membre ajouté');
    }

    public function edit(Member $member){
       return view('pages/edit/member', ['member' => $member]);
    }

    public function update(Member $member, Request $request){
        $data = $request->validate([
            'name' => 'required|string|max:100',
            'role' => 'required|string',
        ]);

        $member-> update($data);

        return redirect(route('member.index'))->with('success', 'Membre mis à jour');
    }

    public function destroy(Member $member){
        $member->delete();
        return redirect(route('member.index'))->with('success', 'Membre retiré');
    }
}
