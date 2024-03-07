<?php

namespace App\Livewire\Application\Configuration\Screens;

use App\Models\CashCategory;
use App\Models\Hospital;
use Exception;
use Livewire\Attributes\Rule;
use Livewire\Component;

class CashCategoryView extends Component
{
    #[Rule('required', message: 'Désignation obligatoire', onUpdate: false)]
    public $name = '';
    public ?CashCategory $cashCategoryToEdit = null;
    public string $formLabel = 'CREATION CATEGORIE';
    public function store()
    {
        $this->validate();
        try {
            CashCategory::create([
                'name' => $this->name,
                'hospital_id' => Hospital::DEFAULT_HOSPITAL()
            ]);
        } catch (Exception $ex) {
            $this->dispatch('error', ['message' => $ex->getMessage()]);
        }
    }
    public function edit(?CashCategory $cashCategory)
    {
        $this->cashCategoryToEdit = $cashCategory;
        $this->name = $this->cashCategoryToEdit->name;
        $this->formLabel = 'EDITION CATEGORIE';
    }
    public function update()
    {
        $this->validate();
        try {
            $this->cashCategoryToEdit->name = $this->name;
            $this->cashCategoryToEdit->update();
            $this->cashCategoryToEdit = null;
            $this->formLabel = 'CREATION CATEGORIE';
        } catch (Exception $ex) {
            $this->dispatch('error', ['message' => $ex->getMessage()]);
        }
    }
    public function handlerSubmit()
    {
        if ($this->cashCategoryToEdit == null) {
            $this->store();
            $this->dispatch('added', ['message' => 'Action bien réalisée']);
        } else {
            $this->update();
            $this->dispatch('updated', ['message' => 'Action bien réalisée']);
        }
        $this->name = '';
    }
    public function delete(CashCategory $cashCategory)
    {
        try {
            $cashCategory->delete();
            $this->dispatch('updated', ['message' => 'Action bien réalisée']);
        } catch (Exception $ex) {
            $this->dispatch('error', ['message' => $ex->getMessage()]);
        }
    }
    public function render()
    {
        return view('livewire.application.configuration.screens.cash-category-view', [
            'cashCategories' => CashCategory::orderBy('name', 'asc')
                ->where('hospital_id', Hospital::DEFAULT_HOSPITAL())
                ->get()
        ]);
    }
}
