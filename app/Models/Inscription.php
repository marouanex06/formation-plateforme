<?php
// app/Models/Inscription.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Enums\InscriptionStatus;

class Inscription extends Model
{
    protected $fillable = [
        'user_id',
        'session_id',
        'reference',      // ex: INS-2024-0001
        'status',
        'note',
        'confirmed_at',
        'cancelled_at',
    ];

    protected $casts = [
        'status'       => InscriptionStatus::class,
        'confirmed_at' => 'datetime',
        'cancelled_at' => 'datetime',
    ];

    // L'inscription appartient à un participant
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // L'inscription appartient à une session
    public function session()
    {
        return $this->belongsTo(TrainingSession::class);
    }

    // Génère une référence unique avant création
    protected static function booted(): void
    {
        static::creating(function ($inscription) {
            // Format: INS-2024-0001
            $count = self::count() + 1;
            $inscription->reference = 'INS-' . date('Y') . '-' . str_pad($count, 4, '0', STR_PAD_LEFT);
        });
    }
}
