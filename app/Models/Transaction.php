<?php

namespace App\Models;

use App\Enums\TransactionStatus;
use App\Enums\TransactionType;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasUuids;
    protected $guarded = ['id'];

    protected $casts = [
        'type' => TransactionType::class,
        'status' => TransactionStatus::class
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function receiver()
    {
        return $this->belongsTo(User::class, 'receiver_id');
    }
}
