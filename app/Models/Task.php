<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    protected $table = 'tasks';

    protected $fillable = [
        'title',
        'description',
        'assigned_to',
        'building_id',
        'status',
        'due_date',
    ];
    
    public function building()
    {
        return $this->belongsTo(Building::class, 'building_id');
    }

    public function comments()
    {
        return $this->hasMany(Comment::class, 'task_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }
}
