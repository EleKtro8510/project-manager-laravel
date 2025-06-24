<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProjectController;

Route::get('/', function () {
    return redirect('/index');
});

Route::get('/index', [ProjectController::class, 'index'])->name('project.index');
Route::get('/create', [ProjectController::class, 'create'])->name('project.create');
Route::post('/index', [ProjectController::class, 'store'])->name('project.store');
Route::get('/index/{project}/edit', [ProjectController::class, 'edit'])->name('project.edit');
Route::put('/index/{project}/update', [ProjectController::class, 'update'])->name('project.update');
Route::delete('/index/{project}/destroy', [ProjectController::class, 'destroy'])->name('project.destroy');

Route::post('/projects/dummy', [ProjectController::class, 'storeDummy'])->name('project.dummy');