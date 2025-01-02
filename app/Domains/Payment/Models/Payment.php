<?php

namespace App\Domains\Payment\Models;

use App\Domains\Payment\States\Payment\PaymentState;
use App\Domains\User\Models\User;
use App\Support\Models\Model;
use Database\Factories\PaymentFactory;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\ModelStates\HasStates;

class Payment extends Model
{
    use HasStates;

    protected $casts = [
        'state' => PaymentState::class,
    ];
    
    protected static function newFactory(): Factory
    {
        return PaymentFactory::new();
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
