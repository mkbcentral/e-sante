<?php

namespace App\Livewire\Application\Finance\Rapport;

use App\Models\CategoryTarif;
use App\Models\Subscription;
use Livewire\Component;

class RapportFinanceBySubscriptionView extends Component
{

    public Subscription $subscription;
    public string $month;

    public function mount(){
    }

    public function render()
    {
        return view('livewire.application.finance.rapport.rapport-finance-by-subscription-view',[
            'categories'=>CategoryTarif::query()->get()
        ]);
    }
}
