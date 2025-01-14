<?php

namespace App\Livewire\Application\Finance\Billing\List;

use App\Models\ConsultationRequest;
use App\Models\Hospital;
use App\Models\OutpatientBill;
use App\Models\Source;
use App\Repositories\OutpatientBill\GetOutpatientRepository;
use App\Repositories\Sheet\Get\GetConsultationRequestRepository;
use Carbon\Carbon;
use Exception;
use Livewire\Component;
use Livewire\WithPagination;

class ListOutpatientBillByMonth extends Component
{
    use WithPagination;
    protected $listeners = [
        'currencyName' => 'getCurrencyName',
        'refreshListBill' => '$refresh',
        'dateSelected' => 'getDate',
        'monthSelected' => 'getMonth',
        'yearSelected' => 'getYear',
    ];
    public string $month, $date, $date_versement, $year;
    public bool $isByDate = true;

    public function getDate($date)
    {
        $this->date = $date;
        $this->isByDate = true;
    }
    public function getMonth($month)
    {
        $this->month = $month;
        $this->isByDate = false;
    }
    public function getYear($year)
    {
        $this->year = $year;
    }
    public function mount($date, $month, $year): void
    {
        $this->date = $date;
        $this->month = $month;
        $this->year = $year;
    }
    public function render()
    {
        return view('livewire.application.finance.billing.list.list-outpatient-bill-by-month', [
            'listBill' => $this->isByDate ?
                GetOutpatientRepository::getOutpatientPatientByDate($this->date) :
                GetOutpatientRepository::getOutpatientPatientByMonth($this->month, $this->year),
            'tota_cdf' =>  $this->isByDate ?
                GetOutpatientRepository::getTotalBillByDate($this->date, 'CDF') :
                GetOutpatientRepository::getTotalBillByMonth($this->month, $this->year, 'CDF'),
            'tota_usd' => $this->isByDate ?
                GetOutpatientRepository::getTotalBillByDate($this->date, 'USD') :
                GetOutpatientRepository::getTotalBillByMonth($this->month, $this->year, 'USD'),
            'counter_by_month' => $this->isByDate ?
                GetOutpatientRepository::getCountOfOutpatientBillByDate($this->date) :
                GetOutpatientRepository::getCountOfOutpatientBillByMonth($this->month),

        ]);
    }
}
