<?php

namespace App\Livewire\Application\Dashboard\Finance;

use App\Repositories\Payroll\GetPayrollRepository;
use Livewire\Component;

class DashPayrollByDate extends Component
{
    public $date_filter;
    public function mount()
    {
        $this->date_filter = date('Y-m-d');
    }

    public function render()
    {
        return view('livewire.application.dashboard.finance.dash-payroll-by-date',[
            'totalUSD' => GetPayrollRepository::getTotalPayrollByDateUSD($this->date_filter),
            'totalCDF' => GetPayrollRepository::getTotalPayrollByDateCDF($this->date_filter),
        ]);
    }
}
