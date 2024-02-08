<?php

namespace App\Livewire\Application\Files\Screens;

use App\Imports\TarifImport;
use Exception;
use Livewire\Attributes\Rule;
use Livewire\Component;
use Livewire\Features\SupportFileUploads\WithFileUploads;
use Maatwebsite\Excel\Facades\Excel;

class ImportTarifView extends Component
{

    use WithFileUploads;
    #[Rule('required', message: 'champs société obligatoire')]
    public $category_id;

    #[Rule('required', message: 'Veuillez selectionner un fichier SVP')]
    #[Rule('mimes:xlsx', message: 'LE fichier doit être au format Excel (.xlsx)')] // 1
    public $file_tarif;

    public function importTarif(){
        $this->validate();
        try {
            Excel::import(new TarifImport($this->category_id), $this->file_tarif);
            $this->dispatch('added', ['message' => 'Action bien réalisée']);
        } catch (Exception $ex) {
            $this->dispatch('error', ['message' => $ex->getMessage()]);
        }
    }
    public function render()
    {
        return view('livewire.application.files.screens.import-tarif-view');
    }
}
