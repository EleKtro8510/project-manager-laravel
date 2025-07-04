<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    protected $table = 'project';

    protected $fillable = [
        'name',
        'client',
        'description',
        'status',
        'progression'
    ];

    public function team()
    {
        return $this->belongsTo(Team::class);
    }
}