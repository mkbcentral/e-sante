<?php

namespace App\Livewire\Application\Configuration\Screens;

use Exception;
use Livewire\Component;
use Livewire\Attributes\Rule;
use App\Models\CategoryDiagnostic;

class CategoryDiagnosticView extends Component
{
    #[Rule('required', message: 'Désignation obligatoire', onUpdate: false)]
    public $name = '';
    public ?CategoryDiagnostic $categoryDiagnosticToEdit = null;
    public string $formLabel = 'CREATION CATEGORIE DIAGNOSTIC';
    public function store()
    {
        $this->validate();
        try {
            CategoryDiagnostic::create([
                'name' => $this->name,
            ]);
        } catch (Exception $ex) {
            $this->dispatch('error', ['message' => $ex->getMessage()]);
        }
    }
    public function edit(?CategoryDiagnostic $categoryDiagnostic)
    {
        $this->categoryDiagnosticToEdit = $categoryDiagnostic;
        $this->name = $this->categoryDiagnosticToEdit->name;
        $this->formLabel = 'EDITION CATEGORIE DIAGNOSTIC';
    }
    public function update()
    {
        $this->validate();
        try {
            $this->categoryDiagnosticToEdit->name = $this->name;
            $this->categoryDiagnosticToEdit->update();
            $this->categoryDiagnosticToEdit = null;
            $this->formLabel = 'CREATION SOURCE';
        } catch (Exception $ex) {
            $this->dispatch('error', ['message' => $ex->getMessage()]);
        }
    }
    public function handlerSubmit()
    {
        if ($this->categoryDiagnosticToEdit == null) {
            $this->store();
            $this->dispatch('added', ['message' => 'Action bien réalisée']);
        } else {
            $this->update();
            $this->dispatch('updated', ['message' => 'Action bien réalisée']);
        }
        $this->name = '';
    }
    public function delete(CategoryDiagnostic $categoryDiagnostic)
    {
        try {
            if ($categoryDiagnostic->diagnostics->isEmpty()) {
                $categoryDiagnostic->delete();
                $this->dispatch('updated', ['message' => 'Action bien réalisée']);
            } else {
                $this->dispatch('error', ['message' => 'Action impossible']);
            }
        } catch (Exception $ex) {
            $this->dispatch('error', ['message' => $ex->getMessage()]);
        }
    }

    public function render()
    {
        return view('livewire.application.configuration.screens.category-diagnostic-view', [
            'categoryDignostics' => CategoryDiagnostic::orderBy('name', 'asc')
                ->get()
        ]);
    }
}
