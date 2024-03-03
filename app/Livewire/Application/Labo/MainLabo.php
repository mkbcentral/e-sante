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

    public function makeIsByDate()
    {
        $this->isByDate = true;
        $this->isByMonth = false;
        $this->isByPeriod = false;
    }
    public function makeIsByMonth()
    {
        $this->isByDate = false;
        $this->isByMonth = true;
        $this->isByPeriod = false;
    }
    public function makeIsByPeriod()
    {
        $this->isByDate = false;
        $this->isByMonth = false;
        $this->isByPeriod = true;
    }

    /**
     * Change Subscription Selected
     * @param Subscription $subscription
     * @return void
     */
    public  function changeIndex(Subscription $subscription): void
    {
        $this->selectedIndex = $subscription->id;
        $this->dispatch('selectedIndex', $this->selectedIndex);
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
