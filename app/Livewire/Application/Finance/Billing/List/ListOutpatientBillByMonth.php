<?php

namespace App\Livewire\Application\Finance\Billing\List;

use App\Models\Currency;
use App\Models\OutpatientBill;
use App\Repositories\OutpatientBill\GetOutpatientRepository;
use Exception;
use Livewire\Component;

class ListOutpatientBillByMonth extends Component
{
    protected $listeners = [
        'currencyName' => 'getCurrencyName',
        'refreshListBill' => '$refresh'
    ];
    public string $month;

    public function updatedMonth($val): void
    {
        $this->month = $val;
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
    }
    public function render()
    {
        return view('livewire.application.finance.billing.list.list-outpatient-bill-by-month', [
            'listBill' => GetOutpatientRepository::getOutpatientPatientByMonth($this->month),
            'tota_cdf' => GetOutpatientRepository::getTotalBillByMonthGroupByCDF($this->month),
            'tota_usd' => GetOutpatientRepository::getTotalBillByMonthGroupByUSD($this->month)
        ]);
    }
}
