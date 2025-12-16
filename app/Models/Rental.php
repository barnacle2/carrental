<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\User;
use App\Models\Car;

class Rental extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'car_id',
        'name',
        'phone',
        'address',
        'start_date',
        'end_date',
        'duration',
        'total_cost',
        'license_path',
        'payment_method',
        'status'
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'total_cost' => 'decimal:2',
        'duration' => 'integer'
    ];

    protected $with = ['car', 'user'];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function car(): BelongsTo
    {
        return $this->belongsTo(Car::class);
    }

    public function getEndDateAttribute()
    {
        if (!$this->start_date || !$this->duration) {
            return null;
        }
        return $this->start_date->addDays($this->duration);
    }
}
