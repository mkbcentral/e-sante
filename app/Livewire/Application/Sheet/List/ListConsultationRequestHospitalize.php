<?php

namespace App\Livewire\Application\Sheet\List;

use App\Models\ConsultationRequest;
use App\Models\Currency;
use App\Repositories\Product\Get\GetConsultationRequestProductAmountRepository;
use App\Repositories\Sheet\Get\GetConsultationRequestionAmountRepository;
use App\Repositories\Sheet\Get\GetConsultationRequestRepository;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

class ListConsultationRequestHospitalize extends Component
{
    use WithPagination;
    protected $listeners = [
        'selectedIndex' => 'getSelectedIndex',
        'listHospitalizeRefreshed' => '$refresh',
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
     * Get Consultation Sheet if listener emitted in parent veiew
     * @param int $selectedIndex
     * @return void
     */
    public function getSelectedIndex(int $selectedIndex): void
    {
        $this->selectedIndex = $selectedIndex;
        $this->resetPage();
    }

    public function addToBordereau(?ConsultationRequest $consultationRequest)
    {
        $consultationRequest->paid_at = Carbon::now();
        $consultationRequest->is_paid = true;
        $consultationRequest->currency_id = Currency::DEFAULT_ID_CURRENCY;
        $consultationRequest->perceived_by = Auth::id();
        $consultationRequest->update();
    }
    /**
     * Delete from Bordereau
     * @param ConsultationRequest|null $consultationRequest
     * @return void
     */
    public function deleteToBordereau(?ConsultationRequest $consultationRequest)
    {
        $consultationRequest->paid_at = null;
        $consultationRequest->currency_id = null;
        $consultationRequest->perceived_by = 0;
        $consultationRequest->is_paid = false;
        if ($consultationRequest->consultationRequestCurrency != null) {
            $consultationRequest->consultationRequestCurrency->delete();
        }
        $consultationRequest->update();
    }

    /**
     * Open edit consultation currency modal
     * @param ConsultationRequest|null $consultationRequest
     * @return void
     */
    public function showEditCurrency(?ConsultationRequest $consultationRequest)
    {
        $this->dispatch('open-edit-consultation-request-currency');
        $this->dispatch('currencyConsultationRequest', $consultationRequest);
    }
    /**
     * Open edit consultation currency modal
     * @param ConsultationRequest|null $consultationRequest
     * @return void
     */


    public function openCautionModal(ConsultationRequest $consultationRequest)
    {
        $this->dispatch('consultationRequestionCaution', $consultationRequest);
        $this->dispatch('open-form-caution');
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
    public function render()
    {
        return view('livewire.application.sheet.list.list-consultation-request-hospitalize', [
            'listConsultationRequest' =>
            GetConsultationRequestRepository::getConsultationRequestHospitalized(
                $this->selectedIndex,
                $this->q,
                $this->sortBy,
                $this->sortAsc,
                20,
                $this->month_name,
                $this->year,
            ),
            'total_cdf' => GetConsultationRequestionAmountRepository::getTotalHospitalize($this->month_name, $this->year, $this->selectedIndex, 'CDF'),
            'total_usd' => GetConsultationRequestionAmountRepository::getTotalHospitalize($this->month_name, $this->year, $this->selectedIndex, 'USD'),
            'total_product_amount_cdf' => GetConsultationRequestProductAmountRepository::getProductAmountHospitalize($this->month_name, $this->year, $this->selectedIndex, 'CDF'),
            'total_product_amount_usd' => GetConsultationRequestProductAmountRepository::getProductAmountHospitalize($this->month_name, $this->year, $this->selectedIndex, 'USD')
        ]);
    }
}
