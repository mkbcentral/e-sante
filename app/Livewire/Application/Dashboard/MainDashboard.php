<?php

namespace App\Livewire\Application\Dashboard;

use App\Http\Controllers\Report\Finance\OutpatientFinanceReportController;
use App\Repositories\OutpatientBill\ReportOutpatientRepository;
use Livewire\Component;

class MainDashboard extends Component
{
    public string $date = '', $month, $year;

    public function updatedDate($date)
    {
        $this->month = null;
        $this->dispatch('updatedDateData', $date);
    }
    public function updatedMonth($month)
    {
        $this->date = '';
        $this->dispatch('updatedMonthData', $month);
    }
    public function updatedYear($year)
    {
        $this->$year = $year;
        $this->dispatch('updatedYearData', $year);
    }

    public function mount()
    {
        $this->date = date('Y-m-d');
        $this->year = date('Y');
        //$data = ReportOutpatientRepository::getOuPatientBillSynthesisByMonth('01', '2025');
        //dd($data);
    }
    public function render()
    {
        return view('livewire.application.dashboard.main-dashboard');
    }
}
