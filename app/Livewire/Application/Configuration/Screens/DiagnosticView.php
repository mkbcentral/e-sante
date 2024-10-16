<?php

namespace App\Livewire\Application\Configuration\Screens;

use Exception;
use Livewire\Component;
use App\Models\Hospital;
use App\Models\Diagnostic;
use Livewire\WithPagination;
use Livewire\Attributes\Rule;
use App\Models\CategoryDiagnostic;

class DiagnosticView extends Component
{
    use WithPagination;
    #[Rule('required', message: 'Désignation obligatoire', onUpdate: false)]
    public $name = '';
    #[Rule('required', message: 'Désignation obligatoire', onUpdate: false)]
    public $category_diagnostic_id;
    public $category_filter=0;

    public ?Diagnostic $diagnosticToEdit = null;
    public string $formLabel = 'CREATION DIAGNOSTIC';
    public function store()
    {
        $this->validate();
        try {
            Diagnostic::create([
                'name' => $this->name,
                'category_diagnostic_id' => $this->category_diagnostic_id,
                'hospital_id' => Hospital::DEFAULT_HOSPITAL()
            ]);
        } catch (Exception $ex) {
            $this->dispatch('error', ['message' => $ex->getMessage()]);
        }
    }
    public function edit(?Diagnostic $diagnostic)
    {
        $this->diagnosticToEdit = $diagnostic;
        $this->name = $this->diagnosticToEdit->name;
        $this->formLabel = 'EDITION DIAGNOSTIC';
    }
    public function update()
    {
        $this->validate();
        try {
            $this->diagnosticToEdit->name = $this->name;
            $this->diagnosticToEdit->category_diagnostic_id = $this->category_diagnostic_id;
            $this->diagnosticToEdit->update();
            $this->diagnosticToEdit = null;
            $this->formLabel = 'CREATION DIAGNOSTIC';
        } catch (Exception $ex) {
            $this->dispatch('error', ['message' => $ex->getMessage()]);
        }
    }
    public function handlerSubmit()
    {
        if ($this->diagnosticToEdit == null) {
            $this->store();
            $this->dispatch('added', ['message' => 'Action bien réalisée']);
        } else {
            $this->update();
            $this->dispatch('updated', ['message' => 'Action bien réalisée']);
        }
        $this->name = '';
    }
    public function delete(Diagnostic $diagnostic)
    {
        try {
            if ($diagnostic->consultationRequests->isEmpty()) {
                $diagnostic->delete();
                $this->dispatch('updated', ['message' => 'Action bien réalisée']);
            } else {
                $this->dispatch('error', ['message' => 'Action impossible']);
            }
        } catch (Exception $ex) {
            $this->dispatch('error', ['message' => $ex->getMessage()]);
        }
    }
    public function mount(){
        $this->category_filter=CategoryDiagnostic::first()->id;
    }
    public function render()
    {
        return view('livewire.application.configuration.screens.diagnostic-view', [
            'dignostics' => Diagnostic::orderBy('name', 'asc')
                ->where('hospital_id', Hospital::DEFAULT_HOSPITAL())
                ->where('category_diagnostic_id',$this->category_filter)
                ->paginate(10),
            'categories' => CategoryDiagnostic::all()
        ]);
    }
}
