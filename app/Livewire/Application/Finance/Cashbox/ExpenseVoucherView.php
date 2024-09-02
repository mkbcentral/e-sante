<?php

namespace App\Livewire\Application\Finance\Cashbox;

use App\Models\ExpenseVoucher;
use App\Repositories\Expense\GetExpenseVoucherRepository;
use Livewire\Component;

class ExpenseVoucherView extends Component
{
    protected $listeners = [
        'refreshdExepenseVoucherList' => '$refresh',
    ];
    public ?ExpenseVoucher $payroll = null;
    public ?string  $date_filter=null;
    public ?string $month_filter='';
    public $source = 0, $category = 0, $currency_id = 0, $service_id=0;

    public function openAddModal()
    {
        $this->dispatch('open-form-expense-voucher');
    }

    public function edit(ExpenseVoucher $expenseVoucher):void{
        $this->dispatch('open-form-expense-voucher');
        $this->dispatch('expenseVoucher',$expenseVoucher);
    }

    public function validateExpenseVoucher(ExpenseVoucher $expenseVoucher):void{
        try {
            if($expenseVoucher->is_valided==true){
                $expenseVoucher->is_valided = false;
            }else{
                $expenseVoucher->is_valided = true;
            }
            $expenseVoucher->update();
            $this->dispatch('added', ['message' => 'Action bien réalisée']);
        } catch (\Exception $ex) {
            $this->dispatch('error', ['message' => $ex->getMessage()]);
        }
    }

    public function delete(ExpenseVoucher $expenseVoucher): void
    {
        try {
            if ($expenseVoucher->is_valided == true) {
                $this->dispatch('error', ['message' => 'Action impossible, dépense déjà validée']);
            } else {
                $expenseVoucher->delete();
                $this->dispatch('added', ['message' => 'Action bien réalisée']);
            }
        } catch (\Exception $ex) {
            $this->dispatch('error', ['message' => $ex->getMessage()]);
        }
    }

    public function updatedDateFilter($val){
        $this->month_filter='';
    }
    public function updatedMonthFilter($val){
        $this->date_filter=null;
    }

    public function mount()
    {
        $this->date_filter = date('Y-m-d');
    }

    public function render()
    {
        return view('livewire.application.finance.cashbox.expense-voucher-view',[
            'expenseVouchers'=>GetExpenseVoucherRepository::getList(
                $this->date_filter,
                $this->month_filter,
                $this->category,
                $this->service_id,
                $this->currency_id,
                10
            ),
            'total_usd'=>GetExpenseVoucherRepository::getAmountToatl(
                $this->date_filter,
                $this->month_filter,
                $this->category,
                $this->service_id,
                'USD',
            ),
            'total_cdf' => GetExpenseVoucherRepository::getAmountToatl(
                $this->date_filter,
                $this->month_filter,
                $this->category,
                $this->service_id,
                'CDF',
            )
        ]);
    }
}
