<?php

namespace App\Livewire\Application\Localization\Screens;

use App\Models\Hospital;
use App\Models\Municipality;
use App\Models\RuralArea;
use Exception;
use Livewire\Attributes\Rule;
use Livewire\Component;
use Livewire\WithPagination;

class AreaRuralView extends Component
{
    use WithPagination;
    #[Rule('required', message: 'Désignation obligatoire', onUpdate: false)]
    public $name = '';
    #[Rule('required', message: 'Commune obligatoire', onUpdate: false)]
    public $municipality_id = '';
    public ?RuralArea $ruralAreaToEdit = null;
    public string $formLabel = 'CREATION QUARTIER';
    public function store()
    {
        $this->validate();
        try {
            RuralArea::create([
                'name' => $this->name,
                'municipality_id' => $this->municipality_id,
            ]);
        } catch (Exception $ex) {
            $this->dispatch('error', ['message' => $ex->getMessage()]);
        }
    }
    public function edit(?RuralArea $ruralArea)
    {
        $this->ruralAreaToEdit = $ruralArea;
        $this->name = $this->ruralAreaToEdit->name;
        $this->municipality_id = $this->ruralAreaToEdit?->municipality?->id;
        $this->formLabel = 'EDITION QUARTIER';
    }
    public function update()
    {
        $this->validate();
        try {
            $this->ruralAreaToEdit->name = $this->name;
            $this->ruralAreaToEdit->municipality_id = $this->municipality_id;
            $this->ruralAreaToEdit->update();
            $this->ruralAreaToEdit = null;
            $this->formLabel = 'CREATION QUARTIER';
        } catch (Exception $ex) {
            $this->dispatch('error', ['message' => $ex->getMessage()]);
        }
    }
    public function handlerSubmit()
    {
        if ($this->ruralAreaToEdit == null) {
            $this->store();
            $this->dispatch('added', ['message' => 'Action bien réalisée']);
        } else {
            $this->update();
            $this->dispatch('updated', ['message' => 'Action bien réalisée']);
        }
        $this->name = '';
    }
    public function delete(RuralArea $ruralArea)
    {
        try {
            $ruralArea->delete();
            $this->dispatch('updated', ['message' => 'Action bien réalisée']);
        } catch (Exception $ex) {
            $this->dispatch('error', ['message' => $ex->getMessage()]);
        }
    }
    public function render()
    {
        return view('livewire.application.localization.screens.area-rural-view',[
            'areaRurals'=>RuralArea::orderBy('name','ASC')->paginate(10),
            'listMunicipalities'=>Municipality::where('hospital_id',Hospital::DEFAULT_HOSPITAL())->get()
        ]);
    }
}
