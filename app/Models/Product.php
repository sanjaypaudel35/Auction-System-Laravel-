<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Product extends Model
{
    use HasFactory;

    protected $guarded = [];

    public const SEARCHABLE = [
        "status",
        "approved",
        "start_date",
        "end_date",
        "category_id",
        "user_id",
        "approved",
        "expired_early",
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function formatted($price)
    {
        $currency = config("setting.currency.code");
        $placement = config("setting.currency.placement");

        if ($placement == "front") {
            $formattedPrice = "{$currency} {$price}";
        } else {
            $formattedPrice = "{$price} {$currency}";
        }

        return $formattedPrice;
    }

    public function getNextBidAmountAttribute()
    {
        return $this->topBids()->first()?->bid_amount + $this->bid_increment_amount;
    }

    public function getFormattedStartDateAttribute()
    {
        return Carbon::parse($this->start_date)->format('F j, Y');
    }

    public function getFormattedEndDateAttribute()
    {
        return Carbon::parse($this->end_date)->format('F j, Y');
    }

    public function getExpiredAttribute(): bool
    {
        $currentDateTime = Carbon::now()->toDateTimeString();

        $expired = 0;
        if (
            $currentDateTime > $this->end_date || $this->expired_early
            && $this->approved == 1
        ) {
            $expired = 1;
        }

        return $expired;
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function bids(): HasMany
    {
        return $this->hasMany(
            related: UserBid::class,
            foreignKey: "product_id"
        );
    }

    public function getIsUpcomingAttribute(): bool
    {
        $value = false;
        $currentDateTime = Carbon::now()->toDateTimeString();

        if (
            $this->start_date > $currentDateTime
            && $this->approved == 1
        ) {
            $value = true;
        }

        return $value;
    }

    public function getIsLiveAttribute(): bool
    {
        $value = false;
        $currentDateTime = Carbon::now()->toDateTimeString();

        if (
            $this->start_date <= $currentDateTime
            && $this->end_date >= $currentDateTime
            && $this->approved == 1
            && $this->expired_early == 0
        ) {
            $value = true;
        }

        return $value;
    }

    public function topBids(): HasMany
    {
        return $this->hasMany(
            related: UserBid::class,
            foreignKey: "product_id"
        )->orderBy("bid_amount", "desc");
    }
}
