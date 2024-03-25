<?php

namespace App\Livewire\Application\Finance\Cashbox;

use App\Models\Payroll;
use App\Repositories\Payroll\GetPayrollRepository;
use Livewire\Component;

class PayrollByMonthView extends Component
{
    public  $month;

    public function addItems(?Payroll $payroll)
    {
        $this->dispatch('payRollItems', $payroll);
        $this->dispatch('open-list-pay-roll-items');
    }

    public function mount()
    {
        $this->month = date('m');
    }

    public function render()
    {
        return view('livewire.application.finance.cashbox.payroll-by-month-view',[
            'payRolls' => GetPayrollRepository::getPayrollByMonth($this->month),
            'totalUSD' => GetPayrollRepository::getTotalPayrollByMonthUSD($this->month),
            'totalCDF' => GetPayrollRepository::getTotalPayrollByMonthCDF($this->month),
        ]);
    }
}
