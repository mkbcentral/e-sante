<?php

namespace App\Livewire\Application\Dashboard\Finance;

use App\Livewire\Helpers\Date\DateFormatHelper;
use App\Repositories\OutpatientBill\GetOutpatientRepository;
use App\Repositories\Sheet\Get\GetConsultationRequestionAmountRepository;
use Livewire\Component;
use PhpParser\Node\Expr\Cast\String_;

class DashOutpaientBil extends Component
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
        $this->month = $month;
        $this->year = $year;
    }
    public function render()
    {
        return view('livewire.application.dashboard.finance.dash-outpaient-bil', [
            'tota_cdf' => $this->month == '' ?
                GetOutpatientRepository::getTotalBillByDate($this->date, 'CDF') :
                GetOutpatientRepository::getTotalBillByMonth($this->month, $this->year, 'CDF'),
            'tota_usd' => $this->month == '' ?
                GetOutpatientRepository::getTotalBillByDate($this->date, 'USD') :
                GetOutpatientRepository::getTotalBillByMonth($this->month, $this->year, 'USD'),
        ]);
    }
}
