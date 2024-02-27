<?php

namespace App\Livewire\Application\Sheet\Form;

use App\Models\ConsultationRequest;
use App\Models\ConsultationRequestCurrency;
use App\Models\Currency;
use Livewire\Attributes\Rule;
use Livewire\Component;

class EditConsultationRequestCurrency extends Component
{
    protected $listeners = [
        'currencyConsultationRequest' => 'getConsultationRequest',
    ];
    public ?ConsultationRequest $consultationRequest = null;
    public $currency_id = null;
    #[Rule('required', message: 'Montant USD obligatoire')]
    #[Rule('numeric', message: 'Montant format invalide')]
    public $amount_usd;
    #[Rule('required', message: 'Montant CDF obligatoire')]
    #[Rule('numeric', message: 'Montant format invalide')]
    public $amount_cdf;

    public function updatedCurrencyId($val)
    {
        if ($this->currency_id != "") {
            $this->consultationRequest->currency_id = $val;
            if ($this->consultationRequest->consultationRequestCurrency) {
                $this->consultationRequest->consultationRequestCurrency->delete();
            }
            $this->dispatch('close-edit-consultation-currency');
            $this->amount_cdf='';
            $this->amount_usd = '';
        } else {
            $this->consultationRequest->currency_id = null;
        }
        $this->consultationRequest->update();
        $this->dispatch('added', ['message' => 'Action bien réalisée']);
    }


    public function getConsultationRequest(?ConsultationRequest $consultationRequest)
    {
        $this->consultationRequest = $consultationRequest;
        $this->currency_id = $consultationRequest->currency_id != null ? $consultationRequest->currency_id : "";
        if ($consultationRequest->consultationRequestCurrency) {
            $this->amount_cdf= $consultationRequest->consultationRequestCurrency->amount_cdf;
            $this->amount_usd = $consultationRequest->consultationRequestCurrency->amount_usd;
        }
    }

    public function save()
    {
        $this->validate();
        try {
            ConsultationRequestCurrency::create(
                [
                    'consultation_request_id' => $this->consultationRequest->id,
                    'amount_usd' => $this->amount_usd,
                    'amount_cdf' => $this->amount_cdf,
                ]
            );
            $this->dispatch('updated', ['message' => 'Action bien réalisée']);
        } catch (\Exception $ex) {
            $this->dispatch('error', ['message' => $ex->getMessage()]);
        }
        $this->dispatch('close-edit-consultation-currency');
    }

    public function render()
    {
        return view('livewire.application.sheet.form.edit-consultation-request-currency', [
            'currencies' => Currency::all()
        ]);
    }
}
