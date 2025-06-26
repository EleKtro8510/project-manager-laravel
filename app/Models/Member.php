<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Member extends Model
{

    protected $fillable = [
        'name',
        'role',
        'team_id',
    ];

    public function team()
    {
        return $this->belongsTo(Team::class);
    }
}
