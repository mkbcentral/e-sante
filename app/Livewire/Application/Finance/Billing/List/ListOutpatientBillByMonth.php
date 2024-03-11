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
    public string $month, $date, $date_versement;
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
        $this->date_versement=Carbon::tomorrow()->format('Y-m-d');
    }
    public function render()
    {
        return view('livewire.application.finance.billing.list.list-outpatient-bill-by-month', [
            'listBill' => $this->isByDate ?
                GetOutpatientRepository::getOutpatientPatientByDate($this->date,true) :
                GetOutpatientRepository::getOutpatientPatientByMonth($this->month),
            'tota_cdf' =>  $this->isByDate ?
                GetOutpatientRepository::getTotalBillByDateGroupByCDF($this->date,true) :
                GetOutpatientRepository::getTotalBillByMonthGroupByCDF($this->month,true),
            'tota_usd' => $this->isByDate ?
                GetOutpatientRepository::getTotalBillByDateGroupByUSD($this->date,true) :
                GetOutpatientRepository::getTotalBillByMonthGroupByUSD($this->month),
            'counter_by_month' => $this->isByDate ?
                GetOutpatientRepository::getCountOfOutpatientBillByDate($this->date,true) :
                GetOutpatientRepository::getCountOfOutpatientBillByMonth($this->month),
        ]);
    }
}
