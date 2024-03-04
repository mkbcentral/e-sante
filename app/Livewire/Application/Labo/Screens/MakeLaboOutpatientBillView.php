<?php

namespace App\Livewire\Application\Labo\Screens;

use App\Models\OutpatientBill;
use Livewire\Component;

class MakeLaboOutpatientBillView extends Component
{
    public ?OutpatientBill $outpatientBill;

    public function mount(OutpatientBill $outpatientBill){
        $this->outpatientBill=$outpatientBill;
    }
    public function render()
    {
        return view('livewire.application.labo.screens.make-labo-outpatient-bill-view');
    }
}
