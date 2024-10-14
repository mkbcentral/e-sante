<?php

namespace App\Livewire\Application\Configuration\Screens;

use Exception;
use App\Models\Symptom;
use Livewire\Component;
use App\Models\Diagnostic;
use Livewire\WithPagination;
use Livewire\Attributes\Rule;
use App\Models\CategoryDiagnostic;

class SymptomView extends Component
{
    use WithPagination;
    #[Rule('required', message: 'Désignation obligatoire', onUpdate: false)]
    public $name = '';
    #[Rule('required', message: 'Désignation obligatoire', onUpdate: false)]
    public $category_diagnostic_id;
    public $category_filter = 0;

    public ?Symptom $symptoomToEdit = null;
    public string $formLabel = 'CREATION DIAGNOSTIC';
    public function store()
    {
        $this->validate();
        try {
            Symptom::create([
                'name' => $this->name,
                'category_diagnostic_id' => $this->category_diagnostic_id,
            ]);
        } catch (Exception $ex) {
            $this->dispatch('error', ['message' => $ex->getMessage()]);
        }
    }
    public function edit(?Symptom $symptom)
    {
        $this->symptoomToEdit = $symptom;
        $this->name = $this->symptoomToEdit->name;
        $this->formLabel = 'EDITION DIAGNOSTIC';
    }
    public function update()
    {
        $this->validate();
        try {
            $this->symptoomToEdit->name = $this->name;
            $this->symptoomToEdit->category_diagnostic_id = $this->category_diagnostic_id;
            $this->symptoomToEdit->update();
            $this->symptoomToEdit = null;
            $this->formLabel = 'CREATION DIAGNOSTIC';
        } catch (Exception $ex) {
            $this->dispatch('error', ['message' => $ex->getMessage()]);
        }
    }
    public function handlerSubmit()
    {
        if ($this->symptoomToEdit == null) {
            $this->store();
            $this->dispatch('added', ['message' => 'Action bien réalisée']);
        } else {
            $this->update();
            $this->dispatch('updated', ['message' => 'Action bien réalisée']);
        }
        $this->name = '';
    }
    public function delete(Diagnostic $symptom)
    {
        try {
            if ($symptom->consultationRequests->isEmpty()) {
                $symptom->delete();
                $this->dispatch('updated', ['message' => 'Action bien réalisée']);
            } else {
                $this->dispatch('error', ['message' => 'Action impossible']);
            }
        } catch (Exception $ex) {
            $this->dispatch('error', ['message' => $ex->getMessage()]);
        }
    }
    public function mount()
    {
        $this->category_filter = CategoryDiagnostic::first()->id;
    }
    public function render()
    {
        return view('livewire.application.configuration.screens.symptom-view', [
            'symptoms' => Symptom::orderBy('name', 'ASC')
                ->where('category_diagnostic_id', $this->category_filter)
                ->paginate(10),
            'categories' => CategoryDiagnostic::all()
        ]);
    }
}
