<?php

namespace App\Livewire\Application\Configuration\Screens;

use App\Models\Hospital;
use App\Models\VitalSign;
use Exception;
use Livewire\Attributes\Rule;
use Livewire\Component;

class VitalSignView extends Component
{
    #[Rule('required', message: 'Désignation obligatoire', onUpdate: false)]
    public $name = '';
    #[Rule('required', message: 'Unité obligatoire', onUpdate: false)]
    public $unit = '';
    public ?VitalSign $vitalSign = null;
    public string $formLabel = 'CREATION SIGNE VITAL';
    public function store()
    {
        $this->validate();
        try {
            VitalSign::create([
                'name' => $this->name,
                'unit' => $this->unit,
                'hospital_id' => Hospital::DEFAULT_HOSPITAL()
            ]);
        } catch (Exception $ex) {
            $this->dispatch('error', ['message' => $ex->getMessage()]);
        }
    }
    public function edit(?VitalSign $vitalSign)
    {
        $this->vitalSign = $vitalSign;
        $this->name = $this->vitalSign->name;
        $this->unit = $this->vitalSign->unit;
        $this->formLabel = 'EDITION SIGNE VITAL';
    }
    public function update()
    {
        $this->validate();
        try {
            $this->vitalSign->name = $this->name;
            $this->vitalSign->unit = $this->unit;
            $this->vitalSign->update();
            $this->vitalSign = null;
            $this->formLabel = 'CREATION SIGNE VITAL';
        } catch (Exception $ex) {
            $this->dispatch('error', ['message' => $ex->getMessage()]);
        }
    }
    public function handlerSubmit()
    {
        if ($this->vitalSign == null) {
            $this->store();
            $this->dispatch('added', ['message' => 'Action bien réalisée']);
        } else {
            $this->update();
            $this->dispatch('updated', ['message' => 'Action bien réalisée']);
        }
        $this->name = '';
        $this->unit = '';
    }
    public function delete(VitalSign $vitalSign)
    {
        try {
            $vitalSign->delete();
            $this->dispatch('updated', ['message' => 'Action bien réalisée']);
        } catch (Exception $ex) {
            $this->dispatch('error', ['message' => $ex->getMessage()]);
        }
    }
    public function render()
    {
        return view('livewire.application.configuration.screens.vital-sign-view',[
            'vitalsigns'=>VitalSign::orderBy('name', 'asc')
                ->where('hospital_id', Hospital::DEFAULT_HOSPITAL())
                ->get()
        ]);
    }
}
