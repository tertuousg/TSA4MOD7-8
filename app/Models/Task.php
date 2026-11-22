<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Task extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'description', 'due_date', 'priority', 'status', 'is_archived'];
    protected function casts(): array { return ['due_date' => 'date', 'is_archived' => 'boolean']; }
    public function scopeActive($query) { return $query->where('is_archived', false); }
}
