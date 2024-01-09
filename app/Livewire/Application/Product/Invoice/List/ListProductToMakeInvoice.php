<?php

namespace App\Livewire\Application\Product\Invoice\List;

use App\Livewire\Helpers\Query\MakeQueryBuilderHelper;
use App\Models\Product;
use App\Models\ProductInvoice;
use App\Repositories\Product\Get\GetProductRepository;
use Exception;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

class ListProductToMakeInvoice extends Component
{
    use WithPagination;
    #[Url(as: 'q')]
    public $q = '';
    #[Url(as: 'sortBy')]
    public $sortBy = 'name';
    #[Url(as: 'sortAsc')]
    public $sortAsc = true;
    public ?ProductInvoice $productInvoice;
    public ?Product $product;

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


    public function addProductToInvoice(Product $product){
        try {
            $existLine = DB::table('product_product_invoice')
            ->where('product_invoice_id', $this->productInvoice->id)
                ->where('product_id', $product->id)
                ->first();
            if($existLine){
                $this->dispatch('error', ['message' => $product->name. ' déjà facturé']);
            }else{
                MakeQueryBuilderHelper::create('product_product_invoice', [
                    'product_invoice_id' => $this->productInvoice->id,
                    'product_id' => $product->id,
                ]);
                $this->dispatch('itemsProductInvoiceRefreshed');
                $this->dispatch('productInvoiceRefreshedMainView');
                $this->dispatch('added', ['message' => $product->name." bien supprimé !"]);
            }
        } catch (Exception $ex) {
            //throw $th;
        }
    }

    public function mount(?ProductInvoice $productInvoice){
        $this->productInvoice=$productInvoice;
    }

    public function render()
    {
        return view('livewire.application.product.invoice.list.list-product-to-make-invoice',[
            'listProducts'=> GetProductRepository::getProductListExceptFamilyAndCategory(
                $this->q,
                $this->sortBy,
                $this->sortAsc,
                50
            )
        ]);
    }
}
