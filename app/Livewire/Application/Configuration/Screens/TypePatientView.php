<?php

namespace App\Livewire\Application\Configuration\Screens;

use App\Models\Hospital;
use App\Models\TypePatient;
use Exception;
use Livewire\Attributes\Rule;
use Livewire\Component;

class TypePatientView extends Component
{
    #[Rule('required', message: 'Désignation obligatoire', onUpdate: false)]
    public $name = '';
    public ?TypePatient $typePatientToEdit = null;
    public string $formLabel = 'CREATION TYPE DU PATIENT';
    public function store()
    {
        $this->validate();
        try {
            TypePatient::create([
                'name' => $this->name,
                'hospital_id' => Hospital::DEFAULT_HOSPITAL()
            ]);
        } catch (Exception $ex) {
            $this->dispatch('error', ['message' => $ex->getMessage()]);
        }
    }
    public function edit(?TypePatient $typePatient)
    {
        $this->typePatientToEdit = $typePatient;
        $this->name = $this->typePatientToEdit->name;
        $this->formLabel = 'EDITION TYPE DU PATIENT';
    }
    public function update()
    {
        $this->validate();
        try {
            $this->typePatientToEdit->name = $this->name;
            $this->typePatientToEdit->update();
            $this->typePatientToEdit = null;
            $this->formLabel = 'CREATION TYPE DU PATIENT';
        } catch (Exception $ex) {
            $this->dispatch('error', ['message' => $ex->getMessage()]);
        }
    }
    public function handlerSubmit()
    {
        if ($this->typePatientToEdit == null) {
            $this->store();
            $this->dispatch('added', ['message' => 'Action bien réalisée']);
        } else {
            $this->update();
            $this->dispatch('updated', ['message' => 'Action bien réalisée']);
        }
        $this->name = '';
    }
    public function delete(TypePatient $typePatient)
    {
        try {
            if ($typePatient->consultationSheets->isEmpty()) {
                $typePatient->delete();
                $this->dispatch('updated', ['message' => 'Action bien réalisée']);
            } else {
                $this->dispatch('error', ['message' => 'Action impossible car des patients attachés']);
            }
        } catch (Exception $ex) {
            $this->dispatch('error', ['message' => $ex->getMessage()]);
        }
    }
    public function render()
    {
        return view('livewire.application.configuration.screens.type-patient-view',[
            'typePatients'=>TypePatient::orderBy('name','asc')
                ->where('hospital_id',Hospital::DEFAULT_HOSPITAL())
                ->get()
        ]);
    }
}
