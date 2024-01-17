<?php

namespace App\Livewire\Application\Configuration\Screens;

use App\Models\AgentService;
use App\Models\Hospital;
use Exception;
use Livewire\Attributes\Rule;
use Livewire\Component;

class AgentServiceView extends Component
{
    #[Rule('required', message: 'Désignation obligatoire', onUpdate: false)]
    public $name = '';
    public ?AgentService $agentServiceToEdit = null;
    public string $formLabel = 'CREATION CABINET MEDICAL';
    public function store()
    {
        $this->validate();
        try {
            AgentService::create([
                'name' => $this->name,
                'hospital_id' => Hospital::DEFAULT_HOSPITAL()
            ]);
        } catch (Exception $ex) {
            $this->dispatch('error', ['message' => $ex->getMessage()]);
        }
    }
    public function edit(?AgentService $agentService)
    {
        $this->agentServiceToEdit = $agentService;
        $this->name = $this->agentServiceToEdit->name;
        $this->formLabel = 'EDITION CABINET MEDICAL';
    }
    public function update()
    {
        $this->validate();
        try {
            $this->agentServiceToEdit->name = $this->name;
            $this->agentServiceToEdit->update();
            $this->agentServiceToEdit = null;
            $this->formLabel = 'CREATION CABINET MEDICAL';
        } catch (Exception $ex) {
            $this->dispatch('error', ['message' => $ex->getMessage()]);
        }
    }
    public function handlerSubmit()
    {
        if ($this->agentServiceToEdit == null) {
            $this->store();
            $this->dispatch('added', ['message' => 'Action bien réalisée']);
        } else {
            $this->update();
            $this->dispatch('updated', ['message' => 'Action bien réalisée']);
        }
        $this->name = '';
    }
    public function delete(AgentService $agentService)
    {
        try {
            if ($agentService->consultationSheets->isEmpty()) {
                $agentService->delete();
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
        return view('livewire.application.configuration.screens.agent-service-view',[
            'agentServices'=>AgentService::orderBy('name', 'asc')
                ->where('hospital_id', Hospital::DEFAULT_HOSPITAL())
                ->get()
        ]);
    }
}
