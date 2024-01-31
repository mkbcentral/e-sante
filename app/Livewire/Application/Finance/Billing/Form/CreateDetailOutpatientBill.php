<?php

namespace App\Livewire\Application\Finance\Billing\Form;

use App\Models\DetailOutpatientBill;
use App\Models\OutpatientBill;
use Exception;
use Livewire\Attributes\Rule;
use Livewire\Component;

class CreateDetailOutpatientBill extends Component
{
    protected $listeners = [
        'outpatientBillToDetail' => 'getOutpatient',
    ];
    #[Rule('required', message: 'Montant CDF obligatoire', onUpdate: false)]
    #[Rule('numeric', message: 'Format numerique invalide', onUpdate: false)]
    public string $amount_cdf = '';
    #[Rule('required', message: 'Montant USD obligatoire', onUpdate: false)]
    #[Rule('numeric', message: 'Format numerique invalide', onUpdate: false)]
    public string $amount_usd = '';

    public ?OutpatientBill $outpatientBill = null;
    public string $modalLabel = 'FIXATION MONTANT FACTURE';

    public function getOutpatient(OutpatientBill $outpatientBill){
        $this->outpatientBill=$outpatientBill;
        if ($outpatientBill->detailOutpatientBill) {
           $this->amount_cdf=$outpatientBill->detailOutpatientBill->amount_cdf;
           $this->amount_usd=$outpatientBill->detailOutpatientBill->amount_usd;
        }
    }

    public function store()
    {
        $fields = $this->validate();
        try {
            $fields['outpatient_bill_id'] = $this->outpatientBill->id;
            DetailOutpatientBill::create($fields);
            $this->dispatch('outpatientBill', $this->outpatientBill);
            $this->dispatch('close-form-detail-outpatient-bil');
            $this->dispatch('refreshCreateOutpatientView');
            $this->dispatch('added', ['message' => 'Action bien réalisée']);
        } catch (Exception $ex) {
            $this->dispatch('error', ['message' => $ex->getMessage()]);
        }
    }

    public function update(){
        try {
            $this->outpatientBill->detailOutpatientBill->amount_cdf = $this->amount_cdf;
            $this->outpatientBill->detailOutpatientBill->amount_usd = $this->amount_usd;
            $this->outpatientBill->detailOutpatientBill->update();
        } catch (Exception $ex) {
            $this->dispatch('error', ['message' => $ex->getMessage()]);
        }

    }

    public function handlerSubmit(): void
    {
        if ($this->outpatientBill->detailOutpatientBill != null) {
            $this->update();
        } else {
            $this->store();
        }
    }

    public function render()
    {
        return view('livewire.application.finance.billing.form.create-detail-outpatient-bill');
    }
}
