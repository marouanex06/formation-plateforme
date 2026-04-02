<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Enums\SessionMode;

class TrainingSession extends Model
{
    protected $fillable = [
        'formation_id',
        'user_id',
        'start_date',
        'end_date',
        'capacity',
        'mode',
        'city',
        'meeting_link',
        'status',
    ];

    protected $casts = [
        'mode'       => SessionMode::class,
        'start_date' => 'date',
        'end_date'   => 'date',
    ];

    public function formation()
    {
        return $this->belongsTo(Formation::class);
    }

    public function formateur()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function inscriptions()
    {
        return $this->hasMany(Inscription::class);
    }

    public function isFull(): bool
    {
        return $this->inscriptions()
            ->where('status', 'confirmee')
            ->count() >= $this->capacity;
    }
}