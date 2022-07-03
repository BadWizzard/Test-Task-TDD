<?php

namespace Tests\Unit;

use App\Models\Rental;
use App\Services\CheckoutServiceLevel1;
use Tests\TestCase;

class BookCarLevel2Test extends TestCase
{
    /**
     * Test 1 Level 2.
     *
     * car: { "id": 1, "price_per_day": 2000, "price_per_km": 10 }
     * rental: { "id": 1, "car_id": 1, "start_date": "2017-12-8", "end_date": "2017-12-10", "distance": 100 }
     *
     * @return void
     */
    public function test1()
    {
        $rental = Rental::query()
            ->with('car')
            ->where(Rental::MAP_ID, 1)
            ->first();

        if(!$rental) {
            $this->assertTrue(false);
            return;
        }

        $checkoutCar = new CheckoutServiceLevel1($rental);
        $checkoutCar->checkout();
        $this->assertEquals(7000, $checkoutCar->total);
    }
}
