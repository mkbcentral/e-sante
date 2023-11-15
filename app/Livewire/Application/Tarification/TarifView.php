<?php

namespace App\Livewire\Application\Tarification;

use App\Models\CategoryTarif;
use App\Models\Tarif;
use Livewire\Component;

class TarifView extends Component
{
    protected $listeners=['refreshCategory'=>'$refresh'];
    public int $selectedIndex=1;

    public function showCategoryTarifPage(): void
    {
        $this->dispatch('open-category-tarif-page');
    }
    public  function changeIndex(CategoryTarif $category): void
    {
        $this->selectedIndex=$category->id;
        $this->dispatch('selectedIndex',$this->selectedIndex);
    }
    public function render()
    {
        return view('livewire.application.tarification.tarif-view',[
            'categories'=>CategoryTarif::all()
        ]);
    }
}
