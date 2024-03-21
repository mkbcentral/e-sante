<?php

namespace App\Livewire\Application\Finance\Cashbox\List;

use App\Models\Payroll;
use App\Models\PayrollItem;
use Livewire\Component;

class ListPayrollItemsView extends Component
{
    protected $listeners = [
        'payRollItems' => 'getPayroll',
        'refreshdListPayrollItems' => '$refresh'
    ];
    public Payroll $payroll;
    public function getPayroll(?Payroll $payroll)
    {
        $this->payroll = $payroll;
    }
    public function edit(?PayrollItem $payrollItem)
    {
        $this->dispatch('payRollItem', $payrollItem);
    }

    public function delete(?PayrollItem $payrollItem)
    {
        try {
            $payrollItem->delete();
            $this->dispatch('added', ['message' => 'Action bien réalisée']);
            $this->dispatch('refreshdPayroll');
        } catch (\Exception $ex) {
            $this->dispatch('error', ['message' => $ex->getMessage()]);
        }
    }

    public function render()
    {
        return view('livewire.application.finance.cashbox.list.list-payroll-items-view');
    }
}
