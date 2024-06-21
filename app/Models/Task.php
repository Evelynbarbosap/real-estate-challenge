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

    public function scopeCreatedAtBetween($query, $startDate, $endDate)
    {
        return $query->whereBetween('created_at', [$startDate, $endDate]);
    }

    public function scopeAssignedTo($query, $userId)
    {
        return $query->where('assigned_to', $userId);
    }

    public function scopeStatus($query, $status)
    {
        return $query->where('status', $status);
    }

    public function formattedDueDate()
    {
        return $this->due_date ? Carbon::parse($this->due_date)->format('d/m/Y H:i') : null;
    }
}
