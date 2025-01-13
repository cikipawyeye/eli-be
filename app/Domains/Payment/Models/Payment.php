<?php

declare(strict_types=1);

namespace App\Domains\Payment\Models;

use App\Domains\Payment\States\Payment\PaymentState;
use App\Domains\User\Models\User;
use App\Support\Models\Model;
use Database\Factories\PaymentFactory;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\ModelStates\HasStates;

/**
 * @mixin IdeHelperPayment
 */
class Payment extends Model
{
    use HasStates;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['x_payment_id', 'x_payment_request_id', 'x_payment_method_id', 'amount', 'payment_method_type'];

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
