<?php

namespace App\Livewire\Application\Dashboard\Finance;
use App\Repositories\Sheet\Get\GetConsultationRequestionAmountRepository;
use Livewire\Component;

class DashConsultationRequestFinancePrivateHospilize extends Component
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
        return view('livewire.application.dashboard.finance.dash-consultation-request-finance-private-hospilize',[
            'tota_cdf' => GetConsultationRequestionAmountRepository::getTotalHospitalizeCDF(),
            'tota_usd' => GetConsultationRequestionAmountRepository::getTotalHospitalizeUSD()

        ]);
    }
}
