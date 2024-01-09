<?php

namespace App\Livewire\Application\Finance\Billing;

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
        'outpatientBillRefreshedMainView'=>'$refresh'
    ];
    public ?OutpatientBill $outpatientBill = null;
    public bool $isEditing = false;

    /**
     * Get OutpatientBill if outpatientBillListener is emitted
     * getOutpatient
     * @return void
     */
    public function getOutpatient(): void
    {
        $this->outpatientBill = OutpatientBill::latest()->first();
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
        $this->dispatch('outpatientBillToFrom',$outpatientBill);
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
    public function openListListOutpatientBillModal(): void
    {
        $this->dispatch('open-list-outpatient-bill-by-date-modal');
        $this->dispatch('refreshListBill');
    }

    /**
     * @return void
     */
    public function mount()
    {
        //$this->outpatientBill = OutpatientBill::find(1);
    }

    public function render()
    {
        return view('livewire.application.finance.billing.outpatient-bill-view');
    }
}
