<?php

namespace App\Livewire\Application\Configuration\Screens;

use App\Models\ProductFamily;
use Exception;
use Livewire\Attributes\Rule;
use Livewire\Component;

class FamilyProductView extends Component
{
    #[Rule('required', message: 'Désignation obligatoire', onUpdate: false)]
    public $name = '';
    public ?ProductFamily $familyCategoryToEdit = null;
    public string $formLabel='CREATION FAMILLE';
    public function store()
    {
        $this->validate();
        try {
            ProductFamily::create([
                'name' => $this->name,
            ]);
        } catch (Exception $ex) {
            $this->dispatch('error', ['message' => $ex->getMessage()]);
        }
    }
    public function edit(?ProductFamily $productFamily)
    {
        $this->familyCategoryToEdit = $productFamily;
        $this->name = $this->familyCategoryToEdit->name;
        $this->formLabel='EDITION FAMILLE';
    }
    public function update()
    {
        $this->validate();
        try {
            $this->familyCategoryToEdit->name = $this->name;
            $this->familyCategoryToEdit->update();
            $this->familyCategoryToEdit = null;
            $this->formLabel='CREATION FAMILLE';
        } catch (Exception $ex) {
            $this->dispatch('error', ['message' => $ex->getMessage()]);
        }
    }
    public function handlerSubmit()
    {
        if ($this->familyCategoryToEdit == null) {
            $this->store();
            $this->dispatch('added', ['message' => 'Action bien réalisée']);
        } else {
            $this->update();
            $this->dispatch('updated', ['message' => 'Action bien réalisée']);
        }
        $this->name = '';
    }
    public function delete(ProductFamily $productFamily)
    {
        try {
            if ($productFamily->products->isEmpty()) {
                $productFamily->delete();
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
        return view('livewire.application.configuration.screens.family-product-view',[
            'families'=>ProductFamily::orderBy('name','asc')->get()
        ]);
    }
}
