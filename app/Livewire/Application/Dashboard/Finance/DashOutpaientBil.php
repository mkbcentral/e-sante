<?php

namespace App\Livewire\Application\Dashboard\Finance;

use App\Repositories\OutpatientBill\GetOutpatientRepository;
use Livewire\Component;

class DashOutpaientBil extends Component
{
    public $date_filter = '', $month, $year;
    public function updatedDateFilter()
    {
        $this->month = '';
    }

    public function mount()
    {
        $this->date_filter = date('Y-m-d');
        $this->year = date('Y');
    }
    public function render()
    {
        return view('livewire.application.dashboard.finance.dash-outpaient-bil', [
            'tota_cdf' => $this->month == '' ?
                GetOutpatientRepository::getTotalBillByDateGroupByCDF($this->date_filter) :
                GetOutpatientRepository::getTotalBillByMonthGroupByCDF($this->month),
            'tota_usd' => $this->month == '' ?
                GetOutpatientRepository::getTotalBillByDateGroupByUSD($this->date_filter) :
                GetOutpatientRepository::getTotalBillByMonthGroupByUSD($this->month)
        ]);
    }
}
