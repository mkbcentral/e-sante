<?php

namespace App\Livewire\Application\Configuration\Screens;

use App\Models\BloodGoup;
use App\Models\Hospital;
use Exception;
use Livewire\Attributes\Rule;
use Livewire\Component;

class BloodGroupView extends Component
{
    #[Rule('required', message: 'Désignation obligatoire', onUpdate: false)]
    public $name = '';
    public ?BloodGoup $bloodGroupToEdit = null;
    public string $formLabel='CREATION GROUPE SANGUIN';
    public function store()
    {
        $this->validate();
        try {
            BloodGoup::create([
                'name' => $this->name,
                'hospital_id' => Hospital::DEFAULT_HOSPITAL,
            ]);
        } catch (Exception $ex) {
            $this->dispatch('error', ['message' => $ex->getMessage()]);
        }
    }
    public function edit(?BloodGoup $bloodGroup)
    {
        $this->bloodGroupToEdit = $bloodGroup;
        $this->name = $this->bloodGroupToEdit->name;
        $this->formLabel='EDITION GROUPE SANGUIN';
    }
    public function update()
    {
        $this->validate();
        try {
            $this->bloodGroupToEdit->name = $this->name;
            $this->bloodGroupToEdit->update();
            $this->bloodGroupToEdit = null;
            $this->formLabel='CREATION GROUPE SANGUIN';
        } catch (Exception $ex) {
            $this->dispatch('error', ['message' => $ex->getMessage()]);
        }
    }
    public function handlerSubmit()
    {
        if ($this->bloodGroupToEdit == null) {
            $this->store();
            $this->dispatch('added', ['message' => 'Action bien réalisée']);
        } else {
            $this->update();
            $this->dispatch('updated', ['message' => 'Action bien réalisée']);
        }
        $this->name = '';
    }
    public function delete(BloodGoup $bloodGroup)
    {
        try {
            $bloodGroup->delete();
            $this->dispatch('updated', ['message' => 'Action bien réalisée']);
        } catch (Exception $ex) {
            $this->dispatch('error', ['message' => $ex->getMessage()]);
        }
    }
    public function render()
    {
        return view('livewire.application.configuration.screens.blood-group-view',[
            'bloodGroups'=>BloodGoup::all()
        ]);
    }
}
