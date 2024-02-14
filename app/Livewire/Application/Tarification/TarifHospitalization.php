<?php

namespace App\Livewire\Application\Tarification;

use App\Models\Hospital;
use App\Models\Hospitalization;
use App\Models\Source;
use Livewire\Attributes\Rule;
use Livewire\Component;

class TarifHospitalization extends Component
{
    #[Rule('required', message: 'champs nom obligatoire')]
    public $name;
    #[Rule('required', message: 'Champs prix privé obligatoire')]
    #[Rule('numeric', message: 'Champs numérique invalide')]
    public $price_private;
    #[Rule('required', message: 'Champs prix privé obligatoire')]
    #[Rule('numeric', message: 'Champs numérique invalide')]
    public $subscriber_price;

    public ?Hospitalization $hospitalization;
    public bool $isEditing = false;
    public string $formLabel = 'CREATION SEJOUR';

    /**
     * Save SEJOUR in DB
     * @return void
     */
    public function store(): void
    {
        $fields = $this->validate();
        try {
            $fields['hospital_id'] = Hospital::DEFAULT_HOSPITAL();
            $fields['source_id'] = Source::DEFAULT_SOURCE();
            Hospitalization::create($fields);
        } catch (\Exception $exception) {
            $this->dispatch('error', ['message' => $exception->getMessage()]);
        }
    }

    /**
     * Get Hospitalization  to Edit
     * @param Hospitalization $hospitalization
     * @return void
     */
    public function edit(Hospitalization $hospitalization): void
    {
        $this->isEditing = true;
        $this->hospitalization = $hospitalization;
        $this->name = $hospitalization->name;
        $this->price_private = $hospitalization->price_private;
        $this->subscriber_price = $hospitalization->subscriber_price;
        $this->formLabel = 'EDITION SEJOUR';
    }
    /**
     * Update SEJOUR
     * @return void
     */
    public function update(): void
    {
        $fields = $this->validate();
        try {
            $this->hospitalization->update($fields);
            $this->isEditing = false;
            $this->formLabel = 'CREATION SEJOUR';
        } catch (\Exception $exception) {
            $this->dispatch('error', ['message' => $exception->getMessage()]);
        }
    }
    public function handlerSubmit()
    {
        if ($this->isEditing == false) {
            $this->store();
            $this->dispatch('added', ['message' => 'Action bien réalisée']);
        } else {
            $this->update();
            $this->dispatch('added', ['message' => 'Action bien réalisée']);
        }
        $this->dispatch('refreshconsyltation');
        $this->name = '';
        $this->price_private = '';
        $this->subscriber_price = '';
    }
    /**
     * Delete hospitalization
     * @param Hospitalization $hospitalization
     * @return void
     */
    public function delete(Hospitalization $hospitalization): void
    {
        try {
            if ($hospitalization->is_changed == false) {
                $hospitalization->is_changed = true;
            } else {
                $hospitalization->is_changed = false;
            }
            $hospitalization->update();
            $this->dispatch('added', ['message' => "Action bien réalisée !"]);
        } catch (\Exception $exception) {
            $this->dispatch('error', ['message' => $exception->getMessage()]);
        }
    }
    public function render()
    {
        return view('livewire.application.tarification.tarif-hospitalization', [
            'hospitalizations' => Hospitalization::orderBy('name', 'ASC')
                ->where('is_changed', false)
                ->where('hospital_id', Hospital::DEFAULT_HOSPITAL())
                //->where('source_id', Source::DEFAULT_SOURCE())
                ->get()
        ]);
    }
}
