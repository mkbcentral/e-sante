<?php

namespace App\Livewire\Application\Sheet\List;

use App\Models\ConsultationRequest;
use App\Models\Currency;
use App\Models\Hospital;
use App\Repositories\Product\Get\GetConsultationRequestProductAmountRepository;
use App\Repositories\Sheet\Get\GetConsultationRequestionAmountRepository;
use App\Repositories\Sheet\Get\GetConsultationRequestRepository;
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
    public $sortBy = 'name';
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
        $this->dispatch('consultationRequestItems', $consultationRequest);
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
            $data
                = ConsultationRequest::join(
                    'consultation_sheets',
                    'consultation_sheets.id',
                    'consultation_requests.consultation_sheet_id'
                )
                ->where('consultation_sheets.subscription_id', $this->selectedIndex)
                ->select('consultation_requests.*')
                ->with(['consultationSheet.subscription'])
                ->where('consultation_sheets.hospital_id', Hospital::DEFAULT_HOSPITAL())
                ->whereMonth('consultation_requests.created_at', $this->month_name)
                ->whereYear('consultation_requests.created_at', $this->year)
                ->orderBy('consultation_requests.id', 'ASC')
                ->get();
            foreach ($data as $index => $item) {
                $consultationRequest = ConsultationRequest::find($item->id);
                $consultationRequest->request_number = $index + 1;
                $consultationRequest->update();
            }
            $this->dispatch('added', ['message' => 'Action bien réalisée']);
        } catch (\Exception $ex) {
            $this->dispatch('error', ['message' => $ex->getMessage()]);
        }
    }
    public function delete(ConsultationRequest $consultationRequest){
       try {
            $consultationRequest->delete();
            $this->dispatch('added', ['message' => 'Action bien réalisée']);
       } catch (\Exception $ex) {
            $this->dispatch('error', ['message' => $ex->getMessage()]);
        }

    }
    public function render()
    {
        if (
            Auth::user()->roles->pluck('name')->contains('Ag') ||
            Auth::user()->roles->pluck('name')->contains('Admin')
        ) {
            $listConsultationRequest = GetConsultationRequestRepository::getConsultationRequestByDateMonthAllSource(
                $this->selectedIndex,
                $this->q,
                $this->sortBy,
                $this->sortAsc,
                20,
                $this->month_name,
                $this->year,
            );
            $request_number= GetConsultationRequestRepository::getCountConsultationRequestByMonthAllSource(
                $this->selectedIndex,
                $this->month_name,
                $this->year,
            );
            $total_cd= GetConsultationRequestionAmountRepository::getTotalByMonthAllSourceCDF($this->month_name, $this->year, $this->selectedIndex);
            $total_usd= GetConsultationRequestionAmountRepository::getTotalByMonthAllSourceUSD($this->month_name, $this->year, $this->selectedIndex);
        } else {
            $listConsultationRequest = GetConsultationRequestRepository::getConsultationRequestByDateMonth(
                $this->selectedIndex,
                $this->q,
                $this->sortBy,
                $this->sortAsc,
                20,
                $this->month_name,
                $this->year,
                Auth::user()->id
            );
            $request_number= GetConsultationRequestRepository::getCountConsultationRequestByMonth(
                $this->selectedIndex,
                $this->month_name,
                $this->year,
                Auth::user()->id
            );
            $total_cd= GetConsultationRequestionAmountRepository::getTotalByMonthCDF($this->month_name, $this->year, $this->selectedIndex);
            $total_usd= GetConsultationRequestionAmountRepository::getTotalByMonthUSD($this->month_name, $this->year, $this->selectedIndex);
        }

        return view('livewire.application.sheet.list.list-consultation-request-by-month', [
            'listConsultationRequest' => $listConsultationRequest,
            'total_cdf' => $total_cd,
            'total_usd' => $total_usd,
            'total_product_amount_cdf' => GetConsultationRequestProductAmountRepository::getProductAmountByMonth($this->month_name, $this->year, $this->selectedIndex, 'CDF'),
            'total_product_amount_usd' => GetConsultationRequestProductAmountRepository::getProductAmountByMonth($this->month_name, $this->year, $this->selectedIndex, 'USD'),
            'request_number' => $request_number,
        ]);
    }
}
