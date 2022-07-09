<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Rental extends Model
{
    use HasFactory;

    public const TABLE = 'rentals';

    public const MAP_ID = 'id';
    public const MAP_CAR_ID = 'car_id';
    public const MAP_START_DATE = 'start_date';
    public const MAP_END_DATE = 'end_date';
    public const MAP_DISTANCE = 'distance';
    public const MAP_DEDUCTIBLE_REDUCTION = 'deductible_reduction';

    /**
     * @return HasOne
     */
    public function car(): HasOne
    {
        return $this->hasOne(
            Car::class,
            Car::MAP_ID,
            self::MAP_CAR_ID
        );
    }
}
