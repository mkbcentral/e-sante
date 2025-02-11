<?php

namespace App\Livewire\Application\Sheet\Form;

use App\Models\ConsultationSheet;
use App\Repositories\Sheet\Creation\CreateNewConsultationRequestRepository;
use Livewire\Attributes\Rule;
use Livewire\Component;

class NewConsultationRequest extends Component
{
    protected $listeners = ['consultationSheet' => 'getConsultationSheet'];
    public ?ConsultationSheet $consultationSheet;
    #[Rule('required', message: 'Type de consultation obligatoire')]
    public $consultation_id;
    public bool  $has_a_shipping_ticket = false;

    /**
     * This function get ConsultationSheet if listener is emitted
     * @param ConsultationSheet $consultationSheet
     * @return void
     */
    public function getConsultationSheet(ConsultationSheet $consultationSheet): void
    {
        $this->consultationSheet = $consultationSheet;
    }
    /**
     * Save New Consultation Request in DB
     * @return void
     */
    public function store(): void
    {
        $this->validate();
        try {
            $exist = CreateNewConsultationRequestRepository::checkExistingConsultationRequestInMonth(
                $this->consultationSheet->id
            );
            if ($exist) {
                $this->dispatch('error', ['message' => "Le patient" . $this->consultationSheet->name . " a déjà une consultation pour ce mois"]);
            } else {
                CreateNewConsultationRequestRepository::create([
                    'request_number' => CreateNewConsultationRequestRepository::generateConsultationRequetNumber($this->consultationSheet->subscription->id, date('m')),
                    'consultation_sheet_id' => $this->consultationSheet->id,
                    'consultation_id' => $this->consultation_id,
                    'has_a_shipping_ticket' => $this->has_a_shipping_ticket
                ]);
                $this->dispatch('added', ['message' => 'Action bien réalisée']);
            }
            $this->dispatch('close-request-form');
        } catch (\Exception $ex) {
            $this->dispatch('error', ['message' => $ex->getMessage()]);
        }
    }
    public function render()
    {
        return view('livewire.application.sheet.form.new-consultation-request');
    }
}
