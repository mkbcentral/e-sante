<?php

namespace App\Livewire\Application\Dashboard\Finance;

use App\Models\Subscription;
use Livewire\Component;

class DashConsultationRequestFinance extends Component
{
    public $dataChart = [], $labelsChart = [];
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

        return view('livewire.application.dashboard.finance.dash-consultation-request-finance', [
            'subscriptions' => Subscription::where('is_private', false)
                ->where('is_personnel', false)->get(),
        ]);
    }
}
