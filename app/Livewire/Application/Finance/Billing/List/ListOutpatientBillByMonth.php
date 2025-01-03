<?php

namespace App\Livewire\Application\Finance\Billing\List;

use App\Models\OutpatientBill;
use App\Repositories\OutpatientBill\GetOutpatientRepository;
use Carbon\Carbon;
use Exception;
use Livewire\Component;
use Livewire\WithPagination;

class ListOutpatientBillByMonth extends Component
{
    use WithPagination;
    protected $listeners = [
        'currencyName' => 'getCurrencyName',
        'refreshListBill' => '$refresh'
    ];
    public string $month, $date, $date_versement, $year;
    public bool $isByDate = true;

    public function updatedDate($val): void
    {
        $this->date = $val;
        $this->isByDate = true;
    }

    public function updatedMonth($val): void
    {
        $this->month = $val;
        $this->isByDate = false;
    }
    /**
     * edit
     * Select OutpatientBill to edit
     * @param  mixed $outpatientBill
     * @return void
     */
    public function edit(?OutpatientBill $outpatientBill): void
    {
        $this->dispatch('outpatientSelected', $outpatientBill);
        $this->dispatch('outpatientBillToEdit', $outpatientBill);
        $this->dispatch('close-list-outpatient-bill-by-date-modal');
    }
    /**
     * delete
     * Delete OutpatientBill
     * @param  mixed $outpatientBill
     * @return void
     */
    public function delete(?OutpatientBill $outpatientBill)
    {
        try {
            $outpatientBill->delete();
            $this->dispatch('updated', ['message' => 'Action bien réalisée']);
        } catch (Exception $ex) {
            $this->dispatch('error', ['message' => $ex->getMessage()]);
        }
    }

    public function mount(): void
    {
        $this->month = date('m');
        $this->date = date('Y-m-d');
        $this->year = date('Y');
        $this->date_versement = Carbon::tomorrow()->format('Y-m-d');
    }
    public function render()
    {
        return view('livewire.application.finance.billing.list.list-outpatient-bill-by-month', [
            'listBill' => $this->isByDate ?
                GetOutpatientRepository::getOutpatientPatientByDate($this->date) :
                GetOutpatientRepository::getOutpatientPatientByMonth($this->month),
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
