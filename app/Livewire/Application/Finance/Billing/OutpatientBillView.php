<?php

namespace App\Livewire\Application\Finance\Billing;

use App\Models\Currency;
use App\Models\OutpatientBill;
use Livewire\Component;

class OutpatientBillView extends Component
{
    /**
     * listeners
     *Array of listeners
     * @var array
     */
    protected $listeners = [
        'outpatientBill' => 'getOutpatient',
        'outpatientBillToEdit' => 'getOutpatientToEdit',
        'outpatientBillRefreshedMainView' => '$refresh',
        'currencyName' => 'getCurrencyName',
    ];
    public ?OutpatientBill $outpatientBill = null;
    public bool $isEditing = false;
    /**
     * @var string
     */
    public string $currencyName = Currency::DEFAULT_CURRENCY;

    /**
     * getCurrencyName
     * Get currency name
     * @param  mixed $currency
     * @return void
     */
    public function getCurrencyName(string $currency)
    {
        $this->currencyName = $currency;
    }

    /**
     * Get OutpatientBill if outpatientBillListener is emitted
     * getOutpatient
     * @return void
     */
    public function getOutpatient(): void
    {
        $this->outpatientBill = OutpatientBill::orderBy('id','desc')->first();
    }
    /**
     * Get OutpatientBill if outpatientBillToEditListener is emitted with edition mode
     * getOutpatientToEdit
     * @param  mixed $outpatientBill
     * @return void
     */
    public function getOutpatientToEdit(?OutpatientBill $outpatientBill): void
    {
        $this->outpatientBill = $outpatientBill;
        $this->isEditing = true;
        $this->dispatch('outpatientBillToFrom', $outpatientBill);
    }

    /**
     * openNewOutpatientBillModal
     *Open modal to create new bill
     * @return void
     */
    public function openNewOutpatientBillModal(): void
    {
        $this->dispatch('open-new-outpatient-bill');
    }
    /**
     * openListListOutpatientBillModal
     *Open modal to show list bills
     * @return void
     */

    public function openAddDetailFormModal()
    {
        $this->dispatch('open-form-detail-outpatient-bill');
        $this->dispatch('outpatientBillToDetail', $this->outpatientBill);
    }

    public function openListListOutpatientBillModal(): void
    {
        $this->dispatch('open-list-outpatient-bill-by-date-modal');
        $this->dispatch('refreshListBill');
    }

    public function printBill(OutpatientBill $outpatientBill)
    {
        $this->outpatientBill=null;
        $this->isEditing=false;
    }

    /**
     * @return void
     */
    public function mount()
    {
        $this->outpatientBill = OutpatientBill::orderBy('id', 'desc')->first();
    }

    public function render()
    {
        return view('livewire.application.finance.billing.outpatient-bill-view');
    }
}
