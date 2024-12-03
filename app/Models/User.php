<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use Carbon\Carbon;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        "name",
        "email",
        "password",
        "role_id",
        "phone_number",
        "address",
        "created_by",
    ];

    public const SEARCHABLE = [
        "role_id",
    ];

    protected $hidden = [
        "password",
        "remember_token",
    ];

    protected $casts = [
        "email_verified_at" => "datetime",
        "password" => "hashed",
    ];


    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }

    public function bids(): HasMany
    {
        return $this->hasMany(
            related: UserBid::class,
            foreignKey: "user_id"
        );
    }

    public function getFormattedCreatedAtAttribute()
    {
        return Carbon::parse($this->created_at)->format('F j, Y');
    }

    public function role(): BelongsTo
    {
        return $this->belongsTo(Role::class);
    }

    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(self::class, "created_by");
    }
}
