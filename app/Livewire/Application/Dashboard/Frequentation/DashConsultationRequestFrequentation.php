<?php

namespace App\Livewire\Application\Dashboard\Frequentation;

use App\Models\Subscription;
use App\Repositories\Product\Get\GetConsultationRequestGroupingCounterRepository;
use Livewire\Component;

class DashConsultationRequestFrequentation extends Component
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
        $this->month = $month;
        $this->year = $year;
    }
    public function render()
    {
        $subscription = Subscription::where('is_private', false)->get();

        return view('livewire.application.dashboard.frequentation.dash-consultation-request-frequentation', [
            'requests' => $this->month == '' ?
                GetConsultationRequestGroupingCounterRepository::getConsultationRequestGroupingBySubscriptionByDate($this->date)
                : GetConsultationRequestGroupingCounterRepository::getConsultationRequestGroupingBySubscriptionByMonth($this->month, $this->year)
        ]);
    }
}
