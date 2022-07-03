<?php

namespace Tests\Unit;

use App\Models\Rental;
use Tests\TestCase;

class BookCarLevel3Test extends TestCase
{
    /**
     * Test 1 Level 3.
     *
     * car: { "id": 1, "price_per_day": 2000, "price_per_km": 10 }
     * rental: { "id": 1, "car_id": 1, "start_date": "2015-12-8", "end_date": "2015-12-8", "distance": 100 }
     *
     * @return void
     */
    public function test1()
    {
        $rental = Rental::query()
            ->with('car')
            ->where(Rental::MAP_ID, 4)
            ->first();

        if (!$rental) {
            $this->assertTrue(false);
            return;
        }

        $checkoutCar = new CheckoutServiceLevel2($rental);
        $checkoutCar->checkout();
        $this->assertEquals(3000, $checkoutCar->total);
    }
}
