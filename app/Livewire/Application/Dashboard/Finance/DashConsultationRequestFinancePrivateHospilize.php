<?php

namespace App\Livewire\Application\Dashboard\Finance;

use App\Enums\RoleType;
use App\Models\Source;
use App\Repositories\Sheet\Get\GetConsultationRequestionAmountRepository;
use App\Repositories\Sheet\Get\GetConsultationRequestRepository;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class DashConsultationRequestFinancePrivateHospilize extends Component
{
    public $date = '', $month, $year;

    protected $listeners = [
        'updatedDateData' => 'getDate',
        'updatedMonthData' => 'getMonth',
        'updatedYearData' => 'getYear',
    ];
    public function getDate(string $date)
    {
        $this->date = $date;
        $this->month = '';
    }
    public function getMonth($month)
    {
        $this->month = $month;
        $this->date = '';
    }
    public function getYear($year)
    {
        $this->year = $year;
    }

    public function mount(String $date, $month, $year)
    {
        $this->date = $date;
        $this->month = $month;
        $this->year = $year;
    }
    public function render()
    {
        return view('livewire.application.dashboard.finance.dash-consultation-request-finance-private-hospilize', [
            'tota_cdf' => $this->month == null ? GetConsultationRequestRepository::getRequestHospitalizedToBordereauDateAmount(
                1,
                $this->date,
                $this->year,
                'CDF',
                Auth::user()->roles->pluck('name')->contains(RoleType::ADMIN) ? null : Auth::id(),
                Auth::user()->roles->pluck('name')->contains(RoleType::ADMIN) ? null : Source::DEFAULT_SOURCE()
            ) :
                GetConsultationRequestRepository::getRequestHospitalizedToBordereauMonthAmount(
                    1,
                    $this->month,
                    $this->year,
                    'CDF',
                    Auth::user()->roles->pluck('name')->contains(RoleType::ADMIN) ? null : Auth::id(),
                    Auth::user()->roles->pluck('name')->contains(RoleType::ADMIN) ? null : Source::DEFAULT_SOURCE(),
                ),
            'tota_usd' => $this->month == null ? GetConsultationRequestRepository::getRequestHospitalizedToBordereauDateAmount(
                1,
                $this->date,
                $this->year,
                'USD',
                Auth::user()->roles->pluck('name')->contains(RoleType::ADMIN) ? null : Auth::id(),
                Auth::user()->roles->pluck('name')->contains(RoleType::ADMIN) ? null : Source::DEFAULT_SOURCE(),
            ) : GetConsultationRequestRepository::getRequestHospitalizedToBordereauMonthAmount(
                1,
                $this->month,
                $this->year,
                'USD',
                Auth::user()->roles->pluck('name')->contains(RoleType::ADMIN) ? null : Auth::id(),
                Auth::user()->roles->pluck('name')->contains(RoleType::ADMIN) ? null : Source::DEFAULT_SOURCE(),
            )

        ]);
    }
}
