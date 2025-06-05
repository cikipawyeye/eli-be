<?php

declare(strict_types=1);

namespace App\Domains\User\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use App\Domains\Payment\Models\Payment;
use App\Domains\User\Enums\GenderEnum;
use App\Domains\User\Enums\JobTypeEnum;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

/**
 * @mixin IdeHelperUser
 */
class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasApiTokens, HasFactory, HasRoles, Notifiable, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'birth_date',
        'job_type',
        'job',
        'phone_number',
        'gender',
        'device_id',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected static function newFactory(): Factory
    {
        return \Database\Factories\UserFactory::new();
    }

    protected static function booted()
    {
        static::saving(function ($user) {
            // make sure job is filled if job_type is "Other"
            $validator = Validator::make($user->attributesToArray(), [
                'job_type' => ['required', 'in:'.implode(',', JobTypeEnum::toArray())],
                'job' => [sprintf('required_if:job_type,%s', JobTypeEnum::Other->value)],
                'gender' => ['nullable', 'in:'.implode(',', GenderEnum::toArray())],
            ]);

            if ($validator->fails()) {
                throw new ValidationException($validator);
            }
        });
    }

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function payments(): HasMany
    {
        return $this->hasMany(Payment::class);
    }

    public function city(): BelongsTo
    {
        return $this->belongsTo(City::class, 'city_code', 'code');
    }

    /**
     * Interact with the permissions_by_roles attribute.
     *
     * return \Illuminate\Database\Eloquent\Casts\Attribute
     */
    public function permissionsByRoles(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->roles
                ->map(fn ($role) => $role->permissions)
                ->flatten()
                ->pluck('name')
                ->toArray(),
        );
    }
}
