<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    protected $fillable = [
        'project_name',
        'project_type',
        'project_role',
        'project_description',
        'project_date',
        'status'
    ];

    protected $casts = ['status' => 'boolean'];

    public function project_links() {
        return $this->hasMany(ProjectLink::class, 'project_id');
    }

    public function scopeActive($query) {
        return $query->where('status', true);
    }
}
