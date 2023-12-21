<?php

namespace App\Livewire\Application\Finance\Billing;

use App\Models\OutpatientBill;
use Livewire\Component;

class OutpatientBillView extends Component
{
    protected $listeners = [
        'outpatientBill' => 'getOutpatient',
        'outpatientBillToEdit' => 'getOutpatientToEdit',
    ];
    public ?OutpatientBill $outpatientBill = null;

    public function getOutpatient()
    {
        $this->outpatientBill = OutpatientBill::latest()->first();
    }

    public function getOutpatientToEdit(?OutpatientBill $outpatientBill)
    {
        $this->outpatientBill =$outpatientBill;
    }
    public function openNewOutpatientBillModal()
    {
        $this->dispatch('open-new-outpatient-bill');
    }
    public function openListListOutpatientBillModal()
    {
        $this->dispatch('open-list-outpatient-bill-by-date-modal');
    }
    public function mount()
    {
        $this->outpatientBill = OutpatientBill::find(25);
    }

    public function render()
    {
        return view('livewire.application.finance.billing.outpatient-bill-view');
    }
}
