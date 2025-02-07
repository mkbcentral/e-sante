<?php

namespace App\Livewire\Application\Sheet;

use App\Enums\RoleType;
use App\Models\Subscription;
use App\Repositories\Subscription\Get\GetSubscriptionRepository;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class MainConsultationRequest extends Component
{
    protected $listeners = [
        'refreshConsulting' => '$refresh'
    ];
    public int $selectedIndex;
    public string $selectedSubscriptionUrl = '';
    public bool $isByDate = true, $isByMonth = false, $isByPeriod = false;
    public function makeIsByDate()
    {
        $this->isByDate = true;
        $this->isByMonth = false;
        $this->isByPeriod = false;
        $this->dispatch('isByDate', $this->isByDate);
    }
    public function makeIsByMonth()
    {
        $this->isByDate = false;
        $this->isByMonth = true;
        $this->isByPeriod = false;
        $this->dispatch('isByMonth', $this->isByMonth);
    }
    public function makeIsByPeriod()
    {
        $this->isByDate = false;
        $this->isByMonth = false;
        $this->isByPeriod = true;
        $this->dispatch('isByPeriod', $this->isByPeriod);
    }

    public  function changeIndex(Subscription $subscription): void
    {
        $this->selectedIndex = $subscription->id;
        $this->dispatch('selectedIndex', $this->selectedIndex);
    }
    public function mount()
    {
        if ($this->selectedSubscriptionUrl != '') {
            $this->selectedIndex = Subscription::where(
                'name',
                $this->selectedSubscriptionUrl
            )->first()->id;
        } else {
            $subscription = Subscription::where(
                'name',
                'like',
                'PRIVE'
            )->first();
            if ($subscription) {
                $this->selectedIndex = $subscription->id;
            } else {
                $this->selectedIndex = 0;
            }
        }
        if (Auth::user()->roles->pluck('name')->contains(RoleType::ADMIN)) {
            $this->isByMonth = true;
            $this->isByDate = false;
        }
    }

    public function render()
    {
        return view('livewire.application.sheet.main-consultation-request', [
            'subscriptions' => GetSubscriptionRepository::getAllSubscriptionList(),
        ]);
    }
}
