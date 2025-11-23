<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $fillable = [
        'content', 
        'status', 
        'user_id'
    ];

    protected $casts = [
        'status' => 'boolean'
    ];
    
    public function user() {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function scopeActive($query) {
        return $query->where('status', true);
    }

    public function getUserNameAttribute() {
        return $this->user?->name ?? 'Người dùng đã xóa';
    }

    protected $hidden = [];

    protected $appends = [
        'user_name'
    ];
}
