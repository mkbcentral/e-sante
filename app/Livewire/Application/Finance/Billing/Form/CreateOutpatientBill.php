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
    protected $listeners = [
        'outpatientBillToFrom' => 'getOutpatient',
    ];

    #[Rule('required', message: 'Numéro du client obligation', onUpdate: false)]
    public string $client_name = '';
    #[Rule('required', message: 'Numéro type consultation obligation', onUpdate: false)]
    public string $consultation_id = '';
    public bool $isEditing =false;
    public string $modalLabel= 'CREATION NOUVELLE FACTURE';

    public ?OutpatientBill $outpatientBill = null;

    /**
     * getOutpatient
     *get OutpatientBill to edit
     * @param  mixed $outpatientBill
     * @return void
     */
    public function getOutpatient(?OutpatientBill $outpatientBill)
    {
        $this->outpatientBill = $outpatientBill;
        $this->client_name = $outpatientBill->client_name;
        $this->consultation_id = $outpatientBill->consultation_id;
        $this->isEditing=true;
        $this->modalLabel='EDITER LA FACTURE';
    }

    /**
     * updatedConsultationId
     *Change state of consultation_id property if updated
     * @param  mixed $val
     * @return void
     */
    public function updatedConsultationId($val): void
    {
        $this->handlerSubmit();
    }
    /**
     * store
     *Create new OutpatientBill
     * @return void
     */
    public function store()
    {
        $this->validate();
        try {
            $outpatientBill = OutpatientBill::create([
                'bill_number' => rand(100, 1000),
                'client_name' => $this->client_name,
                'consultation_id' => $this->consultation_id,
                'user_id' => 1,
                'hospital_id' => Hospital::DEFAULT_HOSPITAL(),
                'rate_id' => RateRepository::getCurrentRate()->id,
            ]);
            $this->dispatch('outpatientBill', $outpatientBill);
            $this->dispatch('close-form-new-outpatient-bill');
            $this->dispatch('refreshCreateOutpatientView');
            $this->dispatch('added', ['message' => 'Action bien réalisée']);
            $this->outpatientBill=null;
        } catch (Exception $ex) {
            $this->dispatch('error', ['message' => $ex->getMessage()]);
        }
    }

    /**
     * update
     *Update OutpatientBill
     * @return void
     */
    public function update(): void
    {
        try {
            $this->outpatientBill->client_name = $this->client_name;
            $this->outpatientBill->consultation_id = $this->consultation_id;
            $this->outpatientBill->update();
            $this->dispatch('close-form-new-outpatient-bill');
            $this->dispatch('outpatientFreshinfo');
            $this->dispatch('outpatientBillRefreshedMainView');
            $this->dispatch('refreshListItemsOupatient');
            $this->dispatch('updated', ['message' => 'Action bien réalisée']);
        } catch (Exception  $ex) {
            $this->dispatch('error', ['message' => $ex->getMessage()]);
        }
    }
    /**
     * handlerSubmit
     *Check if is edit or create mode to handler submit action
     * @return void
     */
    public function handlerSubmit(): void
    {
        if ($this->outpatientBill != null) {
            $this->update();
        } else {
            $this->store();
        }
    }
    public function render()
    {
        return view('livewire.application.finance.billing.form.create-outpatient-bill');
    }
}
