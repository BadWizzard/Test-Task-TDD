<?php

namespace App\Services;

class CheckoutServiceLevel1 extends CheckoutServiceAbstract
{
    public function checkout(): int
    {
        $this->total = $this->getPriceByDuration();
        $this->total += $this->getPriceByDistance();

        return $this->total;
    }

    /**
     * @return int
     */
    private function getPriceByDistance(): int
    {
        return $this->rental->car->price_per_km * $this->rental->distance;
    }

    /**
     * @return int
     */
    public function getPriceByDuration(): int
    {
        $duration = $this->getDuration($this->rental->start_date, $this->rental->end_date);
        return $this->rental->car->price_per_day * $duration;
    }
}
