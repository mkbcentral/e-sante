<?php

namespace App\Livewire\Application\Sheet\List;

use App\Enums\RoleType;
use App\Models\ConsultationRequest;
use App\Models\Currency;
use App\Models\Source;
use App\Repositories\Sheet\Get\GetConsultationRequestRepository;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Contracts\View\View as ViewContract;
use Illuminate\Support\Facades\Auth;

class ListConsultationRequestByPeriod extends Component
{
    use WithPagination;
    protected $listeners = [
        'selectedIndex' => 'getSelectedIndex',
        'listSheetRefreshed' => '$refresh',
        'currencyName' => 'getCurrencyName',
    ];
    public int $selectedIndex;
    public string $start_date = '';
    public string $end_date = '';
    public string $currencyName = Currency::DEFAULT_CURRENCY;

    #[Url(as: 'q')]
    public string $q = '';
    #[Url(as: 'sortBy')]
    public $sortBy = 'consultation_requests.created_at';
    #[Url(as: 'sortAsc')]

    public function updatedStartDate($val)
    {
        $this->dispatch('startDateSelected', $val);
    }
    public function updatedEndDate($val)
    {
        $this->dispatch('endDateSelected', $val);
    }

    public $sortAsc = true;

    /**
     * getCurrencyName
     * Get currency name
     * @param  mixed $currency
     * @return void
     */
    public function getCurrencyName(string $currency): void
    {
        $this->currencyName = $currency;
    }
    /**
     * Open detail consultation model view
     * emit consultationRequest listner to load data after modal detail opened
     * @return void
     */
    public function openDetailConsultationModal(ConsultationRequest $consultationRequest): void
    {
        $this->dispatch('open-details-consultation');
        $this->dispatch('consultationRequest', $consultationRequest);
        $this->dispatch('consultationRequestItemsTarif', $consultationRequest);
        $this->dispatch('consultationRequestProductItems', $consultationRequest);
        $this->dispatch('consultationRequestNursingItems', $consultationRequest);
        $this->dispatch('consultationRequestHospitalizationItems', $consultationRequest);
    }

    /**
     * Get Consultation Sheet if listener emitted in parent veiew
     * @param int $selectedIndex
     * @return void
     */
    public function getSelectedIndex(int $selectedIndex): void
    {
        $this->selectedIndex = $selectedIndex;
        $this->resetPage();
    }

    public function openPrescriptionMedicalModal(ConsultationRequest $consultationRequest): void
    {
        $this->dispatch('open-medical-prescription');
        $this->dispatch('consultationRequest', $consultationRequest);
    }


    /**
     * Open vital sign modal
     * @param ConsultationRequest $consultationRequest
     * @return void
     */
    public  function openVitalSignForm(ConsultationRequest $consultationRequest): void
    {
        $this->dispatch('open-vital-sign-form');
        $this->dispatch('consultationRequest', $consultationRequest);
    }

    /**
     * Sort data (ASC or DESC)
     * @param $value
     * @return void
     */
    public function sortSheet($value): void
    {
        if ($value == $this->sortBy) {
            $this->sortAsc = !$this->sortAsc;
        }
        $this->sortBy = $value;
    }

    public function edit(?ConsultationRequest $consultationRequest)
    {
        $this->dispatch('selectedConsultationRequest', $consultationRequest);
        $this->dispatch('open-edit-consultation');
    }
    public  function mount(int $selectedIndex): void
    {
        $this->selectedIndex = $selectedIndex;
    }
    /**
     * @return ViewContract
     */
    public function render()
    {
        return view('livewire.application.sheet.list.list-consultation-request-by-period', [
            'listConsultationRequest' => GetConsultationRequestRepository::getConsultationRequestByPeriod(
                $this->selectedIndex,
                $this->q,
                $this->sortBy,
                $this->sortAsc,
                20,
                $this->start_date,
                $this->end_date,
                Auth::user()->roles->pluck('name')->contains(RoleType::ADMIN) ? null : Source::DEFAULT_SOURCE(),
                null
            ),
            'request_number' => GetConsultationRequestRepository::getCountConsultationRequestBetweenDate(
                $this->selectedIndex,
                Auth::user()->roles->pluck('name')->contains(RoleType::ADMIN) ? null : Source::DEFAULT_SOURCE(),
                $this->start_date,
                $this->end_date,
                true
            )
        ]);
    }
}
