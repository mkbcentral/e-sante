<?php

namespace App\Livewire\Application\Sheet;

use App\Models\Subscription;
use App\Repositories\Subscription\Get\GetSubscriptionRepository;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Livewire\Component;
use PhpParser\Builder\Function_;

class MainSheet extends Component
{
    public int $selectedIndex;

    /**
     * Change index item selected
     * @param Subscription $subscription
     * @return void
     */
    public  function changeIndex(Subscription $subscription): void
    {
        $this->selectedIndex=$subscription->id;
        $this->dispatch('selectedIndex',$this->selectedIndex);
        $this->dispatch('subscriptionId',$this->selectedIndex);
    }

    public function mount(){
        $this->selectedIndex=Subscription::where('name','like','PRIVE')->first()->id;
    }

    /**
     * Render component
     * @return Application|Factory|View|\Illuminate\Foundation\Application
     */
    public function render()
    {
        return view('livewire.application.sheet.main-sheet',[
            'subscriptions'=>GetSubscriptionRepository::getAllSubscriptionList(),
        ]);
    }
}
