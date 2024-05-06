<?php

namespace App\Livewire\Application\Finance\Product;

use App\Livewire\Helpers\Date\DateFormatHelper;
use App\Models\Subscription;
use Livewire\Component;

class FinanceRapport extends Component
{
    public $months=[];
    public function mount(){
        $this->months=DateFormatHelper::getFrMonths();
    }
    public function render()
    {

        return view('livewire.application.finance.product.finance-rapport',[
            'subsctiptions' => Subscription::query()->where('is_private',false)
                    ->where('is_activated',true)->get()
        ]);
    }
}
