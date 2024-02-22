<?php

namespace App\Livewire\Application\Finance\Billing\Form;

use App\Models\OtherDetailOutpatientBill;
use App\Models\OutpatientBill;
use Exception;
use Livewire\Attributes\Rule;
use Livewire\Component;

class CreateOtherDetailOutpatientBill extends Component
{

    protected $listeners = [
        'otherDetalOutpatientBill' => 'getOutpatient',
    ];
    #[Rule('required', message: 'La description est obligatoire')]
    public $name;
    #[Rule('required', message: 'Le montant est obligatoire')]
    #[Rule('numeric', message: 'Le montant doit être numerique')]

    public $amount;
    public OutpatientBill $outpatientBill;
    public ?OtherDetailOutpatientBill $otherOutpatientBill = null;
    public function getOutpatient(OutpatientBill $outpatientBill)
    {
        if ($outpatientBill->otherOutpatientBill != null) {
            $this->otherOutpatientBill = $outpatientBill->otherOutpatientBill;
            $this->name = $outpatientBill->otherOutpatientBill->name;
            $this->amount = $outpatientBill->otherOutpatientBill->amount;
        } else {
            $outpatientBill->otherOutpatientBill = null;
        }
        $this->outpatientBill = $outpatientBill;
    }

    public function store()
    {
        $inputs =  $this->validate();
        try {
            $inputs['outpatient_bill_id'] = $this->outpatientBill->id;
            OtherDetailOutpatientBill::create($inputs);
            $this->dispatch('added', ['message' => "Action bien réalisée !"]);
        } catch (Exception $ex) {
            $this->dispatch('error', ['message' => $ex->getMessage()]);
        }
    }

    public function update()
    {
        $inputs =  $this->validate();
        try {
            $this->otherOutpatientBill->update($inputs);
            $this->dispatch('added', ['message' => "Action bien réalisée !"]);
        } catch (Exception $ex) {
            $this->dispatch('error', ['message' => $ex->getMessage()]);
        }
    }

    public function delete()
    {
        try {
            $this->otherOutpatientBill->delete();
            $this->dispatch('added', ['message' => "Action bien réalisée !"]);
            $this->dispatch('close-form-new-other-detail-outpatient-bill');
            $this->dispatch('outpatientBillRefreshedMainView');
            $this->dispatch('refreshCdfAmount');
            $this->dispatch('refreshUsdAmount');
        } catch (Exception $ex) {
            $this->dispatch('error', ['message' => $ex->getMessage()]);
        }
    }

    public function handlerSubmit()
        {
        if ($this->otherOutpatientBill == null) {
            $this->store();
        } else {
            $this->update();
        }
        $this->dispatch('close-form-new-other-detail-outpatient-bill');
        $this->dispatch('outpatientBillRefreshedMainView');
        $this->dispatch('refreshCdfAmount');
        $this->dispatch('refreshUsdAmount');
        $this->name='';
        $this->amount='';
    }


    public function render()
    {
        return view('livewire.application.finance.billing.form.create-other-detail-outpatient-bill');
    }
}
