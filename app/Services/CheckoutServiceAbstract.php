<?php

namespace App\Services;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

abstract class CheckoutServiceAbstract implements CheckoutServiceInterface
{
    /**
     * @var int
     */
    public int $total = 0;

    /**
     * @var int
     */
    public int $duration = 0;

    /**
     * @var Model
     */
    protected Model $rental;

    public function __construct(Model $rental)
    {
        $this->rental = $rental;

        $this->duration = $this->getDuration($this->rental->start_date, $this->rental->end_date);
    }

    /**
     * @param string $startDate
     * @param string $endDate
     * @return int
     */
    protected function getDuration(string $startDate, string $endDate): int
    {
        $to = Carbon::createFromFormat('Y-m-d', $startDate);
        $from = Carbon::createFromFormat('Y-m-d', $endDate);

        return $to->diffInDays($from) + 1;
    }
}
