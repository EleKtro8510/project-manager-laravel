<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Team extends Model
{

    protected $fillable = [
        'name',
        'member',
        'project'
    ];

    public function projects()
    {
        return $this->hasMany(Project::class);
    }

    public function members()
    {
        return $this->hasMany(Member::class);
    }
}
