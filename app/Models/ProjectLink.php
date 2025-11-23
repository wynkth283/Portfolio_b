<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProjectLink extends Model
{
    protected $fillable = [
        'link_name', 
        'link', 
        'status', 
        'project_id'
    ];

    protected $casts = ['status' => 'boolean'];

    public function project() {
        return $this->belongsTo(Project::class, 'project_id');
    }

    public function scopeActive($query) {
        return $query->where('status', true);
    }
}
