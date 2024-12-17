<?php

namespace App\Livewire\Application\Lab;

use App\Livewire\Helpers\Date\DateFormatHelper;
use App\Models\Subscription;
use App\Models\Tarif;
use Livewire\Component;

class LaboDailyReleases extends Component
{
    public string $month_name, $year;
    public $subscription_id = "";
    public $subscriptionName = "Tous";

    public function updatedSubscriptionId($value)
    {
        if ($value == "") {
            $this->subscriptionName = "Tous";
            return;
        }
        $subscription = Subscription::find($value);
        $this->subscriptionName = $subscription->name;
    }


    public function mount()
    {
        $this->month_name = date('m');
        $this->year = date('Y');
    }
    public function render()
    {
        return view('livewire.application.lab.labo-daily-releases', [
            'tarifs' => Tarif::query()->where('category_tarif_id', 1)
                ->orderBy('name', 'asc')
                ->with(['outpatientBills', 'consultationRequests'])
                ->get(),
            'days' => DateFormatHelper::getListDateForMonth($this->month_name, $this->year)
        ]);
    }
}
