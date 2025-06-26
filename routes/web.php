<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\TeamController;
use App\Http\Controllers\MemberController;

Route::get('/', function () {
    return redirect('/index/project');
});
// Project Management
Route::get('/index/project', [ProjectController::class, 'index'])->name('project.index');
Route::get('/create/project', [ProjectController::class, 'create'])->name('project.create');
Route::post('/index/project', [ProjectController::class, 'store'])->name('project.store');
Route::get('/index/project/{project}/edit', [ProjectController::class, 'edit'])->name('project.edit');
Route::put('/index/project/{project}/update', [ProjectController::class, 'update'])->name('project.update');
Route::delete('/index/project/{project}/destroy', [ProjectController::class, 'destroy'])->name('project.destroy');

Route::post('/project/{project}/mark-as/{status}', [ProjectController::class, 'markAs'])->name('project.markAs');

// Team Management
Route::get('/index/team', [TeamController::class, 'index'])->name('team.index');
Route::get('/create/team', [TeamController::class, 'create'])->name('team.create');
Route::post('/index/team', [TeamController::class, 'store'])->name('team.store');
Route::get('/index/team/{team}/edit', [TeamController::class, 'edit'])->name('team.edit');
Route::put('/index/team/{team}/update', [TeamController::class, 'update'])->name('team.update');
Route::delete('/index/team/{team}/destroy', [TeamController::class, 'destroy'])->name('team.destroy');

// Member Management
Route::get('/index/member', [MemberController::class, 'index'])->name('member.index');
Route::get('/create/member', [MemberController::class, 'create'])->name('member.create');
Route::post('/index/member', [MemberController::class, 'store'])->name('member.store');
Route::get('/index/member/{member}/edit', [MemberController::class, 'edit'])->name('member.edit');
Route::put('/index/member/{member}/update', [MemberController::class, 'update'])->name('member.update');
Route::delete('/index/member/{member}/destroy', [MemberController::class, 'destroy'])->name('member.destroy');
