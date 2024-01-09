<?php

namespace App\Livewire\Application\Configuration\Screens;

use App\Models\Hospital;
use App\Models\Rate;
use Exception;
use Livewire\Attributes\Rule;
use Livewire\Component;

class RateView extends Component
{
    #[Rule('required', message: 'Valeur taux obligatoire', onUpdate: false)]
    #[Rule('numeric', message: 'Valeur taux non valide', onUpdate: false)]
    public $rate = '';
    public ?Rate $rateToEdit = null;

    public function store()
    {
        $this->validate();
        try {
            Rate::create([
                'rate' => $this->rate,
                'hospital_id' => Hospital::DEFAULT_HOSPITAL,
            ]);
        } catch (Exception $ex) {
            $this->dispatch('error', ['message' => $ex->getMessage()]);
        }
    }
    public function edit(?Rate $rate)
    {
        $this->rateToEdit = $rate;
        $this->rate = $this->rateToEdit->rate;
    }
    public function update()
    {
        $this->validate();
        try {
            $this->rateToEdit->rate = $this->rate;
            $this->rateToEdit->update();
            $this->rateToEdit = null;
        } catch (Exception $ex) {
            $this->dispatch('error', ['message' => $ex->getMessage()]);
        }
    }
    public function handlerSubmit()
    {
        if ($this->rateToEdit == null) {
            $this->store();
            $this->dispatch('added', ['message' => 'Action bien réalisée']);
        } else {
            $this->update();
            $this->dispatch('updated', ['message' => 'Action bien réalisée']);
        }
        $this->rate = '';
    }
    public function delete(Rate $rate)
    {
        try {
            $rate->delete();
        } catch (Exception $ex) {
            $this->dispatch('error', ['message' => $ex->getMessage()]);
        }
    }
    public function changeStatus(Rate $rate)
    {
        try {
            if ($rate->is_current == true) {
                $rate->is_current = false;
            } else {
                $rate->is_current = true;
            }

            $rate->update();
            $this->dispatch('refreshRateInfo');
            $this->dispatch('added', ['message' => 'Action bien réalisée']);
        } catch (Exception $ex) {
            $this->dispatch('error', ['message' => $ex->getMessage()]);
        }
    }
    public function render()
    {
        return view('livewire.application.configuration.screens.rate-view', [
            'rates' => Rate::orderBy('created_at', 'DESC')->get()
        ]);
    }
}
