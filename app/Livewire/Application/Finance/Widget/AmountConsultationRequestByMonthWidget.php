<?php

namespace App\Livewire\Application\Finance\Widget;

use App\Enums\RoleType;
use App\Models\Currency;
use App\Models\Source;
use App\Repositories\Product\Get\GetConsultationRequestProductAmountRepository;
use App\Repositories\Sheet\Get\GetConsultationRequestionAmountRepository;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class AmountConsultationRequestByMonthWidget extends Component
{
    protected $listeners = [
        'monthSelected' => 'getMonth',
        'yearSelected' => 'getYear',
        'dateSelected' => 'getDate',
        'startDateSelected' => 'getStartDate',
        'endDateSelected' => 'getEndDate',
        'selectedIndex' => 'getSelectedIndex',
        'isByDate' => 'getIsDate',
        'isByMonth' => 'getIsMonth',
        'isByPeriod' => 'getIsPeriod',
        'refreshAmount' => '$refresh'
    ];
    public int $selectedIndex;
    public string $month_name = '';
    public string $date_filter = '';
    public $isByDate = true, $isByMonth = false, $isByPeriod = false;
    public string $start_date = '';
    public string $end_date = '';
    public string $year = '';

    public function getStartDate($val)
    {
        $this->start_date = $val;
        $this->isByPeriod = true;
        $this->isByDate = false;
        $this->isByMonth = false;
    }
    public function getEndDate($val)
    {
        $this->end_date = $val;
        $this->isByPeriod = true;
        $this->isByDate = false;
        $this->isByMonth = false;
    }

    public function getDate($date)
    {
        $this->date_filter = $date;
        $this->isByDate = true;
        $this->isByMonth = false;
        $this->isByPeriod = false;
    }

    public function getMonth($month)
    {
        $this->month_name = $month;
        $this->isByDate = false;
        $this->isByPeriod = false;
    }

    public function getYear($year)
    {
        $this->year = $year;
    }

    public function getIsDate($isByDate)
    {
        $this->isByDate = $isByDate;
        $this->isByMonth = false;
        $this->isByPeriod = false;
    }

    public function getIsMonth($isByMonth)
    {
        $this->isByMonth = $isByMonth;
        $this->isByDate = false;
        $this->isByPeriod = false;
    }
    public function getIsPeriod($isByPeriod)
    {
        $this->isByPeriod = $isByPeriod;
        $this->isByDate = false;
        $this->isByMonth = false;
    }
    public function getSelectedIndex($selectedIndex)
    {
        $this->selectedIndex = $selectedIndex;
    }
    public function mount(
        int $selectedIndex,
        bool $isByDate,
        bool $isByMonth,
        bool $isByPeriod
    ) {
        $this->selectedIndex = $selectedIndex;
        $this->isByDate = $isByDate;
        $this->isByMonth = $isByMonth;
        $this->isByPeriod = $isByPeriod;
        if ($this->isByDate == true) {
            $this->date_filter = date('Y-m-d');
        } else if ($this->isByMonth == true) {
            $this->month_name = date('m');
        }
        $this->year = date('Y');
    }
    public function render()
    {
        $total_cdf = 0;
        $total_usd = 0;
        if ($this->isByDate == true) {
            $total_cdf = GetConsultationRequestionAmountRepository::getTotalByDate(
                $this->selectedIndex,
                null,
                Auth::user()->roles->pluck('name')->contains(RoleType::ADMIN) ? null : Source::DEFAULT_SOURCE(),
                null,
                $this->date_filter,
                Currency::LABEL_CDF
            );
            $total_usd = GetConsultationRequestionAmountRepository::getTotalByDate(
                $this->selectedIndex,
                null,
                Auth::user()->roles->pluck('name')->contains(RoleType::ADMIN) ? null : Source::DEFAULT_SOURCE(),
                null,
                $this->date_filter,
                Currency::LABEL_USD
            );
        } else if ($this->isByMonth == true) {
            $total_cdf = GetConsultationRequestionAmountRepository::getTotalByMonth(
                $this->selectedIndex,
                null,
                Auth::user()->roles->pluck('name')->contains(RoleType::ADMIN) ? null : Source::DEFAULT_SOURCE(),
                null,
                $this->month_name,
                $this->year,
                Currency::LABEL_CDF
            );
            $total_usd = GetConsultationRequestionAmountRepository::getTotalByMonth(
                $this->selectedIndex,
                null,
                Auth::user()->roles->pluck('name')->contains(RoleType::ADMIN) ? null : Source::DEFAULT_SOURCE(),
                null,
                $this->month_name,
                $this->year,
                Currency::LABEL_USD
            );
        } else if ($this->isByPeriod == true) {
            $total_cdf = GetConsultationRequestionAmountRepository::getTotalPeriod(
                $this->selectedIndex,
                null,
                Auth::user()->roles->pluck('name')->contains(RoleType::ADMIN) ? null : Source::DEFAULT_SOURCE(),
                null,
                $this->start_date,
                $this->end_date,
                Currency::LABEL_CDF
            );
            $total_usd = GetConsultationRequestionAmountRepository::getTotalPeriod(
                $this->selectedIndex,
                null,
                Auth::user()->roles->pluck('name')->contains(RoleType::ADMIN) ? null : Source::DEFAULT_SOURCE(),
                null,
                $this->start_date,
                $this->end_date,
                Currency::LABEL_USD
            );
        }
        return view('livewire.application.finance.widget.amount-consultation-request-by-month-widget', [
            'total_cdf' => $total_cdf,
            'total_usd' => $total_usd,
        ]);
    }
}
