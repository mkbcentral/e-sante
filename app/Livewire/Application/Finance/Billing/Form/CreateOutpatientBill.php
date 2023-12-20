<?php

namespace App\Livewire\Application\Finance\Billing\Form;

use App\Models\Hospital;
use App\Models\OutpatientBill;
use App\Repositories\Rate\RateRepository;
use Exception;
use Livewire\Attributes\Rule;
use Livewire\Component;

class CreateOutpatientBill extends Component
{
    #[Rule('required', message: 'Numéro du client obligation', onUpdate: false)]
    public string $client_name = '';
    #[Rule('required', message: 'Numéro type consultation obligation', onUpdate: false)]
    public string $consultation_id = '';
    public ?OutpatientBill $outpatientBill = null;

    public function updatedConsultationId($val)
    {
        $this->store();
    }
    public function store()
    {
        $this->validate();
        try {
            $outpatientBill = OutpatientBill::create([
                'bill_number' => rand(100, 1000),
                'client_name' => $this->client_name,
                'consultation_id' => $this->consultation_id,
                'user_id' => 1,
                'hospital_id' => Hospital::DEFAULT_HOSPITAL,
                'rate_id' => RateRepository::getCurrentRate()->id,
            ]);
            $this->dispatch('outpatientBill', $outpatientBill);
            $this->dispatch('close-form-new-outpatient-bill');
            $this->dispatch('refreshCreateOutpatientView');
            $this->dispatch('added', ['message' => 'Action bien réalisée']);
        } catch (Exception $ex) {
            $this->dispatch('error', ['message' => $ex->getMessage()]);
        }
    }
    public function render()
    {
        return view('livewire.application.finance.billing.form.create-outpatient-bill');
    }
}
