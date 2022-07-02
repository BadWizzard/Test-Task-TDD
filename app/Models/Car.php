<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Car extends Model
{
    use HasFactory;

    public const TABLE = 'cars';

    public const MAP_ID = 'id';
    public const MAP_PRICE_PER_DAY = 'price_per_day';
    public const MAP_PRICE_PER_KM = 'price_per_km';
}
