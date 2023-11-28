<?php

namespace App\Livewire\Application\Product\Form;

use App\Livewire\Forms\ProductForm;
use App\Models\Hospital;
use App\Models\Product;
use Livewire\Component;

class ProductFormView extends Component
{
    protected $listeners = [
        'emptyProduct' => 'getEmptyProduct',
        'productData' => 'getProduct'
    ];
    public ?Product $product = null;
    public ProductForm $form;
    public function getEmptyProduct(): void
    {
        $this->product = null;
        $this->form->reset();
    }
    public function getProduct(?Product $product): void
    {
        $this->product = $product;
        $this->form->fill($product->toArray());
    }

    public function store(): void
    {
        $this->validate();
        try {
            $fields=$this->form->all();
            $fields['hospital_id']=Hospital::DEFAULT_HOSPITAL;
            Product::create($fields);
            $this->dispatch('added', ['message' => 'Action bien réalisée']);
            $this->dispatch('close-product-form');
        }catch (\Exception $exception){
            $this->dispatch('error', ['message' => $exception->getMessage()]);
        }
    }
    public function update(){
        $this->validate();
        try {
            $this->product->update($this->form->all());
            $this->dispatch('updated', ['message' => 'Action bien réalisée']);
            $this->dispatch('close-product-form');
        }catch (\Exception $exception){
            $this->dispatch('error', ['message' => $exception->getMessage()]);
        }
    }
    public function handlerSubmit(): void
    {
        if ($this->product==null){
            $this->store();
        }else{
            $this->update();
        }
    }
    public function render()
    {
        return view('livewire.application.product.form.product-form-view');
    }
}
