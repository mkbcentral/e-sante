<?php

namespace App\Livewire\Application\Sheet\Widget;

use App\Models\ConsultationRequest;
use Livewire\Component;

class ConsultationRequestNursingWidget extends Component
{
    public ?ConsultationRequest $consultationRequest;
    public string $currency;

    public function mount(ConsultationRequest $consultationRequest,string $currency)
    {
        $this->consultationRequest = $consultationRequest;
        $this->currency=$currency;
    }
    public function render()
    {
        return view('livewire.application.sheet.widget.consultation-request-nursing-widget');
    }
}
