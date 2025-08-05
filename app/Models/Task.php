<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class Task extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'completed', 'deadline', 'priority', 'reminder_offset', 'user_id'];

    protected $casts = [
        'deadline' => 'datetime',
        'completed' => 'boolean',
    ];

    protected $appends = ['is_overdue', 'is_near_deadline', 'priority_class', 'card_class', 'priority_badge_class'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getIsOverdueAttribute(): bool
    {
        return !$this->completed && $this->deadline && Carbon::now()->isAfter($this->deadline);
    }

    public function getIsNearDeadlineAttribute(): bool
    {
        return !$this->completed && $this->deadline && Carbon::now()->diffInHours($this->deadline, false) > 0 && Carbon::now()->diffInHours($this->deadline) < 24;
    }

    public function getPriorityClassAttribute(): string
    {
        $classes = [
            'Tinggi' => 'border-l-8 border-red-500',
            'Sedang' => 'border-l-8 border-yellow-500',
            'Rendah' => 'border-l-8 border-green-500',
        ];
        return $classes[$this->priority] ?? '';
    }

    public function getCardClassAttribute(): string
    {
        if ($this->completed) return 'bg-green-50';
        if ($this->is_overdue) return 'bg-red-50';
        if ($this->is_near_deadline) return 'bg-yellow-50';
        return 'bg-white';
    }

    public function getPriorityBadgeClassAttribute(): string
    {
        $classes = [
            'Tinggi' => 'bg-red-200 text-red-800',
            'Sedang' => 'bg-yellow-200 text-yellow-800',
            'Rendah' => 'bg-green-200 text-green-800',
        ];
        return $classes[$this->priority] ?? '';
    }
}
