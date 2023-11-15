<?php

namespace App\Livewire\Application\Sheet;

use App\Models\ConsultationSheet;
use App\Models\Subscription;
use Livewire\Component;

class MainSheet extends Component
{
    public int $selectedIndex=1;
    public  function changeIndex(Subscription $subscription): void
    {
        $this->selectedIndex=$subscription->id;
        $this->dispatch('selectedIndex',$this->selectedIndex);
        $this->dispatch('subscriptionId',$this->selectedIndex);
    }
    public function render()
    {
        return view('livewire.application.sheet.main-sheet',[
            'subscriptions'=>Subscription::where('hospital_id',1)->get(),
        ]);
    }
}
