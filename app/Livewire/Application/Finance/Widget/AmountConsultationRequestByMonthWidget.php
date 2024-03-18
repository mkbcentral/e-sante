<?php

namespace App\Livewire\Application\Finance\Widget;

use App\Repositories\Product\Get\GetConsultationRequestProductAmountRepository;
use App\Repositories\Sheet\Get\GetConsultationRequestionAmountRepository;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class AmountConsultationRequestByMonthWidget extends Component
{
    protected $listeners = [
        'monthSelected' => 'getMonth',
        'selectedIndex' => 'getSelectedIndex',
        'isByDate' => 'getIsDate',
        'isByMonth' => 'getIsMonth',
        'isByPeriod' => 'getIsPeriod',
    ];
    public int $selectedIndex;
    public string $month_name = '';
    public string $date_filter = '';
    public $isByDate = true, $isByMonth = false, $isByPeriod = false;
    public string $start_date = '';
    public string $end_date = '';
    public string $year = '';

    /**
     * Get Month
     * @param string $month
     * @return void
     */
    public function getMonth($month)
    {
        $this->month_name = $month;
        $this->isByDate=false;
        $this->isByPeriod = false;
    }
    /**
     * Get Is Date
     * @param bool $isByDate
     * @return void
     */
    public function getIsDate($isByDate)
    {
        $this->isByDate = $isByDate;
        $this->isByMonth = false;
        $this->isByPeriod = false;
    }
    /**
     * Get Is Month
     * @param bool $isByMonth
     * @return void
     */
    public function getIsMonth($isByMonth)
    {
        $this->isByMonth = $isByMonth;
        $this->isByDate = false;
        $this->isByMonth = false;
    }
    /**
     * Get Is Period
     * @param bool $isByPeriod
     * @return void
     */
    public function getIsPeriod($isByPeriod)
    {
        $this->isByPeriod = $isByPeriod;
    }
    /**
     * Get Selected Index
     * @param int $selectedIndex
     * @return void
     */
    public function getSelectedIndex($selectedIndex)
    {
        $this->selectedIndex = $selectedIndex;
    }
    /**
     * Mount
     * @param int $selectedIndex
     * @param bool $isByDate
     * @param bool $isByMonth
     * @param bool $isByPeriod
     * @return void
     */
    public function mount(int $selectedIndex, bool $isByDate, bool $isByMonth, bool $isByPeriod)
    {
        $this->selectedIndex = $selectedIndex;
        $this->month_name = date('m');
        $this->date_filter = date('Y-m-d');
        $this->year = date('Y');
        $this->isByDate = $isByDate;
        $this->isByMonth = $isByMonth;
        $this->isByPeriod = $isByPeriod;
    }
    public function render()
    {
        $total_product_amount_cdf = 0;
        $total_product_amount_usd = 0;
        $total_cdf = 0;
        $total_usd = 0;
        if (
            Auth::user()->roles->pluck('name')->contains('Ag') ||
            Auth::user()->roles->pluck('name')->contains('Admin')
        ) {
            if ($this->isByDate==true) {
                $total_cdf = GetConsultationRequestionAmountRepository::getTotalByDateCDF($this->date_filter, $this->selectedIndex);
                $total_usd = GetConsultationRequestionAmountRepository::getTotalByDateUSD($this->date_filter, $this->selectedIndex);
            } elseif ($this->isByPeriod==true) {
                $total_cdf= GetConsultationRequestionAmountRepository::getTotalPeriodCDF($this->start_date, $this->end_date, $this->selectedIndex);
                $total_usd = GetConsultationRequestionAmountRepository::getTotalPeriodUSD($this->start_date, $this->end_date, $this->selectedIndex);
            } else {
                $total_cdf = GetConsultationRequestionAmountRepository::getTotalByMonthAllSourceCDF($this->month_name, $this->year, $this->selectedIndex);
                $total_usd = GetConsultationRequestionAmountRepository::getTotalByMonthAllSourceUSD($this->month_name, $this->year, $this->selectedIndex);
            }
        } elseif (Auth::user()->roles->pluck('name')->contains('Pharma')) {
            if ($this->isByDate==true) {
                $total_product_amount_cdf = GetConsultationRequestProductAmountRepository::getProductAmountByDay($this->date_filter, $this->selectedIndex, 'CDF');
                $total_product_amount_usd = GetConsultationRequestProductAmountRepository::getProductAmountByDay($this->date_filter, $this->selectedIndex, 'USD');
            } elseif ($this->isByPeriod==true) {
                $total_product_amount_cdf = GetConsultationRequestProductAmountRepository::getProductAmountByPeriod($this->start_date, $this->end_date, $this->selectedIndex, 'CDF');
                $total_product_amount_usd =
                GetConsultationRequestProductAmountRepository::getProductAmountByPeriod($this->start_date, $this->end_date, $this->selectedIndex, 'USD');
            } else {
                $total_product_amount_cdf = GetConsultationRequestProductAmountRepository::getProductAmountByMonth($this->month_name, $this->year, $this->selectedIndex, 'CDF');
                $total_product_amount_usd = GetConsultationRequestProductAmountRepository::getProductAmountByMonth($this->month_name, $this->year, $this->selectedIndex, 'USD');
            }
        }else{
            if ($this->isByDate == true) {
                $total_cdf = GetConsultationRequestionAmountRepository::getTotalByDateCDF($this->date_filter, $this->selectedIndex);
                $total_usd = GetConsultationRequestionAmountRepository::getTotalByDateCDF($this->date_filter, $this->selectedIndex);
            } elseif ($this->isByPeriod == true) {
                $total_cdf = GetConsultationRequestionAmountRepository::getTotalPeriodCDF($this->start_date, $this->end_date, $this->selectedIndex);
                $total_usd = GetConsultationRequestionAmountRepository::getTotalPeriodUSD($this->start_date, $this->end_date, $this->selectedIndex);
            } else {
                $total_cdf = GetConsultationRequestionAmountRepository::getTotalByMonthCDF($this->month_name, $this->year, $this->selectedIndex);
                $total_usd = GetConsultationRequestionAmountRepository::getTotalByMonthUSD($this->month_name, $this->year, $this->selectedIndex);
            }
        }

        return view('livewire.application.finance.widget.amount-consultation-request-by-month-widget', [
            'total_cdf' => $total_cdf,
            'total_usd' => $total_usd,
            'total_product_amount_cdf' => $total_product_amount_cdf,
            'total_product_amount_usd' => $total_product_amount_usd,
        ]);
    }
}
