<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Car extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'type',
        'transmission',
        'price_per_day',
        'image',
        'description',
        'is_available',
    ];

    protected $casts = [
        'price_per_day' => 'decimal:2',
        'is_available' => 'boolean',
    ];

    public function rentals(): HasMany
    {
        return $this->hasMany(Rental::class);
    }
}
