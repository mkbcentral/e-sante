<?php

namespace App\Livewire\Application\Product\Invoice\Form;

use App\Models\Hospital;
use App\Models\ProductInvoice;
use Exception;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Rule;
use Livewire\Component;

class ProductInvoiceCreateAndUpdate extends Component
{
    protected $listeners = [
        'productInvoiceToFrom' => 'getProductInvoice',
        'resetdProductInvoice'=>'$refresh'

    ];
    #[Rule('required', message: 'Nom du client obligation', onUpdate: false)]
    public string $client;
    #[Rule('required', message: 'Nom du client obligation', onUpdate: false)]
    #[Rule('date', message: 'Ce champ date incorrect', onUpdate: false)]
    public string $created_at = '';
    public bool $isEditing = false;
    public string $modalLabel = 'CREATION NOUVELLE FACTURE';

    public ?ProductInvoice $productInvoice=null;

    /**
     * ProductInvoice
     *get ProductInvoice to edit
     * @param  mixed $productInvoice
     * @return void
     */
    public function getProductInvoice(?ProductInvoice $productInvoice)
    {
        $this->productInvoice = $productInvoice;
        $this->client = $productInvoice->client;
        $this->created_at=$productInvoice->created_at->format('Y-m-d');
        $this->isEditing = true;
        $this->modalLabel = 'EDITER LA FACTURE';
    }

    public function store(){
        try {
            $productInvoice=ProductInvoice::create([
                'number'=>rand(1000,10000),
                'client'=>$this->client,
                'hospital_id'=>Hospital::DEFAULT_HOSPITAL(),
                'user_id'=>Auth::id()
            ]);
            $this->dispatch('productInvoice');
            $this->dispatch('close-form-product-invoice');
            $this->dispatch('productInvoiceRefreshedMainView');
            $this->dispatch('added', ['message' => 'Action bien réalisée']);
            $this->productInvoice=null;
        } catch (Exception $ex) {
            $this->dispatch('error', ['message' => $ex->getMessage()]);
        }
    }

    public function update()
    {
        try {
           $this->productInvoice->client=$this->client;
           $this->productInvoice->created_at=$this->created_at;
           $this->productInvoice->update();
            $this->dispatch('productInvoiceUpdated', $this->productInvoice);
            $this->dispatch('productInvoiceRefreshedMainView');
            $this->dispatch('updated', ['message' => 'Action bien réalisée']);
            $this->dispatch('close-form-product-invoice');
            $this->productInvoice = null;
        } catch (Exception $ex) {
            $this->dispatch('error', ['message' => $ex->getMessage()]);
        }
    }

    public function handlerSubmit(){
        if ($this->productInvoice != null) {
            $this->update();
        } else {
            $this->store();
        }
    }

    public function mount(){
       //dd($this->productInvoice);
    }

    public function render()
    {
        if ($this->productInvoice==null) {
           $this->client='';
           $this->created_at=date('Y-m-d');
            $this->modalLabel = 'CREATION LA FACTURE';
        }
        return view('livewire.application.product.invoice.form.product-invoice-create-and-update');
    }
}
