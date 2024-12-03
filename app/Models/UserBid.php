<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserBid extends Model
{
    use HasFactory;

    protected $fillable = [
        "user_id",
        "product_id",
        "bid_amount",
        "paid",
        "fund_transferred",
    ];

    public const SEARCHABLE = [
        "user_id"
    ];


    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function getFormattedBidDateAttribute()
    {
        return Carbon::parse($this->updated_at)->format('F j, Y h:i A');
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }
}
