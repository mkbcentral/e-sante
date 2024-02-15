<?php

namespace App\Livewire\Application\Sheet\Form;

use App\Models\ConsultationRequest;
use Livewire\Attributes\Rule;
use Livewire\Component;

class EditConsultationRequestInfo extends Component
{
    protected $listeners = [
        'selectedConsultationRequest' => 'getConsultationRequest',
    ];

    public ?ConsultationRequest $consultationRequest = null;
    #[Rule('required', message: 'Type de consultation obligatoire')]
    public $consultation_id;
    #[Rule('required', message: 'Numero obligatoire')]
    public $request_number;
    #[Rule('required', message: 'Date création obligatoire')]
    #[Rule('date', message: 'Formzt date invalide')]
    public $created_at;
    public bool  $has_a_shipping_ticket = false;

    public function getConsultationRequest(?ConsultationRequest $consultationRequest)
    {
        $this->consultationRequest = $consultationRequest;
        $this->consultation_id = $this->consultationRequest->consultation_id;
        $this->has_a_shipping_ticket = $this->consultationRequest->has_a_shipping_ticket;
        $this->request_number = $this->consultationRequest->request_number;
        $this->created_at = $this->consultationRequest->created_at->format('Y-m-d');
    }

    public function update()
    {
        $fields = $this->validate();
        try {
            $fields['has_a_shipping_ticket'] = $this->has_a_shipping_ticket;
            $this->consultationRequest->update($fields);
            $this->dispatch('listSheetRefreshed');
            $this->dispatch('close-open-edit-consultation');
            $this->dispatch('added', ['message' => 'Action bien réalisée']);
        } catch (\Exception $ex) {
            $this->dispatch('error', ['message' => $ex->getMessage()]);
        }
    }

    public function render()
    {
        return view('livewire.application.sheet.form.edit-consultation-request-info');
    }
}
