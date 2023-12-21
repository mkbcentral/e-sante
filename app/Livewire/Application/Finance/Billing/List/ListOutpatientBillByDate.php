<?php

namespace App\Livewire\Application\Finance\Billing\List;

use App\Models\OutpatientBill;
use Exception;
use Livewire\Component;

class ListOutpatientBillByDate extends Component
{
    public function edit(?OutpatientBill $outpatientBill){
        $this->dispatch('outpatientSelected',$outpatientBill);
        $this->dispatch('outpatientBillToEdit',$outpatientBill);
        $this->dispatch('close-list-outpatient-bill-by-date-modal');
    }
    public function delete(?OutpatientBill $outpatientBill){
        try {
            $outpatientBill->delete();
            $this->dispatch('updated',['message'=>'Action bien réalisée']);
        } catch (Exception $ex) {
           $this->dispatch('error',['message'=>$ex->getMessage()]);
        }
    }
    public function render()
    {
        return view('livewire.application.finance.billing.list.list-outpatient-bill-by-date',[
            'listBill'=>OutpatientBill::orderBy('created_at','DESC')->get()
        ]);
    }
}
