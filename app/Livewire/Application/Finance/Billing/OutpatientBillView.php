<?php

namespace App\Livewire\Application\Finance\Billing;

use App\Livewire\Helpers\Query\MakeQueryBuilderHelper;
use App\Models\Currency;
use App\Models\OutpatientBill;
use Exception;
use Livewire\Component;

class OutpatientBillView extends Component
{
    /**
     * listeners
     *Array of listeners
     * @var array
     */
    protected $listeners = [
        'outpatientBill' => 'getOutpatient',
        'outpatientBillToEdit' => 'getOutpatientToEdit',
        'outpatientBillRefreshedMainView' => '$refresh',
        'currencyName' => 'getCurrencyName',
        'outpatientBillCanceled' => 'cancelBill',
    ];
    public ?OutpatientBill $outpatientBill = null;
    public bool $isEditing = false;

    /**
     * @var string
     */
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
     * Get OutpatientBill if outpatientBillListener is emitted
     * getOutpatient
     * @return void
     */
    public function getOutpatient(): void
    {
        $this->outpatientBill = OutpatientBill::orderBy('id', 'desc')->first();
    }
    /**
     * Get OutpatientBill if outpatientBillToEditListener is emitted with edition mode
     * getOutpatientToEdit
     * @param  mixed $outpatientBill
     * @return void
     */
    public function getOutpatientToEdit(?OutpatientBill $outpatientBill): void
    {
        $this->outpatientBill = $outpatientBill;
        $this->isEditing = true;
        $this->dispatch('outpatientBillToFrom', $outpatientBill);
    }
    /**
     * openNewOutpatientBillModal
     *Open modal to create new bill
     * @return void
     */
    public function openNewOutpatientBillModal(): void
    {
        $this->dispatch('open-new-outpatient-bill');
    }
    /**
     * openListListOutpatientBillModal
     *Open modal to show list bills
     * @return void
     */

    public function openAddDetailFormModal()
    {
        $this->dispatch('open-form-detail-outpatient-bill');
        $this->dispatch('outpatientBillToDetail', $this->outpatientBill);
    }
    /**
     * openListListOutpatientBillModal
     *Open modal to show list bills
     * @return void
     */
    public function openListListOutpatientBillModal(): void
    {
        $this->dispatch('open-list-outpatient-bill-by-date-modal');
        $this->dispatch('refreshListBill');
    }
    /**
    * printBill
    * Print OutpatientBill
    * @param  mixed $outpatientBill
    * @return void
    */
    public function printBill(OutpatientBill $outpatientBill)
    {
        $outpatientBill->is_validated = true;
        $outpatientBill->update();
        $this->outpatientBill = null;
        $this->isEditing = false;
    }
    /**
     * changeStatus
     * Change status of OutpatientBill
     * @param  mixed $outpatientBill
     * @return void
     */
    public function cancelBill()
    {
        $this->outpatientBill = null;
        $this->outpatientBill = null;
    }

    /**
     * edit
     * Select OutpatientBill to edit
     * @param  mixed $outpatientBill
     * @return void
     */
    public function delete()
    {
        try {
            foreach ($this->outpatientBill->tarifs as $tarif) {
                MakeQueryBuilderHelper::deleteWithKey('outpatient_bill_tarif', 'outpatient_bill_id', $this->outpatientBill->id);
            }
            if ($this->outpatientBill->otherOutpatientBill != null) {
                $this->outpatientBill->otherOutpatientBill->delete();
            }
            $this->outpatientBill->otherOutpatientBill->delete();
            $this->outpatientBill->delete();
            $this->isEditing= false;
            $this->outpatientBill = null;
            $this->dispatch('updated', ['message' => 'Action bien réalisée']);
        } catch (Exception $ex) {
            $this->dispatch('error', ['message' => $ex->getMessage()]);
        }
    }

    /**
     * @return void
     */
    public function mount()
    {
        //$this->outpatientBill = OutpatientBill::orderBy('id', 'desc')->first();
    }

    public function OpenOtherDetailOutpatientBill(): void
    {
        $this->dispatch('otherDetalOutpatientBill', $this->outpatientBill);
        $this->dispatch('open-form-new-other-detail-outpatient-bill');
    }

    /**
     * render
     * @return void
     */
    public function render()
    {
        return view('livewire.application.finance.billing.outpatient-bill-view');
    }
}
