<?php

namespace App\Livewire\Application\Finance\Billing\List;

use App\Enums\RoleType;
use App\Models\Source;
use App\Repositories\Sheet\Get\GetConsultationRequestRepository;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;

class HospitalizationPrivateRepport extends Component
{
    use WithPagination;
    protected $listeners = [
        'currencyName' => 'getCurrencyName',
        'dateSelected' => 'getDate',
        'monthSelected' => 'getMonth',
        'yearSelected' => 'getYear',
    ];
    public string $month, $date, $date_versement, $year;
    public bool $isByDate = true;

    public function getDate($date)
    {
        $this->date = $date;
        $this->isByDate = true;
    }
    public function getMonth($month)
    {
        $this->month = $month;
        $this->isByDate = false;
    }
    public function getYear($year)
    {
        $this->year = $year;
    }
    public function mount($date, $month, $year): void
    {
        $this->date = $date;
        $this->month = $month;
        $this->year = $year;
    }
    public function render()
    {
        return view('livewire.application.finance.billing.list.hospitalization-private-repport', [
            'listHospitalize' => $this->isByDate == true ?
                GetConsultationRequestRepository::getConsultationRequestHospitalizedToBordereau(
                    1,
                    null,
                    $this->date,
                    null
                ) :
                GetConsultationRequestRepository::getConsultationRequestHospitalizedToBordereauMonth(
                    1,
                    $this->month,
                    $this->year,
                    null,
                    null
                ),
            'total_usd' => $this->isByDate == true ?
                GetConsultationRequestRepository::getRequestHospitalizedToBordereauDateAmount(
                    1,
                    $this->date,
                    $this->year,
                    'USD',
                    Auth::user()->roles->pluck('name')->contains(RoleType::ADMIN) ? null : Source::DEFAULT_SOURCE(),
                    Auth::user()->roles->pluck('name')->contains(RoleType::ADMIN) ? null : Auth::id(),
                ) :
                GetConsultationRequestRepository::getRequestHospitalizedToBordereauMonthAmount(
                    1,
                    $this->month,
                    $this->year,
                    'USD',
                    null,
                    null
                ),
            'total_cdf' => $this->isByDate == true ?
                GetConsultationRequestRepository::getRequestHospitalizedToBordereauDateAmount(
                    1,
                    $this->date,
                    $this->year,
                    'CDF',
                    Auth::user()->roles->pluck('name')->contains(RoleType::ADMIN) ? null : Source::DEFAULT_SOURCE(),
                    Auth::user()->roles->pluck('name')->contains(RoleType::ADMIN) ? null : Auth::id(),
                ) :
                GetConsultationRequestRepository::getRequestHospitalizedToBordereauMonthAmount(
                    1,
                    $this->month,
                    $this->year,
                    'CDF',
                    null,
                    null
                )
        ]);
    }
}
