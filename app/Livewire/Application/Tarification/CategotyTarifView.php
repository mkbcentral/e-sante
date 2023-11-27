<?php

namespace App\Livewire\Application\Tarification;

use App\Models\CategoryTarif;
use App\Models\Hospital;
use App\Models\Tarif;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Livewire\Attributes\Rule;
use Livewire\Component;

class CategotyTarifView extends Component
{
    protected $listeners = ['deleteCategoryListener', 'delete'];
    #[Rule('required|min:3|string')]
    public $name;

    public ?CategoryTarif $categoryTarif;
    public bool $isEditing = false;

    /**
     * Save Category Tarif in DB
     * @return void
     */
    public function store(): void
    {
        $fields = $this->validate();
        try {
            $fields['hospital_id'] = Hospital::DEFAULT_HOSPITAL;
            CategoryTarif::create($fields);
            $this->dispatch('added', ['message' => 'Action bien réalisée']);
            $this->dispatch('refreshCategory');
        } catch (\Exception $exception) {
            $this->dispatch('error', ['message' => $exception->getMessage()]);
        }
    }

    /**
     * Get Category Tarif to Edit
     * @param CategoryTarif $categoryTarif
     * @return void
     */
    public function edit(CategoryTarif $categoryTarif): void
    {
        $this->isEditing = true;
        $this->categoryTarif = $categoryTarif;
        $this->name = $categoryTarif->name;
    }

    /**
     * Update Category Tarif
     * @return void
     */
    public function update(): void
    {
        $fields = $this->validate();
        try {
            $this->categoryTarif->update($fields);
            $this->dispatch('added', ['message' => 'Action bien réalisée']);
            $this->dispatch('refreshCategory');
            $this->name = '';
            $this->isEditing = false;
        } catch (\Exception $exception) {
            $this->dispatch('error', ['message' => $exception->getMessage()]);
        }
    }
    /**
     * Show delete
     * @param CategoryTarif $categoryTarif
     * @return void
     */
    public function showDeleteDialog(CategoryTarif $categoryTarif): void
    {
        $this->categoryTarif = $categoryTarif;
        $this->dispatch('delete-category-dialog');
    }
    /**
     * Delete Category Tarif
     * @param CategoryTarif $categoryTarif
     * @return void
     */
    public function delete(CategoryTarif $categoryTarif): void
    {
        try {
            if ($categoryTarif->tarifs->isEmpty()) {
                $categoryTarif->delete();
                $this->dispatch('added', ['message' => "Action bien réalisée !"]);
            } else {
                $this->dispatch('error', ['message' => 'Cette category contient des données']);
            }
        } catch (\Exception $exception) {
            $this->dispatch('error', ['message' => $exception->getMessage()]);
        }
    }

    /**
     * Render component
     * @return Application|Factory|View|\Illuminate\Foundation\Application
     */
    public function render()
    {
        return view('livewire.application.tarification.categoty-tarif-view', [
            'categories' => CategoryTarif::orderBy('name', 'ASC')->get()
        ]);
    }
}
