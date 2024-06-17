<?php

namespace App\Livewire\Application\Finance\Cashbox;

use App\Exports\PayrollByMonthExport;
use App\Models\Currency;
use App\Models\Payroll;
use App\Repositories\Payroll\GetPayrollRepository;
use Livewire\Component;
use Maatwebsite\Excel\Facades\Excel;

class PayrollByMonthView extends Component
{
    public  $month;
    public $source = 0, $category = 0, $currency_id = 0;

    public function addItems(?Payroll $payroll)
    {
        $this->dispatch('payRollItems', $payroll);
        $this->dispatch('open-list-pay-roll-items');
    }
    public function exportToExcel()
    {
        try {
            $payrolls = GetPayrollRepository::getPayrollByMonth($this->month, $this->source, $this->category, $this->currency_id);
            $data = collect([]);
            foreach ($payrolls as  $payroll) {
                $data->push([
                    $payroll->created_at->format('d/m/Y'),
                    $payroll->number,
                    $payroll->description,
                    $payroll->payrollSource->name ?? 'not',
                    $payroll->categorySpendMoney->name ?? 'not',
                    $payroll->currency->name == 'USD' ? app_format_number($payroll->getPayrollTotalAmount(), 0) : 0,
                    $payroll->currency->name == 'CDF' ? app_format_number($payroll->getPayrollTotalAmount(), 0) : 0,
                ]);
            }
            return Excel::download(new PayrollByMonthExport($data), 'depense_' . format_fr_month_name($this->month) . '_2024.xlsx');
        } catch (\Exception $ex) {
            $this->dispatch('error', ['message' => $ex->getMessage()]);
        }
    }

    public function mount()
    {
        $this->month = date('m');
    }

    public function render()
    {
        return view('livewire.application.finance.cashbox.payroll-by-month-view', [
            'payRolls' => GetPayrollRepository::getPayrollByMonth($this->month, $this->source, $this->category, $this->currency_id),
            'totalUSD' => GetPayrollRepository::getTotalPayrollByMonth($this->month, Currency::USD),
            'totalCDF' => GetPayrollRepository::getTotalPayrollByMonth($this->month, Currency::CDF),
        ]);
    }
}
