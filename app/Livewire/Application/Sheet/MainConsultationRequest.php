<?php

namespace App\Livewire\Application\Sheet;

use App\Models\Hospital;
use App\Models\Subscription;
use App\Repositories\Subscription\Get\GetSubscriptionRepository;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Livewire\Component;

class MainConsultationRequest extends Component
{
    protected $listeners=[
        'refreshConsulting'=>'$refresh'
    ];
    public int $selectedIndex=1;

    /**
     * Change Subscription Selected
     * @param Subscription $subscription
     * @return void
     */
    public  function changeIndex(Subscription $subscription): void
    {
        $this->selectedIndex=$subscription->id;
        $this->dispatch('selectedIndex',$this->selectedIndex);
    }

    /**
     * Render component
     * @return Application|Factory|View|\Illuminate\Foundation\Application
     */
    public function render()
    {
        return view('livewire.application.sheet.main-consultation-request',[
            'subscriptions'=>GetSubscriptionRepository::getAllSubscriptionList(),
        ]);
    }
}
