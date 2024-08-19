<?php

namespace App\Livewire\Application\Product\Invoice\List;

use App\Models\Product;
use App\Models\ProductInvoice;
use App\Repositories\Product\Get\GetProductRepository;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

class ListProductToMakeInvoice extends Component
{
    protected $listeners = [
        'productInvoiceToadd' => 'getProductInvoice',
    ];
    use WithPagination;
    #[Url(as: 'q')]
    public $q = '';
    #[Url(as: 'sortBy')]
    public $sortBy = 'name';
    #[Url(as: 'sortAsc')]
    public $sortAsc = true;
    public ?ProductInvoice $productInvoice;
    /**
     * Get ProductInvoice if ProductInvoiceListener is emitted
     * getOutpatient
     * @return void
     */
    public function getProductInvoice(?ProductInvoice $productInvoice)
    {
        $this->productInvoice = $productInvoice;
    }

    /**
     * sort product ASC or DESC
     * @param $value
     * @return void
     */
    public function sortProduct($value): void
    {
        if ($value == $this->sortBy) {
            $this->sortAsc = !$this->sortAsc;
        }
        $this->sortBy = $value;
    }


    public function openFormQuantityModal(Product $product){

        $this->dispatch('open-form-quntity-product-invoice');
        $this->dispatch('productInvoice', $product, $this->productInvoice);
    }

    public function mount(?ProductInvoice $productInvoice){
        $this->productInvoice=$productInvoice;
    }

    public function render()
    {
        return view('livewire.application.product.invoice.list.list-product-to-make-invoice',[
            'products'=> GetProductRepository::getList(
                $this->q,
                $this->sortBy,
                $this->sortAsc,
                null,
                null,
                25,
                false
            )
        ]);
    }
}
