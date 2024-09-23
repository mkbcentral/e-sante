<?php

namespace App\Livewire\Application\Product\Invoice\Form;

use App\Livewire\Helpers\Query\MakeQueryBuilderHelper;
use App\Models\Product;
use App\Models\ProductInvoice;
use Exception;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Rule;
use Livewire\Component;

class FormQuantityProductToInvoice extends Component
{
    protected $listeners = [
        'productInvoice' => 'getProduct',
    ];

    #[Rule('required', message: 'La quantité est obligatoire')]
    public $quantity;

    public ?Product $product;
    public ?ProductInvoice $productInvoice;
    public $stockQty = 0;
    public function getProduct(?Product $product,?ProductInvoice $productInvoice,$qty){

        $this->product = $product;
        $this->productInvoice =$productInvoice;
        $this->stockQty = $qty;
    }

    public function addProductToInvoice()
    {
        $this->validate();
        try {
            $existLine = DB::table('product_product_invoice')
            ->where('product_invoice_id', $this->productInvoice->id)
                ->where('product_id', $this->product->id)
                ->first();
            if ($existLine) {
                $this->dispatch('error', ['message' => $this->product->name . ' déjà facturé']);
            } else {
                MakeQueryBuilderHelper::create('product_product_invoice', [
                    'product_invoice_id' => $this->productInvoice->id,
                    'product_id' => $this->product->id,
                    'qty'=>$this->quantity
                ]);
                $this->dispatch('itemsProductInvoiceRefreshed');
                $this->dispatch('productInvoiceRefreshedMainView');
                $this->dispatch('close-form-quntity-product-invoice');
                $this->dispatch('added', ['message' => $this->product->name . " bien supprimé !"]);
            }

        } catch (Exception $ex) {
            $this->dispatch('error', ['message' => $ex->getMessage()]);
        }
    }

    public function render()
    {
        return view('livewire.application.product.invoice.form.form-quantity-product-to-invoice');
    }
}
