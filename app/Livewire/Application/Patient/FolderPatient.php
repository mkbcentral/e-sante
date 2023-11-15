<?php

namespace App\Livewire\Application\Patient;

use App\Models\ConsultationSheet;
use Livewire\Component;

class FolderPatient extends Component
{
    public int $sheetId;
    public ?ConsultationSheet $consultationSheet;
    public function mount(){
       $this->consultationSheet=ConsultationSheet::find($this->sheetId);
    }
    public function render()
    {
        return view('livewire.application.patient.folder-patient');
    }
}
