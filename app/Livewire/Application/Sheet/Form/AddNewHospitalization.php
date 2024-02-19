<?php

namespace App\Livewire\Application\Sheet\Form;

use App\Models\ConsultationRequest;
use App\Models\ConsultationRequestHospitalization;
use App\Models\Hospital;
use App\Models\Source;
use Exception;
use Livewire\Attributes\Rule;
use Livewire\Component;

class AddNewHospitalization extends Component
{
    #[Rule('required', message: 'Champs chambre obligation', onUpdate: false)]
    public $hospitalization_room_id;
    #[Rule('numeric', message: 'Format numerique invalide', onUpdate: false)]
    public $number_of_day = 1;

    public string $formLabel = "CREATION";
    public ?ConsultationRequest $consultationRequest;
    public ?ConsultationRequestHospitalization $consultationRequestHospitalization = null;

    public function store()
    {
        $this->validate();
        try {
            ConsultationRequestHospitalization::create([
                'consultation_request_id' => $this->consultationRequest->id,
                'hospitalization_room_id' => $this->hospitalization_room_id,
                'number_of_day' => $this->number_of_day,
            ]);
            $this->dispatch('added', ['message' => 'Action bien réalisée']);
        } catch (Exception $ex) {
            $this->dispatch('error', ['message' => $ex->getMessage()]);
        }
    }

    public function edit(ConsultationRequestHospitalization $consultationRequestHospitalization)
    {
        $this->consultationRequestHospitalization = $consultationRequestHospitalization;
        $this->hospitalization_room_id = $consultationRequestHospitalization->hospitalization_room_id;
        $this->number_of_day = $consultationRequestHospitalization->number_of_day;
        $this->formLabel="EDITION";
    }

    public function update()
    {
        $fields = $this->validate();
        try {
            $this->consultationRequestHospitalization->update($fields);
            $this->hospitalization_room_id = '';
            $this->number_of_day = '';
            $this->consultationRequestHospitalization=null;
            $this->formLabel="CREATION";
            $this->dispatch('updated', ['message' => 'Action bien réalisée']);
        } catch (Exception $ex) {
            $this->dispatch('error', ['message' => $ex->getMessage()]);
        }
    }

    public function mount(?ConsultationRequest $consultationRequest)
    {
        $this->consultationRequest = $consultationRequest;
    }

    public function handlerSubmit()
    {
        if ($this->consultationRequestHospitalization == null) {
            $this->store();
        } else {
            $this->update();
        }
    }
    public function delete(ConsultationRequestHospitalization $consultationRequestHospitalization)
    {
        try {
            $consultationRequestHospitalization->delete();
            $this->dispatch('updated', ['message' => 'Action bien réalisé']);
        } catch (Exception $ex) {
            $this->dispatch('error', ['message' => $ex->getMessage()]);
        }
    }
    public function render()
    {
        return view('livewire.application.sheet.form.add-new-hospitalization', [
            'consultationRequestHospitalizations' => ConsultationRequestHospitalization::select('consultation_request_hospitalizations.*')
                ->join('consultation_requests', 'consultation_requests.id', 'consultation_request_hospitalizations.consultation_request_id')
                ->join('consultation_sheets', 'consultation_sheets.id', 'consultation_requests.consultation_sheet_id')
                ->where('consultation_sheets.hospital_id', Hospital::DEFAULT_HOSPITAL())
                ->where('consultation_sheets.source_id', Source::DEFAULT_SOURCE())
                ->where('consultation_request_hospitalizations.consultation_request_id', $this->consultationRequest->id)
                ->get()

        ]);
    }
}
