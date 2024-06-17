<?php

namespace App\Livewire\Application\Finance\Cashbox\Forms;

use App\Models\CategorySpendMoney;
use App\Models\Currency;
use App\Models\Hospital;
use App\Models\Payroll;
use App\Models\PayrollSource;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Rule;
use Livewire\Component;

class NewPayRollView extends Component
{
    protected $listeners = [
        'payRoll' => 'getPayroll',
    ];
    public ?Payroll $payroll = null;
    public $currency_id = Currency::DEFAULT_ID_CURRENCY;
    #[Rule('required', message: 'Description obligatoire')]
    public $description;
    #[Rule('required', message: 'Cateorie obligatoire')]
    public $category_spend_money_id;

    #[Rule('required', message: 'Source obligatoire')]
    public $payroll_source_id;

    public function getPayroll(?Payroll $payroll)
    {
        $this->payroll = $payroll;
        $this->description = $payroll->description;
        $this->currency_id = $payroll->currency_id;
        $this->payroll_source_id = $payroll->payroll_source_id;
        $this->category_spend_money_id = $payroll->category_spend_money_id;
    }

    public function store()
    {
        $this->validate();
        try {
            Payroll::create([
                'number' => rand(1000, 10000),
                'description' => $this->description,
                'category_spend_money_id' => $this->category_spend_money_id,
                'hospital_id' => Hospital::DEFAULT_HOSPITAL(),
                'currency_id' => $this->currency_id,
                'payroll_source_id' => $this->payroll_source_id,
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
            $this->payroll->update([
                'description' => $this->description,
                'category_spend_money_id' => $this->category_spend_money_id,
                'payroll_source_id' => $this->payroll_source_id,
                'currency_id' => $this->currency_id,
            ]);
            $this->dispatch('added', ['message' => 'Action bien réalisée']);
            $this->dispatch('close-form-pay-roll');
            $this->description=null;
            $this->category_spend_money_id=null;
            $this->currency_id = Currency::DEFAULT_ID_CURRENCY;
        } catch (\Exception $ex) {
            $this->dispatch('error', ['message' => $ex->getMessage()]);
        }
    }

    public function handlerSubmit()
    {
        if ($this->payroll == null) {
            $this->store();
        } else {
            $this->update();
        }
        $this->payroll=null;
        $this->dispatch('refreshdPayroll');
    }
    public function render()
    {
        return view('livewire.application.finance.cashbox.forms.new-pay-roll-view', [
            'categories' => CategorySpendMoney::all(),
            'payrollSources'=>PayrollSource::all()
        ]);
    }
}
