<?php

namespace App\Livewire\Application\Dashboard\Finance;

use App\Models\Currency;
use App\Repositories\Payroll\GetPayrollRepository;
use Livewire\Component;

class DashPayrollByDate extends Component
{
    public $date_filter, $month;
    public bool $isByDate = true;

    public function updatedDateFilter()
    {
        $this->isByDate = true;
    }
    public function updatedMonth()
    {
        $this->isByDate = false;
    }


    public function mount()
    {
        $this->date_filter = date('Y-m-d');
        $this->month = date('m');
    }

    public function render()
    {
        return view('livewire.application.dashboard.finance.dash-payroll-by-date', [
            'totalUSD' => $this->isByDate == true ?
                GetPayrollRepository::getTotalPayrollByDate($this->date_filter, Currency::USD) :
                GetPayrollRepository::getTotalPayrollByMonth($this->month, Currency::USD),
            'totalCDF' => $this->isByDate == true ?
                 GetPayrollRepository::getTotalPayrollByDate($this->date_filter, Currency::CDF):
                 GetPayrollRepository::getTotalPayrollByMonth($this->month, Currency::CDF),
        ]);
    }
}
