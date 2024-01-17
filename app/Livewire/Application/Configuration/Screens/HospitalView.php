<?php

namespace App\Livewire\Application\Configuration\Screens;

use App\Models\Hospital;
use Exception;
use Livewire\Attributes\Rule;
use Livewire\Component;

class HospitalView extends Component
{
    #[Rule('required', message: 'Désignation obligatoire', onUpdate: false)]
    public $name = '';
    #[Rule('email', message: 'Adresse email invalide', onUpdate: false)]
    #[Rule('nullable')]
    public $email = '';
    #[Rule('min:10', message: 'Taille du Téléphone invalide', onUpdate: false)]
    #[Rule('max:10', message: 'Taille du Téléphone invalide', onUpdate: false)]
    public $phone = '';
    public ?Hospital $hospitalToEdit = null;
    public string $formLabel = 'CREATION UN HOPITAL';
    public function store()
    {
        $this->validate();
        try {
            Hospital::create([
                'name' => $this->name,
                'email' => $this->email,
                'phone' => $this->phone,
            ]);
        } catch (Exception $ex) {
            $this->dispatch('error', ['message' => $ex->getMessage()]);
        }
    }
    public function edit(?Hospital $hospital)
    {
        $this->hospitalToEdit = $hospital;
        $this->name = $this->hospitalToEdit->name;
        $this->email = $this->hospitalToEdit->email;
        $this->phone = $this->hospitalToEdit->phone;
        $this->formLabel = 'EDITION UN HOPITAL';
    }
    public function update()
    {
        $this->validate();
        try {
            $this->hospitalToEdit->name = $this->name;
            $this->hospitalToEdit->email = $this->email;
            $this->hospitalToEdit->phone = $this->phone;
            $this->hospitalToEdit->update();
            $this->hospitalToEdit = null;
            $this->formLabel = 'CREATION UN HOPITAL';
        } catch (Exception $ex) {
            $this->dispatch('error', ['message' => $ex->getMessage()]);
        }
    }
    public function handlerSubmit()
    {
        if ($this->hospitalToEdit == null) {
            $this->store();
            $this->dispatch('added', ['message' => 'Action bien réalisée']);
        } else {
            $this->update();
            $this->dispatch('updated', ['message' => 'Action bien réalisée']);
        }
        $this->name = '';
        $this->email = '';
        $this->phone = '';
    }
    public function delete(Hospital $hospital)
    {
        try {
            if ($hospital->consultationSheets->isEmpty() &&  $hospital->users->isEmpty()) {
                $hospital->delete();
                $this->dispatch('updated', ['message' => 'Action bien réalisée']);
            } else {
                $this->dispatch('error', ['message' => 'Action impossible hopital fonnee déjà']);
            }
        } catch (Exception $ex) {
            $this->dispatch('error', ['message' => $ex->getMessage()]);
        }
    }
    public function render()
    {
        return view('livewire.application.configuration.screens.hospital-view', [
            'hospitals' => Hospital::orderBy('name', 'asc')->get()
        ]);
    }
}
