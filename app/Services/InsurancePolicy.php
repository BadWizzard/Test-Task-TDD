<?php

namespace App\Services;

use Illuminate\Database\Eloquent\Model;

class InsurancePolicy
{
    /**
     * the driver is charged an additional 4€/day when she chooses the "deductible reduction" option
     */

    public const DEDUCTIBLE_REDUCTION_PER_DAY = 400;

    /**
     * @var int
     */
    public int $deductibleReduction = 0;

    /**
     * @var int
     */
    private int $duration;

    /**
     * @var Model
     */
    private Model $rental;

    public function __construct(Model $rental, int $duration)
    {
        $this->rental = $rental;
        $this->duration = $duration;
    }

    public function calculate()
    {
        if (!$this->rental->deductible_reduction) {
            $this->deductibleReduction = 0;
            return;
        }

        $this->deductibleReduction = $this->duration * self::DEDUCTIBLE_REDUCTION_PER_DAY;
    }
}
