<?php

namespace App\Livewire\Application\Configuration\Screens;

use App\Models\HospitalizationBed;
use App\Models\HospitalizationRoom;
use App\Models\Source;
use Exception;
use Livewire\Attributes\Rule;
use Livewire\Component;

class BedView extends Component
{
    #[Rule('required', message: 'Désignation obligatoire', onUpdate: false)]
    public $code = '';
    #[Rule('required', message: 'Chambre obligatoire', onUpdate: false)]
    public $hospitalization_room_id = '';
    public ?HospitalizationBed $hospitalizationBedToEdit = null;
    public string $formLabel = 'CREATION LIT';


    public function store()
    {
        $fields = $this->validate();
        try {
            HospitalizationBed::create($fields);
        } catch (Exception $ex) {
            $this->dispatch('error', ['message' => $ex->getMessage()]);
        }
    }
    public function edit(?HospitalizationBed $hospitalizationBed)
    {
        $this->hospitalizationBedToEdit = $hospitalizationBed;
        $this->code = $this->hospitalizationBedToEdit->code;
        $this->hospitalization_room_id = $this->hospitalizationBedToEdit->hospitalization_room_id;
        $this->formLabel = 'EDITION LIT';
    }
    public function update()
    {
        $fields = $this->validate();
        try {
            $this->hospitalizationBedToEdit->update($fields);
            $this->hospitalizationBedToEdit = null;
            $this->formLabel = 'CREATION LIT';
        } catch (Exception $ex) {
            $this->dispatch('error', ['message' => $ex->getMessage()]);
        }
    }
    public function handlerSubmit()
    {
        if ($this->hospitalizationBedToEdit == null) {
            $this->store();
            $this->dispatch('added', ['message' => 'Action bien réalisée']);
        } else {
            $this->update();
            $this->dispatch('updated', ['message' => 'Action bien réalisée']);
        }
        $this->code = '';
    }
    public function delete(HospitalizationBed $hospitalizationBed)
    {
        try {
            $hospitalizationBed->delete();
            $this->dispatch('updated', ['message' => 'Action bien réalisée']);
        } catch (Exception $ex) {
            $this->dispatch('error', ['message' => $ex->getMessage()]);
        }
    }
    public function render()
    {
        return view('livewire.application.configuration.screens.bed-view', [
            'beds' => HospitalizationBed::join('hospitalization_rooms', 'hospitalization_rooms.id', 'hospitalization_beds.hospitalization_room_id')
                ->where('hospitalization_rooms.source_id', Source::DEFAULT_SOURCE())
                ->select('hospitalization_beds.*')->get(),
            'hospitalizationRooms' => HospitalizationRoom::all()
        ]);
    }
}
