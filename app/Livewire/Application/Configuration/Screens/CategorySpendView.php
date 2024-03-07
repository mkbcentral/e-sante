<?php

namespace App\Livewire\Application\Configuration\Screens;

use App\Models\CategorySpendMoney;
use App\Models\Hospital;
use Exception;
use Livewire\Attributes\Rule;
use Livewire\Component;

class CategorySpendView extends Component
{
    #[Rule('required', message: 'Désignation obligatoire', onUpdate: false)]
    public $name = '';
    public ?CategorySpendMoney $categorySpendToEdit = null;
    public string $formLabel = 'CREATION CATEGORIE';
    public function store()
    {
        $this->validate();
        try {
            CategorySpendMoney::create([
                'name' => $this->name,
                'hospital_id' => Hospital::DEFAULT_HOSPITAL()
            ]);
        } catch (Exception $ex) {
            $this->dispatch('error', ['message' => $ex->getMessage()]);
        }
    }
    public function edit(?CategorySpendMoney $categorySpendMoney)
    {
        $this->categorySpendToEdit = $categorySpendMoney;
        $this->name = $this->categorySpendToEdit->name;
        $this->formLabel = 'EDITION CATEGORIE';
    }
    public function update()
    {
        $this->validate();
        try {
            $this->categorySpendToEdit->name = $this->name;
            $this->categorySpendToEdit->update();
            $this->categorySpendToEdit = null;
            $this->formLabel = 'CREATION CATEGORIE';
        } catch (Exception $ex) {
            $this->dispatch('error', ['message' => $ex->getMessage()]);
        }
    }
    public function handlerSubmit()
    {
        if ($this->categorySpendToEdit == null) {
            $this->store();
            $this->dispatch('added', ['message' => 'Action bien réalisée']);
        } else {
            $this->update();
            $this->dispatch('updated', ['message' => 'Action bien réalisée']);
        }
        $this->name = '';
    }
    public function delete(CategorySpendMoney $categorySpendMoney)
    {
        try {
            if ($categorySpendMoney->payRolles->isEmpty() || $categorySpendMoney->expenseVouchers->isEmpty()) {
                $categorySpendMoney->delete();
                $this->dispatch('updated', ['message' => 'Action bien réalisée']);
            } else {
                $this->dispatch('error', ['message' => 'Action impossible']);
            }
        } catch (Exception $ex) {
            $this->dispatch('error', ['message' => $ex->getMessage()]);
        }
    }
    public function render()
    {
        return view('livewire.application.configuration.screens.category-spend-view',[
            'categorySpends'=> CategorySpendMoney::orderBy('name', 'asc')
                ->where('hospital_id', Hospital::DEFAULT_HOSPITAL())
                ->get()
        ]);
    }
}
