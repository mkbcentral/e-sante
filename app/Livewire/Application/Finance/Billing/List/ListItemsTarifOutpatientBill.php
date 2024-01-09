<?php

namespace App\Livewire\Application\Finance\Billing\List;

use App\Livewire\Helpers\Query\MakeQueryBuilderHelper;
use App\Models\Currency;
use App\Models\OutpatientBill;
use Livewire\Component;

class ListItemsTarifOutpatientBill extends Component
{
    protected $listeners = [
        'refreshListItemsOupatient'=>'$refresh',
        'outpatientSelected' => 'getSelectedOutpatient',
        'currencyName' => 'getCurrencyName'
    ];
    public ?OutpatientBill $outpatientBill;
    public int $idSelected = 0, $qty = 1;
    public bool $isEditing = false;
    public string $currencyName = Currency::DEFAULT_CURRENCY;

    /**
     * getCurrencyName
     * Get currency name
     * @param  mixed $currency
     * @return void
     */
    public function getCurrencyName(string $currency)
    {
        $this->currencyName = $currency;
    }


    /**
     * getSelectedOutpatient
     *
     * @param  mixed $outpatientBill
     * @return void
     */
    public function getSelectedOutpatient(?OutpatientBill $outpatientBill)
    {
        $this->outpatientBill = $outpatientBill;
    }

    public function edit(int $id, int $qty): void
    {
        $this->idSelected = $id;
        $this->isEditing = true;
        $this->qty = $qty;
    }

    /**
     * Update item tarif selected on consultation Request
     * @return void
     */
    public function update(): void
    {
        try {
            MakeQueryBuilderHelper::update(
                'outpatient_bill_tarif',
                'id',
                $this->idSelected,
                ['qty' => $this->qty]
            );
            $this->dispatch('updated', ['message' => 'Action bien réalisée']);
            $this->isEditing = false;
            $this->idSelected = 0;
            $this->dispatch('refreshUsdAmount');
            $this->dispatch('refreshCdfAmount');
        } catch (\Exception $exception) {
            $this->dispatch('error', ['message' => $exception->getMessage()]);
        }
    }

    /**
     * Delete item tarif on consultation request
     * @param int $id
     * @return void
     */
    public function delete(int $id): void
    {
        try {
            MakeQueryBuilderHelper::delete('outpatient_bill_tarif', 'id', $id,);
            $this->dispatch('updated', ['message' => 'Action bien réalisée']);
            $this->dispatch('refreshTarifItems');
            $this->dispatch('refreshUsdAmount');
            $this->dispatch('refreshCdfAmount');
        } catch (\Exception $exception) {
            $this->dispatch('error', ['message' => $exception->getMessage()]);
        }
    }

    public function mount(?OutpatientBill $outpatientBill){
        $this->outpatientBill=$outpatientBill;
    }
    public function render()
    {
        return view('livewire.application.finance.billing.list.list-items-tarif-outpatient-bill');
    }
}
