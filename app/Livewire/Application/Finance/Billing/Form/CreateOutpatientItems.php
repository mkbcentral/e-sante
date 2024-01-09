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
    public int $selectedIndex = 1;


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

    public function openEditBillFormModal(){
        $this->dispatch('open-new-outpatient-bill');
    }


    public  function changeIndex(CategoryTarif $category): void
    {
        $this->selectedIndex = $category->id;
        $this->dispatch('selectedIndex', $this->selectedIndex);
        $this->dispatch('refreshItemsTarifWidget', $category->id);
    }

    public function mount(?OutpatientBill $outpatientBill)
    {
        $this->outpatientBill = $outpatientBill;
    }

    public function render()
    {
        return view('livewire.application.finance.billing.form.create-outpatient-items', [
            'categories' => GetCategoryTarifRepository::getListCategories()
        ]);
    }
}
