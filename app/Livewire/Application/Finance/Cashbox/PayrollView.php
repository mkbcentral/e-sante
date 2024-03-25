<?php

namespace App\Livewire\Application\Finance\Cashbox;

use App\Models\Payroll;
use App\Repositories\Payroll\GetPayrollRepository;
use Livewire\Component;

class PayrollView extends Component
{

    protected $listeners = [
        'refreshdPayroll' => '$refresh',
    ];
    public ?Payroll $payroll = null;
    public $date_filter;
    public function openAddModal()
    {

        $this->dispatch('open-form-pay-roll');
    }

    public function addItems(?Payroll $payroll)
    {
        $this->dispatch('payRollItems', $payroll);
        $this->dispatch('open-list-pay-roll-items');
    }

    public function edit(?Payroll $payroll)
    {
        $this->dispatch('payRoll', $payroll);
        $this->dispatch('open-form-pay-roll');
    }

    public function delete(?Payroll $payroll)
    {
        try {
            if ($payroll->payRollItems->isEmpty()) {
                $payroll->delete();
                $this->dispatch('added', ['message' => 'Action bien réalisée']);
            } elseif ($payroll->is_valided == true) {
                $this->dispatch('error', ['message' => " Action impossible,L'état de paie est cloturé"]);
            } else {
                $this->dispatch('error', ['message' => "Action impossible, L'état de paie contient des données"]);
            }
        } catch (\Exception $ex) {
            $this->dispatch('error', ['message' => $ex->getMessage()]);
        }
    }

    public function mount()
    {
        $this->date_filter = date('Y-m-d');
    }

    public function render()
    {
        return view('livewire.application.finance.cashbox.payroll-view', [
            'payRolls' => GetPayrollRepository::getPayrollBydate($this->date_filter),
            'totalUSD' => GetPayrollRepository::getTotalPayrollByDateUSD($this->date_filter),
            'totalCDF' => GetPayrollRepository::getTotalPayrollByDateCDF($this->date_filter),
        ]);
    }
}
