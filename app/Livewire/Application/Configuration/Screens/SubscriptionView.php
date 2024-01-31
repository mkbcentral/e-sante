<?php

namespace App\Livewire\Application\Configuration\Screens;

use App\Models\Hospital;
use App\Models\Source;
use App\Models\Subscription;
use Exception;
use Livewire\Attributes\Rule;
use Livewire\Component;

class SubscriptionView extends Component
{
    protected $listeners = [
        'refreshAll' => '$refresh',
    ];
    #[Rule('required', message: 'Descripption obligatoire', onUpdate: false)]
    public string $name = '';

    public array $typeItems = [
        ['slug' => 'pv', 'name' => 'Privé'],
        ['slug' => 'ab', 'name' => 'Abonné'],
        ['slug' => 'ps', 'name' => 'Personnel']
    ];
    public $type = 'pv';
    public ?Subscription $subscriptionToEdit = null;
    public string $formLabel = 'CREATION';

    public function store()
    {
        $this->validate();
        try {
            if ($this->type == 'pv') {
                Subscription::create([
                    'name' => $this->name,
                    'is_private' => 1,
                    'hospital_id' => Hospital::DEFAULT_HOSPITAL(),
                    'source_id' => Source::DEFAULT_SOURCE(),
                ]);
            } elseif ($this->type == 'ab') {
                Subscription::create([
                    'name' => $this->name,
                    'is_subscriber' => 1,
                    'hospital_id' => Hospital::DEFAULT_HOSPITAL(),
                    'source_id' => Source::DEFAULT_SOURCE(),
                ]);
            } else {
                Subscription::create([
                    'name' => $this->name,
                    'is_personnel' => 1,
                    'hospital_id' => Hospital::DEFAULT_HOSPITAL(),
                    'source_id' => Source::DEFAULT_SOURCE(),
                ]);
            }
            $this->dispatch('refreshAll');
        } catch (Exception $ex) {
            $this->dispatch('error', ['message' => $ex->getMessage()]);
        }
    }
    public function edit(?Subscription $subscription)
    {
        $this->subscriptionToEdit = $subscription;
        $this->name = $this->subscriptionToEdit->name;
        if ($subscription->is_private) {
            $this->type = 'pv';
        } elseif ($subscription->is_subscriber) {
            $this->type = 'ab';
        } else {
            $this->type = 'ps';
        }
        $this->formLabel = 'EDITION';
    }
    public function update()
    {
        $this->validate();
        try {
            if ($this->type == 'pv') {
                $this->subscriptionToEdit->name = $this->name;
                $this->subscriptionToEdit->source_id = Source::DEFAULT_SOURCE();
                $this->subscriptionToEdit->is_private = 1;
            } elseif ($this->type == 'ab') {
                $this->subscriptionToEdit->name = $this->name;
                $this->subscriptionToEdit->source_id = Source::DEFAULT_SOURCE();
                $this->subscriptionToEdit->is_subscriber = 1;
            } else {
                $this->subscriptionToEdit->name = $this->name;
                $this->subscriptionToEdit->source_id = Source::DEFAULT_SOURCE();
                $this->subscriptionToEdit->is_personnel = 1;
            }
            $this->subscriptionToEdit->update();
            $this->dispatch('refreshAll');
            $this->subscriptionToEdit = null;
            $this->formLabel = 'CREATION';
        } catch (Exception $ex) {
            $this->dispatch('error', ['message' => $ex->getMessage()]);
        }
    }
    public function handlerSubmit()
    {
        if ($this->subscriptionToEdit == null) {
            $this->store();
            $this->dispatch('added', ['message' => 'Action bien réalisée']);
        } else {
            $this->update();
            $this->dispatch('updated', ['message' => 'Action bien réalisée']);
        }
        $this->name = '';
    }
    public function delete(Subscription $Rate)
    {
        try {
            $Rate->delete();
        } catch (Exception $ex) {
            $this->dispatch('error', ['message' => $ex->getMessage()]);
        }
    }
    public function changeStatus(Subscription $subscription)
    {
        try {
            if ($subscription->is_activated == true) {
                $subscription->is_activated = false;
            } else {
                $subscription->is_activated = true;
            }

            $subscription->update();
            $this->dispatch('refreshRateInfo');
            $this->dispatch('added', ['message' => 'Action bien réalisée']);
        } catch (Exception $ex) {
            $this->dispatch('error', ['message' => $ex->getMessage()]);
        }
    }
    public function render()
    {
        return view('livewire.application.configuration.screens.subscription-view', [
            'subscriptions' => Subscription::orderBy('name', 'ASC')
                ->where('hospital_id', Hospital::DEFAULT_HOSPITAL())
                ->where('source_id', Source::DEFAULT_SOURCE())
                ->get()
        ]);
    }
}
