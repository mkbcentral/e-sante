<?php

namespace App\Livewire\Application\Configuration\Screens;

use App\Models\Hospital;
use App\Models\Hospitalization;
use App\Models\HospitalizationRoom;
use App\Models\Source;
use Exception;
use Livewire\Attributes\Rule;
use Livewire\Component;

class RoomView extends Component
{
    #[Rule('nullable')]
    public $code = '';
    #[Rule('required', message: 'Désignation obligatoire', onUpdate: false)]
    public $name = '';
    #[Rule('required', message: 'Désignation obligatoire', onUpdate: false)]
    public $hospitalization_id = '';
    public ?HospitalizationRoom $hospitalizationRoomtoEdit = null;
    public string $formLabel = 'CREATION CHAMBRE';


    public function store()
    {
        $fields = $this->validate();
        try {
            $fields['source_id'] = Source::DEFAULT_SOURCE();
            HospitalizationRoom::create($fields);
        } catch (Exception $ex) {
            $this->dispatch('error', ['message' => $ex->getMessage()]);
        }
    }
    public function edit(?HospitalizationRoom $hospitalizationRoom)
    {
        $this->hospitalizationRoomtoEdit = $hospitalizationRoom;
        $this->name = $this->hospitalizationRoomtoEdit->name;
        $this->code = $this->hospitalizationRoomtoEdit->code;
        $this->hospitalization_id = $this->hospitalizationRoomtoEdit->hospitalization_id;
        $this->formLabel = 'EDITION CHAMBRE';
    }
    public function update()
    {
        $fields=$this->validate();
        try {
            $this->hospitalizationRoomtoEdit->update($fields);
            $this->hospitalizationRoomtoEdit = null;
            $this->formLabel = 'CREATION CHAMBRE';
        } catch (Exception $ex) {
            $this->dispatch('error', ['message' => $ex->getMessage()]);
        }
    }
    public function handlerSubmit()
    {
        if ($this->hospitalizationRoomtoEdit == null) {
            $this->store();
            $this->dispatch('added', ['message' => 'Action bien réalisée']);
        } else {
            $this->update();
            $this->dispatch('updated', ['message' => 'Action bien réalisée']);
        }
        $this->name = '';
    }
    public function delete(HospitalizationRoom $hospitalizationRoom)
    {
        try {
            if ($hospitalizationRoom->hospitalizationBeds->isEmpty()) {
                $hospitalizationRoom->delete();
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
        return view('livewire.application.configuration.screens.room-view', [
            'rooms' => HospitalizationRoom::orderBy('name', 'asc')
                ->where('source_id', Source::DEFAULT_SOURCE())
                ->get(),
            'hospitalizations' => Hospitalization::all()
        ]);
    }
}
