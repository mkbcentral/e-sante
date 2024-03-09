<?php

namespace App\Livewire\Application\Finance\Billing\Form;

use App\Models\CategoryTarif;
use App\Models\OutpatientBill;
use App\Repositories\Tarif\GetCategoryTarifRepository;
use Livewire\Component;

class CreateOutpatientItems extends Component
{
    protected $listeners = [
        'outpatientSelected' => 'getSelectedOutpatient',
        'outpatientFreshinfo' => '$refresh'
    ];
    public ?OutpatientBill $outpatientBill;
    public int $selectedIndex;
    public  $isOtherDetail = false;


    /**
     * getSelectedOutpatient
     *Get OutpatientBill to edit
     * @param  mixed $outpatientBill
     * @return void
     */
    public function getSelectedOutpatient(?OutpatientBill $outpatientBill)
    {
        $this->outpatientBill = $outpatientBill;
    }

    public function openEditBillFormModal()
    {
        $this->dispatch('open-new-outpatient-bill');
    }
    public  function changeIndex(CategoryTarif $category): void
    {
        $this->isOtherDetail = false;
        $this->selectedIndex = $category->id;
        $this->dispatch('selectedIndex', $this->selectedIndex);
        $this->dispatch('refreshItemsTarifWidget', $category->id);
    }

    public function OpenOtherDetailOutpatientBill()
    {
        $this->isOtherDetail = true;
        $this->selectedIndex = 0;
        $this->dispatch('otherDetalOutpatientBill', $this->outpatientBill);
        $this->dispatch('open-form-new-other-detail-outpatient-bill');
    }

    public function mount(?OutpatientBill $outpatientBill)
    {
        $this->outpatientBill = $outpatientBill;
        $this->selectedIndex = CategoryTarif::where('name', 'like', '%LABO%')->first()->id;
    }

    public function openAddDetailFormModal()
    {
        $this->dispatch('open-form-detail-outpatient-bill');
        $this->dispatch('outpatientBillToDetail', $this->outpatientBill);
    }

    public function openNewOutpatientBillModal(): void
    {
        $this->dispatch('outpatientBillToFrom', $this->outpatientBill);
        $this->dispatch('open-new-outpatient-bill');
    }
    public function render()
    {
        return view('livewire.application.finance.billing.form.create-outpatient-items', [
            'categories' => GetCategoryTarifRepository::getListCategories()
        ]);
    }
}
