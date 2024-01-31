<?php

namespace App\Livewire\Application\Files\Screens;

use App\Imports\ConsultationSheetPrivateImport;
use Exception;
use Livewire\Attributes\Rule;
use Livewire\Component;
use Livewire\Features\SupportFileUploads\WithFileUploads;
use Maatwebsite\Excel\Facades\Excel;

class ImportPrivateSheetView extends Component
{
    use WithFileUploads;

    #[Rule('required', message: 'Veuillez selectionner un fichier SVP', onUpdate: false)]
    #[Rule('mimes:xlsx', message: 'LE fichier doit être au format Excel (.xlsx)')] // 1
    public $file;
    public function importPrivateSheets()
    {
        $this->validate();
        try {
            Excel::import(new ConsultationSheetPrivateImport, $this->file);
            $this->dispatch('added', ['message' => 'Action bien réalisée']);
        } catch (Exception $ex) {
            $this->dispatch('error', ['message' => $ex->getMessage()]);
        }
    }

    public function render()
    {
        return view('livewire.application.files.screens.import-private-sheet-view');
    }
}
