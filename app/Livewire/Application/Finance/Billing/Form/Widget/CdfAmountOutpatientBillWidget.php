<?php

namespace App\Livewire\Application\Finance\Billing\Form\Widget;

use App\Models\OutpatientBill;
use Livewire\Component;

class CdfAmountOutpatientBillWidget extends Component
{
    protected $listeners = [
        'refreshCdfAmount' => '$refresh',
        'outpatientSelected' => 'getSelectedOutpatient'
    ];
    public ?OutpatientBill $outpatientBill;

    public function getSelectedOutpatient(?OutpatientBill $outpatientBill)
    {
        $this->outpatientBill = $outpatientBill;
    }
    public function mount(?OutpatientBill $outpatientBill)
    {
        $this->outpatientBill = $outpatientBill;
    }
    public function render()
    {
        return view('livewire.application.finance.billing.form.widget.cdf-amount-outpatient-bill-widget');
    }
}
