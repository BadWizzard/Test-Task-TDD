<?php

namespace App\Services;

class CheckoutServiceLevel2 extends CheckoutServiceAbstract
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
        $pricePerDay = $this->getPricePerDayAfterDiscount($duration, $this->rental->car->price_per_day);

        return $pricePerDay * $duration;
    }

    /**
     * price per day decreases by 10% after 1 day
     * price per day decreases by 30% after 4 days
     * price per day decreases by 50% after 10 days
     *
     * @param int $duration
     * @param int $pricePerDay
     * @return int
     */
    public function getPricePerDayAfterDiscount(int $duration, int $pricePerDay): int
    {
        $discountPercent = 0;

        if ($duration > 10) {
            $discountPercent = 50;
        } elseif ($duration > 4) {
            $discountPercent = 30;
        } elseif ($duration > 1) {
            $discountPercent = 10;
        }

        return floor($pricePerDay * ($discountPercent / 100));
    }
}
