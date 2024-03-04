<?php

namespace App\Livewire\Application\Labo;

use App\Models\Subscription;
use App\Repositories\Subscription\Get\GetSubscriptionRepository;
use Livewire\Component;

class MainLabo extends Component
{
    protected $listeners = [
        'refreshConsulting' => '$refresh'
    ];
    public int $selectedIndex;
    public bool $isByDate = true, $isByMonth = false, $isByPeriod = false;
    public $isPrivate=false;

    public function makeIsByDate()
    {
        $this->isByDate = true;
        $this->isByMonth = false;
        $this->isByPeriod = false;
        $this->dispatch('byDate', $this->isByDate);
    }
    public function makeIsByMonth()
    {
        $this->isByDate = false;
        $this->isByMonth = true;
        $this->isByPeriod = false;
        $this->dispatch('byMonth', $this->isByMonth);
    }
    public function makeIsByPeriod()
    {
        $this->isByDate = false;
        $this->isByMonth = false;
        $this->isByPeriod = true;
        $this->dispatch('byPeriod', $this->isByPeriod);
    }

    /**
     * Change Subscription Selected
     * @param Subscription $subscription
     * @return void
     */
    public  function changeIndex(Subscription $subscription): void
    {
        $this->selectedIndex = $subscription->id;
        $this->isPrivate=false;
        $this->dispatch('selectedIndex', $this->selectedIndex);
    }

    public function makeIsPrivate(){
        $this->isPrivate=true;
        $this->selectedIndex=0;
    }

    public function mount()
    {
        $subscription = Subscription::where('name', 'like', 'OCC')->first();
        if ($subscription) {
            $this->selectedIndex = $subscription->id;
        } else {
            $this->selectedIndex = 0;
        }
    }


    public function render()
    {
        return view('livewire.application.labo.main-labo', [
            'subscriptions' => GetSubscriptionRepository::getAllSubscriptionListExecptPrivate(),

        ]);
    }
}
