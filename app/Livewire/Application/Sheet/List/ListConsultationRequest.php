<?php

namespace App\Livewire\Application\Sheet\List;

use App\Enums\RoleType;
use App\Models\ConsultationRequest;
use App\Models\Currency;
use App\Models\Source;
use App\Repositories\Sheet\Get\GetConsultationRequestRepository;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

class ListConsultationRequest extends Component
{
    use WithPagination;
    protected $listeners = [
        'selectedIndex' => 'getSelectedIndex',
        'listSheetRefreshed' => '$refresh',
        'currencyName' => 'getCurrencyName',
    ];
    public int $selectedIndex;
    public string $date_filter = '';
    public string $year = '';
    public string $currencyName = Currency::DEFAULT_CURRENCY;

    #[Url(as: 'q')]
    public string $q = '';
    #[Url(as: 'sortBy')]
    public $sortBy = 'consultation_requests.created_at';
    #[Url(as: 'sortAsc')]
    public $sortAsc = true;

    public function updatedDateFilter($date)
    {
        $this->dispatch('dateSelected', $date);
    }

    public function getCurrencyName(string $currency): void
    {
        $this->currencyName = $currency;
    }

    public function openDetailConsultationModal(ConsultationRequest $consultationRequest): void
    {
        $this->dispatch('open-details-consultation');
        $this->dispatch('consultationRequest', $consultationRequest);
        $this->dispatch('consultationRequestItemsTarif', $consultationRequest);
        $this->dispatch('consultationRequestProductItems', $consultationRequest);
        $this->dispatch('consultationRequestNursingItems', $consultationRequest);
        $this->dispatch('consultationRequestHospitalizationItems', $consultationRequest);
    }

    public function openPrescriptionMedicalModal(ConsultationRequest $consultationRequest): void
    {

        $this->dispatch('open-medical-prescription');
        $this->dispatch('consultationRequest', $consultationRequest);
    }

    public function getSelectedIndex(int $selectedIndex): void
    {
        $this->selectedIndex = $selectedIndex;
        $this->resetPage();
    }

    public  function openVitalSignForm(ConsultationRequest $consultationRequest): void
    {
        $this->dispatch('open-vital-sign-form');
        $this->dispatch('consultationRequest', $consultationRequest);
    }
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
        $this->date_filter = date('Y-m-d');
        $this->year = date('Y');
    }

    /**
     * Render component
     * @return Application|Factory|View|\Illuminate\Foundation\Application
     */
    public function render()
    {
        return view('livewire.application.sheet.list.list-consultation-request', [
            'listConsultationRequest' => GetConsultationRequestRepository::getConsultationRequestByDate(
                $this->selectedIndex,
                $this->q,
                $this->sortBy,
                $this->sortAsc,
                20,
                Auth::user()->roles->pluck('name')->contains(RoleType::ADMIN) ? null : Source::DEFAULT_SOURCE(),
                null,
                $this->date_filter,
            ),
            'request_number' => GetConsultationRequestRepository::getCountConsultationRequestByDate(
                $this->selectedIndex,
                Auth::user()->roles->pluck('name')->contains(RoleType::ADMIN) ? null : Source::DEFAULT_SOURCE(),
                $this->date_filter,
                null
            )
        ]);
    }
}
