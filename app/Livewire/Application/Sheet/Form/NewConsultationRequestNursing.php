<?php

namespace App\Livewire\Application\Sheet\Form;

use App\Models\ConsultationRequest;
use App\Models\ConsultationRequestNersing;
use App\Models\Currency;
use Livewire\Attributes\Rule;
use Livewire\Component;

class NewConsultationRequestNursing extends Component
{
    protected $listeners = ['consultationRequestNursing' => 'getconsultationRequest'];
    public ?ConsultationRequest $consultationRequest;

    #[Rule('required', message: 'Champs désignation obligation')]
    public $name='NURSING';
    #[Rule('required', message: 'Champs montant obligation')]
    #[Rule('numeric', message: 'Champs montant format numerique')]
    public $amount;
    #[Rule('required', message: 'Champs nombre obligation')]
    #[Rule('numeric', message: 'Champs nombre format numerique')]
    public $number=1;

    /**
     * This function get consultationRequest if listener is emitted
     * @param consultationRequest $consultationRequest
     * @return void
     */
    public function getconsultationRequest(ConsultationRequest $consultationRequest): void
    {
        $this->consultationRequest = $consultationRequest;
        if ($this->consultationRequest->consultationSheet->subscription->is_subscriber == true) {
            $this->amount = 10;
        } else {
            $this->amount = 7.5;
        }
    }

    public function store()
    {
        $fields=$this->validate();
        try {
            $fields['consultation_request_id'] = $this->consultationRequest->id;
            ConsultationRequestNersing::create($fields);
            $this->dispatch('updated', ['message' => 'Action bien réalisée']);
            $this->dispatch('close-form-consultation-request-nursing');
        } catch (\Exception $exception) {
            $this->dispatch('error', ['message' => $exception->getMessage()]);
        }
    }
    public function render()
    {
        return view('livewire.application.sheet.form.new-consultation-request-nursing', [
            'currencies' => Currency::all()
        ]);
    }
}
