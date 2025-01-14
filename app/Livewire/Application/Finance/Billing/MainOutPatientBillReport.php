<?php

namespace App\Livewire\Application\Finance\Billing;

use Carbon\Carbon;
use Livewire\Component;

class MainOutPatientBillReport extends Component
{
    public string $month, $date, $date_versement, $year;
    public bool $isByDate = true;
    public function updatedDate($date): void
    {
        $this->dispatch('dateSelected', $date);
        $this->isByDate = true;
    }

    public function updatedMonth($month): void
    {
        $this->dispatch('monthSelected', $month);
        $this->isByDate = false;
    }
    public function updatedYear($year): void
    {
        $this->dispatch('yearSelected', $year);
    }
    public function mount(): void
    {
        $this->date = date('Y-m-d');
        $this->year = date('Y');
        $this->date_versement = Carbon::tomorrow()->format('Y-m-d');
    }
    public function render()
    {
        return view('livewire.application.finance.billing.main-out-patient-bill-report');
    }
}
