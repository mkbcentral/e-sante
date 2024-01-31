<?php

namespace App\Livewire\Application\Tarification;

use App\Models\CategoryTarif;
use App\Repositories\Tarif\GetCategoryTarifRepository;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Livewire\Component;

class TarifView extends Component
{
    protected $listeners = ['refreshCategory' => '$refresh'];
    public int $selectedIndex=0;
    /**
     * Open CategoryTarif modal view
     * @return void
     * Ben MWILA
     */
    public function showTarifConsultationPage(): void
    {
        $this->dispatch('open-tarif-conusultation-page');
    }

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
     * Open CategoryTarif modal view
     * @return void
     * Ben MWILA
     */
    public function showHospitalizationPage(): void
    {
        $this->dispatch('open-tarif-hospitalization-page');
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

    public function mount()
    {
        $category= CategoryTarif::where('name', 'like', '%LABO%')?->first();
        if ($category) {
           $this->selectedIndex = $category->id;
        }

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
