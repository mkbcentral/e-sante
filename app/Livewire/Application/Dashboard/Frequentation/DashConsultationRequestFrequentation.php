<?php

namespace App\Livewire\Application\Dashboard\Frequentation;

use App\Models\Subscription;
use App\Repositories\Product\Get\GetConsultationRequestGroupingCounterRepository;
use Livewire\Component;

class DashConsultationRequestFrequentation extends Component
{
    public $date_filter = '', $month, $year;

    public function updatedDateFilter()
    {
        $this->month = '';
    }

    public function mount()
    {
        $this->date_filter = date('Y-m-d');
        $this->year = date('Y');
    }

    public function render()
    {
        $subscription=Subscription::where('is_private', false)->get();

        return view('livewire.application.dashboard.frequentation.dash-consultation-request-frequentation', [
            'requests' => $this->month == '' ?
                GetConsultationRequestGroupingCounterRepository::getConsultationRequestGroupingBySubscriptionByDate($this->date_filter)
                : GetConsultationRequestGroupingCounterRepository::getConsultationRequestGroupingBySubscriptionByMonth($this->month, $this->year)
        ]);
    }
}
