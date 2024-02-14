<?php

namespace App\Livewire\Application\Sheet\Form;

use App\Events\OutpatientBillEvent;
use App\Models\ConsultationSheet;
use App\Repositories\OutpatientBill\CreateOutpatientBillRepository;
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
            if (CreateNewConsultationRequestRepository::checkExistingConsultationRequestInMonth($this->consultationSheet->id) != null) {
                $this->dispatch('error', ['message' =>"Le patient".$this->consultationSheet->name." a déjà une consultation pour ce mois"]);
            } else {
                CreateNewConsultationRequestRepository::create([
                    'consultation_sheet_id' => $this->consultationSheet->id,
                    'consultation_id' => $this->consultation_id,
                    'has_a_shipping_ticket' => $this->has_a_shipping_ticket
                ]);
                if ($this->consultationSheet->subscription->is_private == true) {
                    $inpusoutpatientBill['client_name'] = $this->consultationSheet->name;
                    $inpusoutpatientBill['consultation_id'] = $this->consultation_id;
                    $inpusoutpatientBill['consultation_sheet_id'] = $this->consultationSheet->id;
                    $inpusoutpatientBill['currency_id'] = null;
                    $outpatientBill =  CreateOutpatientBillRepository::create($inpusoutpatientBill);
                    //event(new  OutpatientBillEvent($outpatientBill));
                    $this->dispatch('outpatientBillRefreshedMainView');
                }

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
