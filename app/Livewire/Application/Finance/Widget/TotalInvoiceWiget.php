<?php

namespace App\Livewire\Application\Finance\Widget;

use App\Models\ConsultationRequest;
use App\Models\Currency;
use Livewire\Component;

class TotalInvoiceWiget extends Component
{
    protected $listeners = [
        'currencyName' => 'getCurrencyName',
        'refreshTotal' => '$refresh'
    ];
    public ?ConsultationRequest $consultationRequest;
    public string $currencyName = "";

    public function getCurrencyName(string $currency)
    {
        $this->currencyName = $currency;
    }

    public function mount(ConsultationRequest $consultationRequest)
    {
        $this->consultationRequest = $consultationRequest;
        $this->currencyName = Currency::DEFAULT_CURRENCY;
    }
    public function render()
    {
        return view('livewire.application.finance.widget.total-invoice-wiget');
    }
}
