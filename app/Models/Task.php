<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'completed', 'deadline', 'priority', 'reminder_offset', 'user_id'];

    protected $casts = [
        'deadline' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}