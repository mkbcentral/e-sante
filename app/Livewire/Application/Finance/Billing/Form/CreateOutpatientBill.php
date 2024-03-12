<?php

namespace App\Livewire\Application\Finance\Billing\Form;

use App\Models\Currency;
use App\Models\OutpatientBill;
use App\Repositories\OutpatientBill\CreateOutpatientBillRepository;
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
    public  $consultation_id;
    #[Rule('nullable')]
    #[Rule('numeric', message: 'Dévise invalide', onUpdate: false)]
    public $currency_id;
    #[Rule('date', message: 'Format date invalide', onUpdate: false)]
    public $created_at;


    public bool $isEditing = false;
    public string $modalLabel = 'CREATION NOUVELLE FACTURE';

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
        $this->currency_id = $outpatientBill->currency_id;
        $this->created_at = $outpatientBill->created_at->format('Y-m-d');
        $this->isEditing = true;
        $this->modalLabel = 'EDITER LA FACTURE';
    }
    /**
     * store
     *Create new OutpatientBill
     * @return void
     */
    public function store()
    {
        $inputs = $this->validate();
        try {
            if (CreateOutpatientBillRepository::outpatienBillExist($this->client_name)) {
                $this->dispatch('error', ['message' => 'Ce client a déjà une facture en cours']);
            } else {
                $outpatientBill = CreateOutpatientBillRepository::create($inputs);
                $this->dispatch('outpatientBill', $outpatientBill);
                $this->dispatch('close-form-new-outpatient-bill');
                $this->dispatch('refreshCreateOutpatientView');
                $this->dispatch('added', ['message' => 'Action bien réalisée']);
                $this->outpatientBill = null;
            };
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
            $this->outpatientBill->currency_id = $this->currency_id == null ? null : $this->currency_id;
            $this->outpatientBill->created_at = $this->created_at;
            $this->outpatientBill->update();
            $this->dispatch('close-form-new-outpatient-bill');
            $this->dispatch('outpatientFreshinfo');
            $this->dispatch('outpatientBillRefreshedMainView');
            $this->dispatch('refreshListItemsOupatient');
            $this->dispatch('updated', ['message' => 'Action bien réalisée']);
            $this->dispatch('outpatientBillCanceled');
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
        return view('livewire.application.finance.billing.form.create-outpatient-bill', [
            'currencies' => Currency::all()
        ]);
    }
}
