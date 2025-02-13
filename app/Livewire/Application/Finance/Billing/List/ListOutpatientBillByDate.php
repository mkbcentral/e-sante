<?php

namespace App\Livewire\Application\Finance\Billing\List;

use App\Livewire\Helpers\Query\MakeQueryBuilderHelper;
use App\Models\Currency;
use App\Models\OutpatientBill;
use App\Repositories\OutpatientBill\GetOutpatientRepository;
use Exception;
use Livewire\Component;
use Livewire\WithPagination;

class ListOutpatientBillByDate extends Component
{
    use WithPagination;
    protected $listeners = [
        'currencyName' => 'getCurrencyName',
        'refreshListBill' => '$refresh'
    ];
    public string $date_filter;
    public string $currencyName = Currency::DEFAULT_CURRENCY;

    /**
     * getCurrencyName
     * Get currency name
     * @param  mixed $currency
     * @return void
     */
    public function getCurrencyName(string $currency): void
    {
        $this->currencyName = $currency;
    }

    public function updatedDateFilter($val): void
    {
        $this->date_filter = $val;
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
            foreach ($outpatientBill->tarifs as $tarif) {
                MakeQueryBuilderHelper::deleteWithKey('outpatient_bill_tarif', 'outpatient_bill_id', $outpatientBill->id);
            }
            if ($outpatientBill->otherOutpatientBill) {
                $outpatientBill->otherOutpatientBill->delete();
            }
            $outpatientBill->delete();
            $this->dispatch('updated', ['message' => 'Action bien réalisée']);
        } catch (Exception $ex) {
            $this->dispatch('error', ['message' => $ex->getMessage()]);
        }
    }

    public function printBill(OutpatientBill $outpatientBill)
    {
        $outpatientBill->is_validated = true;
        $outpatientBill->update();
    }

    public function changeStatus(OutpatientBill $outpatientBill)
    {
        try {
            if ($outpatientBill->is_validated == true) {
                $outpatientBill->is_validated = false;
            } else {
                $outpatientBill->is_validated = true;
            }
            $outpatientBill->update();
            $this->dispatch('error', ['message' => 'Action bein réalisée !']);
        } catch (Exception $ex) {
            $this->dispatch('error', ['message' => $ex->getMessage()]);
        }
    }

    public function mount(): void
    {
        $this->date_filter = date('Y-m-d');
    }
    public function render()
    {
        return view('livewire.application.finance.billing.list.list-outpatient-bill-by-date', [
            'listBill' => GetOutpatientRepository::getOutpatientPatientByDate($this->date_filter),
            'tota_cdf' => GetOutpatientRepository::getTotalBillByDate($this->date_filter, 'CDF'),
            'tota_usd' => GetOutpatientRepository::getTotalBillByDate($this->date_filter, 'USD'),
            'counter_by_month' => GetOutpatientRepository::getCountOfOutpatientBillByDate($this->date_filter)
        ]);
    }
}
