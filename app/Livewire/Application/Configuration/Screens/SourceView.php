<?php

namespace App\Livewire\Application\Configuration\Screens;

use App\Models\Hospital;
use App\Models\Source;
use Exception;
use Livewire\Attributes\Rule;
use Livewire\Component;

class SourceView extends Component
{
    #[Rule('required', message: 'Désignation obligatoire', onUpdate: false)]
    public $name = '';
    public ?Source $sourceToEdit = null;
    public string $formLabel = 'CREATION SOURCE';
    public function store()
    {
        $this->validate();
        try {
            Source::create([
                'name' => $this->name,
                'hospital_id' => Hospital::DEFAULT_HOSPITAL()
            ]);
        } catch (Exception $ex) {
            $this->dispatch('error', ['message' => $ex->getMessage()]);
        }
    }
    public function edit(?Source $source)
    {
        $this->sourceToEdit = $source;
        $this->name = $this->sourceToEdit->name;
        $this->formLabel = 'EDITION SOURCE';
    }
    public function update()
    {
        $this->validate();
        try {
            $this->sourceToEdit->name = $this->name;
            $this->sourceToEdit->update();
            $this->sourceToEdit = null;
            $this->formLabel = 'CREATION SOURCE';
        } catch (Exception $ex) {
            $this->dispatch('error', ['message' => $ex->getMessage()]);
        }
    }
    public function handlerSubmit()
    {
        if ($this->sourceToEdit == null) {
            $this->store();
            $this->dispatch('added', ['message' => 'Action bien réalisée']);
        } else {
            $this->update();
            $this->dispatch('updated', ['message' => 'Action bien réalisée']);
        }
        $this->name = '';
    }
    public function delete(Source $source)
    {
        try {
            if ($source->users->isEmpty()) {
                $source->delete();
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
        return view('livewire.application.configuration.screens.source-view',[
            'sources'=>Source::orderBy('name', 'asc')
                ->where('hospital_id', Hospital::DEFAULT_HOSPITAL())
                ->get()
        ]);
    }
}
