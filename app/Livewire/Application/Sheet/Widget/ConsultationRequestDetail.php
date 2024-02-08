<?php

namespace App\Livewire\Application\Sheet\Widget;

use App\Models\CategoryTarif;
use App\Models\ConsultationRequest;
use App\Models\Currency;
use App\Models\Hospital;
use App\Models\Tarif;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Livewire\Component;

class ConsultationRequestDetail extends Component
{

    protected $listeners = [
        'consultationRequest' => 'getConsultation',
        'currencyName' => 'getCurrencyName',
        'refreshDetail' => '$refresh'
    ];
    public ?ConsultationRequest $consultationRequest;
    public ?Tarif $tarif;

    public string $currencyName = Currency::DEFAULT_CURRENCY;

    public function getCurrencyName(string $currency)
    {
        $this->currencyName = $currency;

    }

    /**
     * Get Consultation Sheet if listener emitted in parent view
     * @param ConsultationRequest $consultationRequest
     * @return void
     */
    public function getConsultation(ConsultationRequest $consultationRequest): void
    {
        $this->consultationRequest = $consultationRequest;
    }
    /**
     * Render component
     * @return Application|Factory|View|\Illuminate\Foundation\Application
     */
    public function render()
    {
        return view('livewire.application.sheet.widget.consultation-request-detail',[
                'categoriesTarif' => CategoryTarif::where('hospital_id', Hospital::DEFAULT_HOSPITAL())->get()
            ]
        );
    }
}
