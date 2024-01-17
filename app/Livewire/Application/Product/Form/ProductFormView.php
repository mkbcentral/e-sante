<?php

namespace App\Livewire\Application\Product\Form;

use App\Livewire\Forms\ProductForm;
use App\Models\Hospital;
use App\Models\Product;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Livewire\Component;

class ProductFormView extends Component
{
    protected $listeners = [
        'emptyProduct' => 'getEmptyProduct',
        'productData' => 'getProduct'
    ];
    public ?Product $product = null;
    public ProductForm $form;

    /**
     * Emit emptyProduct listener to get empty product id is creation mode
     * @return void
     */
    public function getEmptyProduct(): void
    {
        $this->product = null;
        $this->form->reset();
    }

    /**
     * Emit productData to product selected in parent component
     * @param Product|null $product
     * @return void
     */
    public function getProduct(?Product $product): void
    {
        $this->product = $product;
        $this->form->fill($product->toArray());
    }

    /**
     * Save product in DB
     * @return void
     */
    public function store(): void
    {
        $this->validate();
        try {
            $fields=$this->form->all();
            $fields['hospital_id']=Hospital::DEFAULT_HOSPITAL();
            $fields['source_id']=auth()->user()->source->id;
            Product::create($fields);
            $this->dispatch('added', ['message' => 'Action bien réalisée']);
            $this->dispatch('close-product-form');
        }catch (\Exception $exception){
            $this->dispatch('error', ['message' => $exception->getMessage()]);
        }
    }

    /**
     * Update product
     * @return void
     */
    public function update(): void
    {
        $this->validate();
        try {
            $fields = $this->form->all();
            $fields['source_id'] = auth()->user()->source->id;
            $this->product->update($fields);
            $this->dispatch('updated', ['message' => 'Action bien réalisée']);
            $this->dispatch('close-product-form');
        }catch (\Exception $exception){
            $this->dispatch('error', ['message' => $exception->getMessage()]);
        }
    }

    /**
     * Check if product exist to update or empty create a new record
     * @return void
     */
    public function handlerSubmit(): void
    {
        if ($this->product==null){
            $this->store();
        }else{
            $this->update();
        }
        $this->dispatch('refreshListProducr');
    }

    /**
     * Render form product component
     * @return Application|Factory|View|\Illuminate\Foundation\Application
     */
    public function render()
    {
        return view('livewire.application.product.form.product-form-view');
    }
}
