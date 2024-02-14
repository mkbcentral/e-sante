<?php

namespace App\Livewire\Application\Configuration\Screens;

use App\Models\ProductCategory;
use Exception;
use Livewire\Attributes\Rule;
use Livewire\Component;

class CategoryProductView extends Component
{
    #[Rule('required', message: 'Désignation obligatoire', onUpdate: false)]
    public $name = '';
    #[Rule('nullable')]
    public $abbreviation = '';
    public ?ProductCategory $productCategoryToEdit = null;
    public string $formLabel='CREATION CATEGORIE';
    public function store()
    {
        $this->validate();
        try {
            ProductCategory::create([
                'name' => $this->name,
                'abbreviation' => $this->abbreviation,
            ]);
        } catch (Exception $ex) {
            $this->dispatch('error', ['message' => $ex->getMessage()]);
        }
    }
    public function edit(?ProductCategory $productCategory)
    {
        $this->productCategoryToEdit = $productCategory;
        $this->name = $this->productCategoryToEdit->name;
        $this->abbreviation = $this->productCategoryToEdit->abbreviation;
        $this->formLabel='EDITION CATEGORIE';
    }
    public function update()
    {
        $this->validate();
        try {
            $this->productCategoryToEdit->name = $this->name;
            $this->productCategoryToEdit->abbreviation = $this->abbreviation;
            $this->productCategoryToEdit->update();
            $this->productCategoryToEdit = null;
            $this->formLabel='CREATION CATEGORIE';
        } catch (Exception $ex) {
            $this->dispatch('error', ['message' => $ex->getMessage()]);
        }
    }
    public function handlerSubmit()
    {
        if ($this->productCategoryToEdit == null) {
            $this->store();
            $this->dispatch('added', ['message' => 'Action bien réalisée']);
        } else {
            $this->update();
            $this->dispatch('updated', ['message' => 'Action bien réalisée']);
        }
        $this->name = '';
        $this->abbreviation = '';
    }
    public function delete(ProductCategory $productCategory)
    {
        try {
            if ($productCategory->products->isEmpty()) {
                $productCategory->delete();
                $this->dispatch('updated', ['message' => 'Action bien réalisée']);
            }else{
                $this->dispatch('error', ['message' =>'Action impossible']);
            }

        } catch (Exception $ex) {
            $this->dispatch('error', ['message' => $ex->getMessage()]);
        }
    }

    public function render()
    {
        return view('livewire.application.configuration.screens.category-product-view',[
            'productCategories'=>ProductCategory::orderBy('name','ASC')->get()
        ]);
    }
}
