<?php

namespace App\Livewire\Application\Patient;

use Livewire\Component;
use App\Models\ConsultationSheet;
use Illuminate\Contracts\View\View;
use Illuminate\Contracts\View\Factory;
use App\Livewire\Helpers\Date\DateFormatHelper;
use Illuminate\Contracts\Foundation\Application;

class FolderPatient extends Component
{
    public int $sheetId;
    public ?ConsultationSheet $consultationSheet;

    /**
     * Mounted Folder Patient component
     * @return void
     */
    public function mount(): void
    {
       $this->consultationSheet=ConsultationSheet::find($this->sheetId);
    }

    /**
     * Render view Folder Patient view
     * @return Application|Factory|View|\Illuminate\Foundation\Application
     */
    public function render()
    {
        return view('livewire.application.patient.folder-patient',[
            'months'=>DateFormatHelper::getFrMonths()
        ]);
    }
}
