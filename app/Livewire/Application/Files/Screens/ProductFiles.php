<?php

namespace App\Livewire\Application\Files\Screens;

use App\Imports\ProductCategoryImport;
use App\Imports\ProductImport;
use Exception;
use Livewire\Attributes\Rule;
use Livewire\Component;
use Livewire\Features\SupportFileUploads\WithFileUploads;
use Maatwebsite\Excel\Facades\Excel;

class ProductFiles extends Component
{
    use WithFileUploads;

    #[Rule('required', message: 'Veuillez selectionner un SVP', onUpdate: false)]
    #[Rule('mimes:xlsx',message:'LE fichier doit être au format Excel (.xlsx)')] // 1
    public $file;

    public function importFile(){
        $this->validate();
        try {
            Excel::import(new ProductImport,$this->file);
            $this->dispatch('added', ['message' => 'Action bien réalisée']);
        } catch (Exception $ex) {
            $this->dispatch('error', ['message' => $ex->getMessage()]);
        }
    }

    public function render()
    {
        return view('livewire.application.files.screens.product-files');
    }
}
