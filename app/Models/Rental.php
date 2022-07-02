<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rental extends Model
{
    use HasFactory;

    public const TABLE = 'rentals';

    public const MAP_ID = 'id';
    public const MAP_CAR_ID = 'car_id';
    public const MAP_START_DATE = 'start_date';
    public const MAP_END_DATE = 'end_date';
    public const MAP_DISTANCE = 'distance';
}
