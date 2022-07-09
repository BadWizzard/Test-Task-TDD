<?php

namespace Tests\Unit;

use App\Models\Rental;
use App\Services\CheckoutServiceLevel4;
use Tests\TestCase;

class BookCarLevel4Test extends TestCase
{
    /**
     * Test 1 Level 4.
     *
     * car: { "id": 1, "price_per_day": 2000, "price_per_km": 10 }
     * rental: { "id": 1, "car_id": 1, "start_date": "2015-12-8", "end_date": "2015-12-8", "distance": 100, "deductible_reduction": true }
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

        $checkoutCar = new CheckoutServiceLevel4($rental);
        $checkoutCar->checkout();

        $this->assertEquals(3000, $checkoutCar->total);

        $this->assertEquals(450, $checkoutCar->commission->insuranceFee);
        $this->assertEquals(100, $checkoutCar->commission->assistanceFee);
        $this->assertEquals(350, $checkoutCar->commission->drivyFee);
        $this->assertEquals(400, $checkoutCar->insurance->deductibleReduction);
    }

    /**
     * Test 2 Level 4.
     *
     * car: { "id": 1, "price_per_day": 2000, "price_per_km": 10 }
     * rental: { "id": 2, "car_id": 1, "start_date": "2015-03-31", "end_date": "2015-04-01", "distance": 300, "deductible_reduction": false }
     *
     * @return void
     */
    public function test2()
    {
        $rental = Rental::query()
            ->with('car')
            ->where(Rental::MAP_ID, 5)
            ->first();

        if (!$rental) {
            $this->assertTrue(false);
            return;
        }

        $checkoutCar = new CheckoutServiceLevel4($rental);
        $checkoutCar->checkout();

        $this->assertEquals(6800, $checkoutCar->total);

        $this->assertEquals(1020, $checkoutCar->commission->insuranceFee);
        $this->assertEquals(200, $checkoutCar->commission->assistanceFee);
        $this->assertEquals(820, $checkoutCar->commission->drivyFee);
        $this->assertEquals(0, $checkoutCar->insurance->deductibleReduction);
    }

    /**
     * Test 3 Level 4.
     *
     * car: { "id": 1, "price_per_day": 2000, "price_per_km": 10 }
     * rental: { "id": 3, "car_id": 1, "start_date": "2015-07-3", "end_date": "2015-07-14", "distance": 1000, "deductible_reduction": true }
     *
     * @return void
     */
    public function test3()
    {
        $rental = Rental::query()
            ->with('car')
            ->where(Rental::MAP_ID, 6)
            ->first();

        if (!$rental) {
            $this->assertTrue(false);
            return;
        }

        $checkoutCar = new CheckoutServiceLevel4($rental);
        $checkoutCar->checkout();

        $this->assertEquals(27800, $checkoutCar->total);

        $this->assertEquals(4170, $checkoutCar->commission->insuranceFee);
        $this->assertEquals(1200, $checkoutCar->commission->assistanceFee);
        $this->assertEquals(2970, $checkoutCar->commission->drivyFee);
        $this->assertEquals(4800, $checkoutCar->insurance->deductibleReduction);
    }
}
