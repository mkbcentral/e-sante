<?php

namespace App\Livewire\Application\Dashboard\Finance;

use App\Models\Subscription;
use Livewire\Component;

class DashConsultationRequestFinance extends Component
{
    public $month, $year;
    public $dataChart = [], $labelsChart = [];

    public function updatedDateFilter()
    {
        $this->month = '';
    }

    public function mount()
    {
        $this->month = date('m');
        $this->year = date('Y');
        $subscriptions = Subscription::where('is_private', false)
            ->orderBy('name', 'asc')
            ->where('is_personnel', false)->get();
        foreach ($subscriptions as $subscription) {
            $amount = $subscription->getAmountUSDBySubscription($this->month, $this->year);
            if ($amount != 0) {
                $this->dataChart[] = floor($amount);
                $this->labelsChart[] = $subscription->name;
            }
        }
    }

    public function render()
    {

        return view('livewire.application.dashboard.finance.dash-consultation-request-finance', [
            'subscriptions' => Subscription::where('is_private', false)
                ->where('is_personnel', false)->get(),
        ]);
    }
}
