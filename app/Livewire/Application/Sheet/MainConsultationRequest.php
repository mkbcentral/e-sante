<?php

namespace App\Livewire\Application\Sheet;

use App\Models\Hospital;
use App\Models\Subscription;
use Livewire\Component;

class MainConsultationRequest extends Component
{
    protected $listeners=[
        'refreshConsulting'=>'$refresh'
    ];
    public int $selectedIndex=1;
    public  function changeIndex(Subscription $subscription): void
    {
        $this->selectedIndex=$subscription->id;
        $this->dispatch('selectedIndex',$this->selectedIndex);
    }
    public function render()
    {
        return view('livewire.application.sheet.main-consultation-request',[
            'subscriptions'=>Subscription::where('hospital_id',Hospital::DEFAULT_HOSPITAL)->get(),
        ]);
    }
}
