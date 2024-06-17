<?php

namespace App\Livewire\Application\Finance\Cashbox;

use App\Exports\PayrollByDateExport;
use App\Models\Currency;
use App\Models\Payroll;
use App\Repositories\Payroll\GetPayrollRepository;
use DateTime;
use Livewire\Component;
use Maatwebsite\Excel\Facades\Excel;

class PayrollView extends Component
{

    protected $listeners = [
        'refreshdPayroll' => '$refresh',
    ];
    public ?Payroll $payroll = null;
    public  $date_filter;
    public $source = 0, $category = 0, $currency_id = 0;

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

    public function validatePayroll(Payroll $payroll)
    {
        try {
            $payroll->is_valided = false;
            $payroll->update();
            $this->dispatch('updated', ['message' => 'Action bien réalisée']);
        } catch (\Exception $ex) {
            $this->dispatch('error', ['message' => $ex->getMessage()]);
        }
    }

    public function exportToExcel()
    {
        try {
            $payrolls = GetPayrollRepository::getPayrollBydate($this->date_filter, $this->source, $this->category, $this->currency_id);
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
            return Excel::download(new PayrollByDateExport($data), 'depense_du_' .(new DateTime($this->date_filter))->format('d-m-Y') . '.xlsx');
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
            'payRolls' => GetPayrollRepository::getPayrollBydate($this->date_filter,$this->source, $this->category, $this->currency_id),
            'totalUSD' => GetPayrollRepository::getTotalPayrollByDate($this->date_filter, Currency::USD),
            'totalCDF' => GetPayrollRepository::getTotalPayrollByDate($this->date_filter, Currency::CDF),
        ]);
    }
}
