<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Skill extends Model
{
    protected $fillable = [
        'NameSkill', 
        'title_skill_id', 
        'ClassIcon', 
        'StatusSkill'
    ];

    public function titleSkill()
    {
        return $this->belongsTo(TitleSkill::class, 'title_skill_id');
    }
}
