<?php

namespace App\Livewire\Application\Configuration\Screens;

use App\Models\Gender;
use App\Models\Hospital;
use Exception;
use Livewire\Attributes\Rule;
use Livewire\Component;

class GenderView extends Component
{
    #[Rule('required', message: 'Désignation obligatoire', onUpdate: false)]
    public $name = '';
    public string $slug = 'M';
    public ?Gender $genderToEdit = null;
    public string $formLabel = 'CREATION GENRE';
    public function store()
    {
        $this->validate();
        try {
            Gender::create([
                'name' => $this->name,
                'slug' => $this->slug,
                'hospital_id'=>Hospital::DEFAULT_HOSPITAL
            ]);
        } catch (Exception $ex) {
            $this->dispatch('error', ['message' => $ex->getMessage()]);
        }
    }
    public function edit(?Gender $gender)
    {
        $this->genderToEdit = $gender;
        $this->name = $this->genderToEdit->name;
        $this->slug = $this->genderToEdit->slug;
        $this->formLabel = 'EDITION GENRE';
    }
    public function update()
    {
        $this->validate();
        try {
            $this->genderToEdit->name = $this->name;
            $this->genderToEdit->slug = $this->slug;
            $this->genderToEdit->update();
            $this->genderToEdit = null;
            $this->formLabel = 'CREATION GENRE';
        } catch (Exception $ex) {
            $this->dispatch('error', ['message' => $ex->getMessage()]);
        }
    }
    public function handlerSubmit()
    {
        if ($this->genderToEdit == null) {
            $this->store();
            $this->dispatch('added', ['message' => 'Action bien réalisée']);
        } else {
            $this->update();
            $this->dispatch('updated', ['message' => 'Action bien réalisée']);
        }
        $this->name = '';
    }
    public function delete(Gender $gender)
    {
        try {
            $gender->delete();
            $this->dispatch('updated', ['message' => 'Action bien réalisée']);
        } catch (Exception $ex) {
            $this->dispatch('error', ['message' => $ex->getMessage()]);
        }
    }
    public function render()
    {
        return view('livewire.application.configuration.screens.gender-view',[
            'genders'=>Gender::all()
        ]);
    }
}
