<?php

namespace App\Services;

use Carbon\Carbon;
use DateTime;
use Illuminate\Database\Eloquent\Model;

class CheckoutServiceLevel1 implements CheckoutServiceInterface
{
    public int $total = 0;

    private Model $rental;

    public function __construct(Model $rental)
    {
        $this->rental = $rental;
    }

    public function checkout(): int
    {
        $duration = $this->getDuration();
        $this->total = $this->rental->car->price_per_day * $duration;

        $this->total += $this->rental->car->price_per_km * $this->rental->distance;

        return $this->total;
    }

    /**
     * @return int
     */
    private function getDuration(): int
    {
        $to = Carbon::createFromFormat('Y-m-d', $this->rental->start_date);
        $from = Carbon::createFromFormat('Y-m-d', $this->rental->end_date);

        return $to->diffInDays($from) + 1;
    }
}
