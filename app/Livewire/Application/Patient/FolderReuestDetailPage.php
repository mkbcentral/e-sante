<?php

namespace App\Livewire\Application\Patient;

use Livewire\Component;
use App\Models\ConsultationSheet;

class FolderReuestDetailPage extends Component
{
    public int $sheetId;
    public string $month;
    public ?ConsultationSheet $consultationSheet;

    /**
     * Mounted Folder Patient component
     * @return void
     */
    public function mount(): void
    {
        $this->consultationSheet = ConsultationSheet::find($this->sheetId);
    }

    public function render()
    {
        return view('livewire.application.patient.folder-reuest-detail-page');
    }
}
