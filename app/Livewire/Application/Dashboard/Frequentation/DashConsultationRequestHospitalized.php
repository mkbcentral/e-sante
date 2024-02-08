<?php

namespace App\Livewire\Application\Dashboard\Frequentation;

use App\Repositories\Product\Get\GetConsultationRequestGroupingCounterRepository;
use Livewire\Component;

class DashConsultationRequestHospitalized extends Component
{
    public  $month, $year;

    public function mount()
    {
        $this->month = date('m');
        $this->year = date('Y');
    }

    public function render()
    {
        return view('livewire.application.dashboard.frequentation.dash-consultation-request-hospitalized',[
            'requests'=> GetConsultationRequestGroupingCounterRepository::getConsultationRequestGroupingBySubscriptionHospitalize($this->month, $this->year)
        ]);
    }
}
