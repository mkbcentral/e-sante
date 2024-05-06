<?php

namespace App\Livewire\Application\Labo;

use App\Livewire\Helpers\Date\DateFormatHelper;
use App\Repositories\Subscription\Get\GetSubscriptionRepository;
use Livewire\Component;

class LaboFinanceRapport extends Component
{
    public function render()
    {
        return view('livewire.application.labo.labo-finance-rapport',[
            'subscriptions'=>GetSubscriptionRepository::getAllSubscriptionListExecptPrivate(),
            'months'=>DateFormatHelper::getFrMonths()
        ]);
    }
}
