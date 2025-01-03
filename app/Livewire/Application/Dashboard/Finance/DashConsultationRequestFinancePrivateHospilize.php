<?php

namespace App\Livewire\Application\Dashboard\Finance;

use App\Repositories\Sheet\Get\GetConsultationRequestionAmountRepository;
use Livewire\Component;

class DashConsultationRequestFinancePrivateHospilize extends Component
{
    public $date = '', $month, $year;

    protected $listeners = [
        'updatedDateData' => 'getDate',
        'updatedMonthData' => 'getMonth',
        'updatedYearData' => 'getYear',
    ];
    public function getDate(string $date)
    {
        $this->date = $date;
        $this->month = '';
    }
    public function getMonth($month)
    {
        $this->month = $month;
        $this->date = '';
    }
    public function getYear($year)
    {
        $this->year = $year;
    }

    public function mount(String $date, $month, $year)
    {
        $this->date = $date;
        $this->month = date('m');
        $this->year = $year;
    }
    public function render()
    {
        return view('livewire.application.dashboard.finance.dash-consultation-request-finance-private-hospilize', [
            'tota_cdf' => GetConsultationRequestionAmountRepository::getTotalHospitalizeCDF(),
            'tota_usd' => GetConsultationRequestionAmountRepository::getTotalHospitalizeUSD()

        ]);
    }
}
