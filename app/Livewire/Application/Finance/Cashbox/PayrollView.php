<?php

namespace App\Livewire\Application\Finance\Cashbox;

use App\Models\Payroll;
use Livewire\Component;

class PayrollView extends Component
{

    protected $listeners = [
        'refreshdPayroll' => '$refresh',
    ];
    public ?Payroll $payroll = null;
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
            } else {
                $this->dispatch('error', ['message' => "L'état de paie contient des données"]);
            }
        } catch (\Exception $ex) {
            $this->dispatch('error', ['message' => $ex->getMessage()]);
        }
    }

    public function render()
    {
        return view('livewire.application.finance.cashbox.payroll-view', [
            'payRolls' => Payroll::query()->get()
        ]);
    }
}
