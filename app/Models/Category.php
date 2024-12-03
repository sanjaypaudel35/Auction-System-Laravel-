<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected function getStatusValueAttribute(): string
    {
        return ($this->status == 1) ? "active" : "inactive";
    }

    public function getRawStatusAttribute()
    {
        return $this->status;
    }
}
