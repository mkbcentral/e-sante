<?php

namespace App\Livewire\Application\Finance\Cashbox\Forms;

use App\Models\Payroll;
use App\Models\PayrollItem;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Rule;
use Livewire\Component;

class NewPayRollItemView extends Component
{
    protected $listeners = [
        'payRollItem' => 'getPayrollItem',
    ];
    public ?PayrollItem $payrollItem = null;
    public ?Payroll $payroll;
    #[Rule('required', message: 'Service obligatoire')]
    #[Rule('numeric', message: 'Format numeric invalide')]
    public $agent_service_id;
    #[Rule('required', message: 'Nom obligatoire')]
    public $name;
    #[Rule('required', message: 'Cateorie obligatoire')]
    #[Rule('numeric', message: 'Format numeric invalide')]
    public $amount;

    public function getPayrollItem(?PayrollItem $payrollItem)
    {
        $this->payrollItem = $payrollItem;
        $this->name = $payrollItem->name;
        $this->amount = $payrollItem->amount;
        $this->agent_service_id = $payrollItem->agent_service_id;
    }

    public function store()
    {
        $this->validate();
        try {
            PayrollItem::create([
                'name' => $this->name,
                'amount' => $this->amount,
                'agent_service_id' => $this->agent_service_id,
                'payroll_id' => $this->payroll->id,
                'user_id' => Auth::id(),
            ]);
            $this->dispatch('added', ['message' => 'Action bien réalisée']);
            $this->dispatch('close-form-pay-roll');
        } catch (\Exception $ex) {
            $this->dispatch('error', ['message' => $ex->getMessage()]);
        }
    }

    public function update()
    {
        try {
            $this->payrollItem->update(
                [
                    'name' => $this->name,
                    'amount' => $this->amount,
                ]
            );
            $this->dispatch('added', ['message' => 'Action bien réalisée']);
            $this->dispatch('close-form-pay-roll');
            $this->name = null;
            $this->amount = null;
            $this->agent_service_id = null;
        } catch (\Exception $ex) {
            $this->dispatch('error', ['message' => $ex->getMessage()]);
        }
    }

    public function handlerSubmit()
    {
        if ($this->payrollItem == null) {
            $this->store();
        } else {
            $this->update();
        }
        $this->payrollItem = null;
        $this->dispatch('refreshdListPayrollItems');
        $this->dispatch('refreshdPayroll');
    }

    public function mount(?Payroll $payroll)
    {
        $this->payroll = $payroll;
    }

    public function render()
    {
        return view('livewire.application.finance.cashbox.forms.new-pay-roll-item-view');
    }
}
