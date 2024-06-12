<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Transaction extends Model
{
    use HasFactory;
    protected $fillable = [
        'payer', 'payee', 'value'
    ];

    public function payer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'payer');
    }

    public function payee(): BelongsTo
    {
        return $this->belongsTo(User::class, 'payee');
    }
}
