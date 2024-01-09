<?php

namespace App\Livewire\Application\Localization\Screens;

use App\Models\Hospital;
use App\Models\Municipality;
use Exception;
use Livewire\Attributes\Rule;
use Livewire\Component;

class MunicipalityView extends Component
{
    #[Rule('required', message: 'Valeur taux obligatoire', onUpdate: false)]
    public $name = '';
    public ?Municipality $municilipatyTtoEdit = null;

    public function store()
    {
        $this->validate();
        try {
            Municipality::create([
                'name' => $this->name,
                'hospital_id' => Hospital::DEFAULT_HOSPITAL,
            ]);
        } catch (Exception $ex) {
            $this->dispatch('error', ['message' => $ex->getMessage()]);
        }
    }
    public function edit(?Municipality $municilipaty)
    {
        $this->municilipatyTtoEdit = $municilipaty;
        $this->name = $this->municilipatyTtoEdit->name;
    }
    public function update()
    {
        $this->validate();
        try {
            $this->municilipatyTtoEdit->name = $this->name;
            $this->municilipatyTtoEdit->update();
            $this->municilipatyTtoEdit = null;
        } catch (Exception $ex) {
            $this->dispatch('error', ['message' => $ex->getMessage()]);
        }
    }
    public function handlerSubmit()
    {
        if ($this->municilipatyTtoEdit == null) {
            $this->store();
            $this->dispatch('added', ['message' => 'Action bien réalisée']);
        } else {
            $this->update();
            $this->dispatch('updated', ['message' => 'Action bien réalisée']);
        }
        //$this->name = '';
    }
    public function delete(Municipality $municilipaty)
    {
        try {
            if($municilipaty->ruralAreas->isEmpty()){
                $municilipaty->delete();
                $this->dispatch('updated', ['message' => 'Action bien réalisée']);
            }else{
                $this->dispatch('error', ['message' => 'Action impossible']);
            }
        } catch (Exception $ex) {
            $this->dispatch('error', ['message' => $ex->getMessage()]);
        }
    }
    public function render()
    {
        return view('livewire.application.localization.screens.municipality-view',[
            'municipalities'=>Municipality::orderBy('name','ASC')->get()
        ]);
    }
}
