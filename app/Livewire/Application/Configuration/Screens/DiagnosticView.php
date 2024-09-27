<?php

namespace App\Livewire\Application\Configuration\Screens;

use App\Models\Diagnostic;
use App\Models\Hospital;
use Exception;
use Livewire\Attributes\Rule;
use Livewire\Component;

class DiagnosticView extends Component
{
    #[Rule('required', message: 'Désignation obligatoire', onUpdate: false)]
    public $name = '';
    public ?Diagnostic $diagnosticToEdit = null;
    public string $formLabel = 'CREATION DIAGNOSTIC';
    public function store()
    {
        $this->validate();
        try {
            Diagnostic::create([
                'name' => $this->name,
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
        $this->formLabel = 'EDITION SOURCE';
    }
    public function update()
    {
        $this->validate();
        try {
            $this->diagnosticToEdit->name = $this->name;
            $this->diagnosticToEdit->update();
            $this->diagnosticToEdit = null;
            $this->formLabel = 'CREATION SOURCE';
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
    public function render()
    {
        return view('livewire.application.configuration.screens.diagnostic-view',[
            'dignostics' => Diagnostic::orderBy('name', 'asc')
                ->where('hospital_id', Hospital::DEFAULT_HOSPITAL())
                ->get()
        ]);
    }
}
