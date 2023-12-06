<?php

namespace App\Livewire\Application\Sheet\Widget;

use App\Models\Consultation;
use App\Models\ConsultationRequest;
use App\Models\Hospital;
use JetBrains\PhpStorm\NoReturn;
use Livewire\Component;

class ConsultationDetailWidget extends Component
{
    public ?ConsultationRequest $consultationRequest;
    public bool $isEditing = false;
    public int $idConsultation=0;
    #[NoReturn] public function updatedIdConsultation($val): void
    {
        try {
            $this->consultationRequest->consultation_id = $val;
            $this->consultationRequest->update();
            $this->isEditing = false;
            $this->dispatch('updated', ['message' => 'Action bien réalisée']);
        } catch (\Exception $exception) {
            $this->dispatch('error', ['message' => $exception->getMessage()]);
        }
    }

    public function edit(): void
    {
        $this->isEditing = true;
    }

    public function makeIsPaid(): void
    {
        try {
            if ($this->consultationRequest->is_consultation_paid) {
                $this->consultationRequest->is_consultation_paid = false;
            } else {
                $this->consultationRequest->is_consultation_paid = true;
            }
            $this->consultationRequest->update();
            $this->dispatch('updated', ['message' => 'Action bien réalisée']);
        } catch (\Exception $exception) {
            $this->dispatch('error', ['message' => $exception->getMessage()]);
        }
    }

    public function mount(?ConsultationRequest $consultationRequest): void
    {
        $this->consultationRequest = $consultationRequest;
        $this->isEditing = false;
    }

    public function render()
    {
        return view('livewire.application.sheet.widget.consultation-detail-widget', [
            'consultations' => Consultation::where('hospital_id', Hospital::DEFAULT_HOSPITAL)->get()
        ]);
    }
}
