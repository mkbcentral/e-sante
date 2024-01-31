<?php

namespace App\Livewire\Application\Sheet;

use App\Models\Subscription;
use App\Repositories\Subscription\Get\GetSubscriptionRepository;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Livewire\Component;

class MainConsultationRequest extends Component
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
        $subscription= Subscription::where('name', 'like', 'PRIVE')->first();
        if ($subscription) {
            $this->selectedIndex = $subscription->id;
        }else{
            $this->selectedIndex=0;
        }
    }


    /**
     * Render component
     * @return Application|Factory|View|\Illuminate\Foundation\Application
     */
    public function render()
    {
        return view('livewire.application.sheet.main-consultation-request', [
            'subscriptions' => GetSubscriptionRepository::getAllSubscriptionList(),
        ]);
    }
}
