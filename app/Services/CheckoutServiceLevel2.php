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
     *
     * @return int
     */
    public function getPriceByDuration(): int
    {
        $discountAmount = $this->getDiscountAmount($this->rental->car->price_per_day, $this->duration);

        return $this->rental->car->price_per_day * $this->duration - $discountAmount;
    }

    /**
     * @param int $pricePerDay
     * @param int $duration
     * @return int
     */
    private function getDiscountAmount(int $pricePerDay, int $duration): int
    {
        $discountAmount = 0;
        for ($i = 1; $i <= $duration; $i++) {
            $discountPercent = $this->getDiscountPercent($i);
            $discountAmount += $pricePerDay * ($discountPercent / 100);
        }

        return $discountAmount;
    }

    /**
     * price per day decreases by 10% after 1 day
     * price per day decreases by 30% after 4 days
     * price per day decreases by 50% after 10 days
     *
     * @param int $days
     * @return int
     */
    private function getDiscountPercent(int $days): int
    {
        $discountPercent = 0;
        if ($days > 10) {
            $discountPercent = 50;
        } elseif ($days > 4) {
            $discountPercent = 30;
        } elseif ($days > 1) {
            $discountPercent = 10;
        }

        return $discountPercent;
    }
}
