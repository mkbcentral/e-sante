<?php

namespace App\Livewire\Application\Tarification;

use App\Models\Consultation;
use App\Models\Hospital;
use Livewire\Attributes\Rule;
use Livewire\Component;

class TarifConsultationView extends Component
{
    protected $listeners = ['deleteconsyltationListener', 'delete'];
    #[Rule('required', message: 'champs nom obligatoire')]
    public $name;
    #[Rule('required', message: 'Champs prix privé obligatoire')]
    #[Rule('numeric', message: 'Champs numérique invalide')]
    public $price_private;
    #[Rule('required', message: 'Champs prix privé obligatoire')]
    #[Rule('numeric', message: 'Champs numérique invalide')]
    public $subscriber_price;

    public ?Consultation $consultation;
    public bool $isEditing = false;
    public string $formLabel = 'CREATION CONSULTATION';

    /**
     * Save Consultation in DB
     * @return void
     */
    public function store(): void
    {
        $fields = $this->validate();
        try {
            $fields['hospital_id'] = Hospital::DEFAULT_HOSPITAL;
            Consultation::create($fields);
        } catch (\Exception $exception) {
            $this->dispatch('error', ['message' => $exception->getMessage()]);
        }
    }

    /**
     * Get Consultation  to Edit
     * @param Consultation $consultation
     * @return void
     */
    public function edit(Consultation $consultation): void
    {
        $this->isEditing = true;
        $this->consultation = $consultation;
        $this->name = $consultation->name;
        $this->price_private = $consultation->price_private;
        $this->subscriber_price = $consultation->subscriber_price;
        $this->formLabel = 'EDITION CONSULTATION';
    }

    /**
     * Update Consultation
     * @return void
     */
    public function update(): void
    {
        $fields = $this->validate();
        try {
            $this->consultation->update($fields);
            $this->name = '';
            $this->price_private = '';
            $this->subscriber_price = '';
            $this->isEditing = false;
            $this->formLabel = 'CREATION CONSULTATION';
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
    }
    /**
     * Delete consyltation
     * @param Consultation $consultation
     * @return void
     */
    public function delete(Consultation $consultation): void
    {
        try {
            if ($consultation->is_changed == false) {
                $consultation->is_changed = true;
            } else {
                $consultation->is_changed = false;
            }
            $consultation->update();
            $this->dispatch('added', ['message' => "Action bien réalisée !"]);
        } catch (\Exception $exception) {
            $this->dispatch('error', ['message' => $exception->getMessage()]);
        }
    }
    public function render()
    {
        return view('livewire.application.tarification.tarif-consultation-view', [
            'consultations' => Consultation::orderBy('name', 'ASC')->get()
        ]);
    }
}
