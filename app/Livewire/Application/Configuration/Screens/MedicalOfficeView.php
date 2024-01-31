<?php

namespace App\Livewire\Application\Configuration\Screens;

use App\Models\Hospital;
use App\Models\MedicalOffice;
use App\Models\Source;
use Exception;
use Livewire\Attributes\Rule;
use Livewire\Component;

class MedicalOfficeView extends Component
{
    #[Rule('required', message: 'Désignation obligatoire', onUpdate: false)]
    public $name = '';
    public ?MedicalOffice $medicalOfficeToEdit = null;
    public string $formLabel = 'CREATION CABINET MEDICAL';
    public function store()
    {
        $this->validate();
        try {
            MedicalOffice::create([
                'name' => $this->name,
                'hospital_id' => Hospital::DEFAULT_HOSPITAL(),
                'source_id' => Source::DEFAULT_SOURCE(),
            ]);
        } catch (Exception $ex) {
            $this->dispatch('error', ['message' => $ex->getMessage()]);
        }
    }
    public function edit(?MedicalOffice $medicalOffice)
    {
        $this->medicalOfficeToEdit = $medicalOffice;
        $this->name = $this->medicalOfficeToEdit->name;
        $this->formLabel = 'EDITION CABINET MEDICAL';
    }
    public function update()
    {
        $this->validate();
        try {
            $this->medicalOfficeToEdit->name = $this->name;
            $this->medicalOfficeToEdit->source_id = Source::DEFAULT_SOURCE();
            $this->medicalOfficeToEdit->update();
            $this->medicalOfficeToEdit = null;
            $this->formLabel = 'CREATION CABINET MEDICAL';
        } catch (Exception $ex) {
            $this->dispatch('error', ['message' => $ex->getMessage()]);
        }
    }
    public function handlerSubmit()
    {
        if ($this->medicalOfficeToEdit == null) {
            $this->store();
            $this->dispatch('added', ['message' => 'Action bien réalisée']);
        } else {
            $this->update();
            $this->dispatch('updated', ['message' => 'Action bien réalisée']);
        }
        $this->name = '';
    }
    public function delete(MedicalOffice $medicalOffice)
    {
        try {
            $medicalOffice->delete();
            $this->dispatch('updated', ['message' => 'Action bien réalisée']);
        } catch (Exception $ex) {
            $this->dispatch('error', ['message' => $ex->getMessage()]);
        }
    }
    public function render()
    {
        return view('livewire.application.configuration.screens.medical-office-view', [
            'medicalOffices' => MedicalOffice::orderBy('name', 'asc')
                ->where('hospital_id', Hospital::DEFAULT_HOSPITAL())
                ->where('source_id', Source::DEFAULT_SOURCE())
                ->get()
        ]);
    }
}
