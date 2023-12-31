<?php

namespace App\Livewire\Application\Tarification;

use App\Models\CategoryTarif;
use App\Models\Tarif;
use App\Repositories\Tarif\GetCategoryTarifRepository;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Livewire\Component;

class TarifView extends Component
{
    protected $listeners = ['refreshCategory' => '$refresh'];
    public int $selectedIndex = 1;
    /**
     * Open CategoryTarif modal view
     * @return void
     * Ben MWILA
     */
    public function showCategoryTarifPage(): void
    {
        $this->dispatch('open-category-tarif-page');
    }

    /**
     * Change CategoryId
     * @param CategoryTarif $category
     * @return void
     */
    public function changeIndex(CategoryTarif $category): void
    {
        $this->selectedIndex = $category->id;
        $this->dispatch('selectedIndex', $this->selectedIndex);
    }

    /**
     * Render component
     * @return Application|Factory|View|\Illuminate\Foundation\Application
     */
    public function render()
    {
        return view('livewire.application.tarification.tarif-view', [
            'categories' => GetCategoryTarifRepository::getListCategories()
        ]);
    }
}
