<?php

namespace App\Livewire\Application\Dashboard\Frequentation;

use App\Repositories\Product\Get\GetConsultationRequestGroupingCounterRepository;
use Livewire\Component;

class DashConsultationRequestHospitalized extends Component
{
    public $date = '', $month, $year;

    protected $listeners = [
        'updatedDateData' => 'getDate',
        'updatedMonthData' => 'getMonth',
        'updatedYearData' => 'getYear',
    ];
    public function getDate(string $date)
    {
        $this->date = $date;
        $this->month = '';
    }
    public function getMonth($month)
    {
        $this->month = $month;
        $this->date = '';
    }
    public function getYear($year)
    {
        $this->year = $year;
    }

    public function mount(String $date, $month, $year)
    {
        $this->date = $date;
        $this->month = date('m');
        $this->year = $year;
    }
    public function render()
    {
        return view('livewire.application.dashboard.frequentation.dash-consultation-request-hospitalized', [
            'requests' => GetConsultationRequestGroupingCounterRepository::getConsultationRequestGroupingBySubscriptionHospitalize($this->month, $this->year)
        ]);
    }
}
