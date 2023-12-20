<?php

namespace App\Livewire\Application\Finance\Billing\List;

use App\Models\OutpatientBill;
use Livewire\Component;

class ListOutpatientBillByDate extends Component
{
    protected $listeners = [
        'outpatientBill'=>'getOutpatient'
    ];
    public ?OutpatientBill $outpatientBill=null;
    public function getOutpatient(){
        $this->outpatientBill=OutpatientBill::latest()->first();
    }

    public function render()
    {
        return view('livewire.application.finance.billing.list.list-outpatient-bill-by-date');
    }
}
