<?php

namespace Tests\Unit;

use App\Models\Rental;
use App\Services\CheckoutServiceLevel1;
use Tests\TestCase;


class BookCarLevel1Test extends TestCase
{
    /**
     * Test 1 Level 1.
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

    /**
     * Test 2 Level 1.
     *
     * car: { "id": 1, "price_per_day": 2000, "price_per_km": 10 }
     * rental: { "id": 2, "car_id": 1, "start_date": "2017-12-14", "end_date": "2017-12-18", "distance": 550 }
     *
     * @return void
     */
    public function test2()
    {
        $rental = Rental::query()
            ->with('car')
            ->where(Rental::MAP_ID, 2)
            ->first();

        if(!$rental) {
            $this->assertTrue(false);
            return;
        }

        $checkoutCar = new CheckoutServiceLevel1($rental);
        $checkoutCar->checkout();
        $this->assertEquals(15500, $checkoutCar->total);
    }

    /**
     * Test 3 Level 1.
     *
     * car: { "id": 2, "price_per_day": 3000, "price_per_km": 15 }
     * rental: { "id": 3, "car_id": 2, "start_date": "2017-12-8", "end_date": "2017-12-10", "distance": 150 }
     *
     * @return void
     */
    public function test3()
    {
        $rental = Rental::query()
            ->with('car')
            ->where(Rental::MAP_ID, 3)
            ->first();

        if(!$rental) {
            $this->assertTrue(false);
            return;
        }

        $checkoutCar = new CheckoutServiceLevel1($rental);
        $checkoutCar->checkout();
        $this->assertEquals(11250, $checkoutCar->total);
    }
}
