<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TitleSkill extends Model
{
    protected $fillable = [
        'TitleSkill',
        'StatusTK'
    ];

    public function skills()
    {
        return $this->hasMany(Skill::class, 'title_skill_id');
    }
}
