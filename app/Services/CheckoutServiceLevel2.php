<?php

namespace App\Services;

class CheckoutServiceLevel2 extends CheckoutServiceAbstract
{
    public function checkout(): int
    {
        $duration = $this->getDuration($this->rental->start_date, $this->rental->end_date);
        $this->total = $this->rental->car->price_per_day * $duration;

        $this->total += $this->rental->car->price_per_km * $this->rental->distance;

        return $this->total;
    }
}
