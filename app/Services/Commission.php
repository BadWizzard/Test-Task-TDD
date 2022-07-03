<?php

namespace App\Services;

class Commission
{

    /**
     * We decide to take a 30% commission
     *
     * half goes to the insurance
     * 1€/day goes to the roadside assistance
     * the rest goes to us
     */

    public int $commissionPercent = 30;

    public int $commissionTotal = 0;

    public int $insuranceFee = 0;

    public int $assistanceFee = 0;

    public int $drivyFee = 0;

    private int $total;

    private int $duration;

    public function __construct(int $total, int $duration)
    {
        $this->duration = $duration;
        $this->total = $total;
        $this->commissionTotal = floor($this->total * ($this->commissionPercent / 100));
    }

    public function calculate()
    {
        $this->calculateInsuranceFee();
        $this->calculateAssistanceFee();

        // First of all calculate insurance fee and assistance fee
        $this->calculateDrivyFee();

    }

    private function calculateInsuranceFee()
    {
        $this->insuranceFee = floor($this->commissionTotal / 2);
    }

    private function calculateAssistanceFee()
    {
        $this->assistanceFee = $this->duration * 100;
    }

    private function calculateDrivyFee()
    {
        $this->drivyFee = $this->commissionTotal - $this->insuranceFee - $this->assistanceFee;
    }
}
