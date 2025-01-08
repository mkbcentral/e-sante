<?php

namespace App\Livewire\Application\Sheet\List;

use App\Models\ConsultationRequest;
use App\Models\Currency;
use App\Repositories\Sheet\Get\GetConsultationRequestRepository;
use App\Repositories\Sheet\Get\ManageConsultationRequestRepository;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

class ListConsultationRequestByMonth extends Component
{
    use WithPagination;

    protected $listeners = [
        'selectedIndex' => 'getSelectedIndex',
        'listSheetRefreshed' => '$refresh',
        'currencyName' => 'getCurrencyName',
    ];
    public int $selectedIndex;
    public string $month_name = '';
    public string $year = '';
    public string $currencyName = Currency::DEFAULT_CURRENCY;

    #[Url(as: 'q')]
    public string $q = '';
    #[Url(as: 'sortBy')]
    public $sortBy = 'consultation_requests.created_at';
    #[Url(as: 'sortAsc')]
    public $sortAsc = true;
    public $isClosing = false;

    public function updatedMonthName($val)
    {
        $this->dispatch('monthSelected', $val);
    }

    public function updatedYear($val)
    {
        $this->dispatch('yearSelected', $val);
    }

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
        $this->dispatch('consultationRequestItemsTarif', $consultationRequest);
        $this->dispatch('consultationRequestProductItems', $consultationRequest);
        $this->dispatch('consultationRequestNursingItems', $consultationRequest);
        $this->dispatch('consultationRequestHospitalizationItems', $consultationRequest);
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
    public  function mount(int $selectedIndex): void
    {
        $this->selectedIndex = $selectedIndex;
        $this->month_name = date('m');
        $this->year = date('Y');
    }

    public function edit(?ConsultationRequest $consultationRequest)
    {
        $this->dispatch('selectedConsultationRequest', $consultationRequest);
        $this->dispatch('open-edit-consultation');
    }

    public function fixNumerotation()
    {
        try {
            ManageConsultationRequestRepository::fixNumerotation(
                $this->selectedIndex,
                $this->month_name,
                $this->year
            );
            $this->dispatch('added', ['message' => 'Action bien réalisée']);
        } catch (\Exception $ex) {
            $this->dispatch('error', ['message' => $ex->getMessage()]);
        }
    }

    /**
     * Close blling
     */
    public function closeBilling()
    {
        try {
            $this->isClosing = ManageConsultationRequestRepository::closeConsultationRequest(
                $this->selectedIndex,
                $this->month_name,
                $this->year
            );
            $this->dispatch('added', ['message' => 'Action bien réalisée']);
        } catch (\Exception $ex) {
            $this->dispatch('error', ['message' => $ex->getMessage()]);
        }
    }
    /**
     * Delele bill
     */
    public function delete(ConsultationRequest $consultationRequest)
    {
        try {
            ManageConsultationRequestRepository::deleteConsultationRequest($consultationRequest);
            $this->dispatch('added', ['message' => 'Action bien réalisée']);
        } catch (\Exception $ex) {
            $this->dispatch('error', ['message' => $ex->getMessage()]);
        }
    }
    /**
     * Fixing numerotation of billing
     */
    public function fixWithCurrentRate()
    {
        try {
            ManageConsultationRequestRepository::fixRate(
                $this->selectedIndex,
                $this->month_name,
                $this->year
            );
            $this->dispatch('added', ['message' => 'Action bien réalisée']);
        } catch (\Exception $ex) {
            $this->dispatch('error', ['message' => $ex->getMessage()]);
        }
    }
    /**
     * Check if bills are closing
     */
    public function checkIsClosin()
    {
        $consultationRequestPrinted
            = GetConsultationRequestRepository::getConsultationRequestChechkIfIsClosing(
                $this->selectedIndex,
                $this->month_name,
                $this->year
            );
        if ($consultationRequestPrinted != null) {
            $this->isClosing = true;
        } else {
            $this->isClosing = false;
        }
    }

    public function render()
    {
        $this->checkIsClosin();
        if (
            Auth::user()->roles->pluck('name')->contains('AG') ||
            Auth::user()->roles->pluck('name')->contains('ADMIN') ||
            Auth::user()->roles->pluck('name')->contains('LABO')
        ) {
            $listConsultationRequest = GetConsultationRequestRepository::getConsultationRequestByMonthAllSource(
                $this->selectedIndex,
                $this->q,
                $this->sortBy,
                $this->sortAsc,
                20,
                $this->month_name,
                $this->year,
            );
            $request_number = GetConsultationRequestRepository::getCountConsultationRequestByMonthAllSource(
                $this->selectedIndex,
                $this->month_name,
                $this->year,
            );
        } else {
            $listConsultationRequest = GetConsultationRequestRepository::getConsultationRequestByMonth(
                $this->selectedIndex,
                $this->q,
                $this->sortBy,
                $this->sortAsc,
                20,
                $this->month_name,
                $this->year,
                Auth::user()->id
            );
            $request_number = GetConsultationRequestRepository::getCountConsultationRequestByMonth(
                $this->selectedIndex,
                $this->month_name,
                $this->year,
                Auth::user()->id
            );
        }
        return view('livewire.application.sheet.list.list-consultation-request-by-month', [
            'listConsultationRequest' => $listConsultationRequest,
            'request_number' => $request_number,
        ]);
    }
}
