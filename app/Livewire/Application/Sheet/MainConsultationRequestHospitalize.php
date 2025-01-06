<?php

namespace App\Livewire\Application\Sheet;

use App\Enums\RoleType;
use App\Models\Subscription;
use App\Repositories\Subscription\Get\GetSubscriptionRepository;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class MainConsultationRequestHospitalize extends Component
{
    protected $listeners = [
        'refreshConsulting' => '$refresh'
    ];
    public int $selectedIndex;
    public string $selectedSubscriptionUrl = '';
    public bool $isByDate = true, $isByMonth = false, $isByPeriod = false;
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
        if ($this->selectedSubscriptionUrl != '') {
            $this->selectedIndex = Subscription::where('name', $this->selectedSubscriptionUrl)->first()->id;
        } else {
            $subscription = Subscription::where('name', 'like', 'PRIVE')->first();
            if ($subscription) {
                $this->selectedIndex = $subscription->id;
            } else {
                $this->selectedIndex = 0;
            }
        }
    }


    public function render()
    {
        return view('livewire.application.sheet.main-consultation-request-hospitalize', [
            'subscriptions' => Auth::user()->roles->pluck('name')->contains(RoleType::MONEY_BOX) ||
                Auth::user()->roles->pluck('name')->contains(RoleType::FINANCE_RECIPES) ||
                Auth::user()->roles->pluck('name')->contains(RoleType::FINANCE_EXPENSES) ?
                GetSubscriptionRepository::getAllSubscriptionListPrivateOnly() :
                GetSubscriptionRepository::getAllSubscriptionList()
        ]);
    }
}
