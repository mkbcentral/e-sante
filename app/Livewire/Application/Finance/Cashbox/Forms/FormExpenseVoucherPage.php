<?php

namespace App\Livewire\Application\Finance\Cashbox\Forms;

use App\Models\Currency;
use App\Models\ExpenseVoucher;
use App\Models\Hospital;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Rule;
use Livewire\Component;

class FormExpenseVoucherPage extends Component
{
    protected $listeners = [
        'expenseVoucher' => 'getExpenseVoucher',
    ];
    public ?ExpenseVoucher $expenseVoucher = null;
    public $currency_id = Currency::DEFAULT_ID_CURRENCY;
    #[Rule('required', message: 'Description obligatoire')]
    public $description;
    #[Rule('required', message: 'Cateorie obligatoire')]
    public $name;
    #[Rule('required', message: 'Nom obligatoire')]
    public $category_spend_money_id;

    #[Rule('required', message: 'Service obligatoire')]
    public $agent_service_id;
    #[Rule('required', message: 'Source obligatoire')]
    public $payroll_source_id;

    #[Rule('required', message: 'Montant obligatoire')]
    #[Rule('numeric', message: 'Format numeric invalide')]
    public $amount;

    public function getExpenseVoucher(?ExpenseVoucher $expenseVoucher)
    {
        $this->expenseVoucher = $expenseVoucher;
        $this->name = $expenseVoucher->name;
        $this->amount = $expenseVoucher->amount;
        $this->description = $expenseVoucher->description;
        $this->currency_id = $expenseVoucher->currency_id;
        $this->agent_service_id = $expenseVoucher->agent_service_id;
        $this->category_spend_money_id = $expenseVoucher->category_spend_money_id;
    }

    public function store()
    {
        $this->validate();
        try {
            ExpenseVoucher::create([
                'number' => rand(1000, 10000),
                'description' => $this->description,
                'name' => $this->name,
                'amount' => $this->amount,
                'category_spend_money_id' => $this->category_spend_money_id,
                'payroll_source_id ' => $this->payroll_source_id ,
                'hospital_id' => Hospital::DEFAULT_HOSPITAL(),
                'currency_id' => $this->currency_id,
                'agent_service_id' => $this->agent_service_id,
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
            $this->expenseVoucher->update(
                [
                    'description' => $this->description,
                    'name' => $this->name,
                    'amount' => $this->amount,
                    'category_spend_money_id' => $this->category_spend_money_id,
                    'payroll_source_id ' => $this->payroll_source_id,
                    'currency_id' => $this->currency_id,
                    'agent_service_id' => $this->agent_service_id,
                ]
            );
            $this->dispatch('added', ['message' => 'Action bien réalisée']);
            $this->dispatch('close-form-pay-roll');
            $this->description = null;
            $this->category_spend_money_id = null;
            $this->currency_id = Currency::DEFAULT_ID_CURRENCY;
        } catch (\Exception $ex) {
            $this->dispatch('error', ['message' => $ex->getMessage()]);
        }
    }

    public function handlerSubmit()
    {
        if ($this->expenseVoucher == null) {
            $this->store();
        } else {
            $this->update();
        }
        $this->expenseVoucher = null;
        $this->dispatch('refreshdExepenseVoucherList');
    }

    public function render()
    {
        return view('livewire.application.finance.cashbox.forms.form-expense-voucher-page');
    }
}
