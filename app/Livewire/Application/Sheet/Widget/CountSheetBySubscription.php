<?php

namespace App\Livewire\Application\Sheet\Widget;

use App\Models\ConsultationSheet;
use App\Models\Hospital;
use Livewire\Component;

class CountSheetBySubscription extends Component
{
    protected $listeners=['subscriptionId'=>'getSubscriptionId'];
    public int $subscriptionId;

    public function getSubscriptionId(int $subscriptionId){
        $this->subscriptionId=$subscriptionId;
    }
    public function mount(int $subscriptionId){
        $this->subscriptionId=$subscriptionId;
    }
    public function render()
    {
        return view('livewire.application.sheet.widget.count-sheet-by-subscription',[
            'sheet_counter'=>ConsultationSheet::whereSubscriptionId($this->subscriptionId)
                ->where('hospital_id',Hospital::DEFAULT_HOSPITAL)
                ->count()
        ]);
    }
}
