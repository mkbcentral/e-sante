<?php

namespace App\Livewire\Application\Product;

use App\Livewire\Helpers\Query\MakeQueryBuilderHelper;
use App\Models\Product;
use App\Models\ProductPurchase;
use Livewire\Attributes\Url;
use Livewire\Component;

class ProductPurchaseView extends Component
{
    protected $listeners = [
        'createdProductPurcharseListener' => 'store',
    ];
    #[Url(as: 'q')]
    public $q = '';

    public function showCreateProductPurcharseModal()
    {
        $this->dispatch('create-product-purcharse-dialog');
    }

    public function openListProductItems(ProductPurchase $productPurchase)
    {
        $this->dispatch('productPurchase', $productPurchase);
        $this->dispatch('open-list-product-purcharse-modal');
    }



    public function store()
    {
        try {
            ProductPurchase::create(['code' => rand(1000, 10000)]);
            $this->dispatch('produc-purcharse-created', ['message' => "Action bien réalisée !"]);
        } catch (\Exception $ex) {
            $this->dispatch('error', ['message' => $ex->getMessage()]);
        }
    }

    public function addProductItems(ProductPurchase $productPurchase)
    {

        try {
            $products = Product::all();
            foreach ($products as $product) {
                $data = MakeQueryBuilderHelper::getSingleDataWithOneWhereClause('product_product_purchase', 'product_id', $product->id);
                if ($data) {
                    $this->dispatch('error', ['message' => $product->name.' Exist déjà']);
                } else {
                    if ($product?->productCategory?->name == "COMPRIME") {
                        if ($product->getAmountStockGlobal() <= 30) {
                            MakeQueryBuilderHelper::create('product_product_purchase', [
                                'product_id' => $product->id,
                                'product_purchase_id' => $productPurchase->id,
                                'quantity_stock' => $product->getAmountStockGlobal() <= 0 ? 0 : $product->getAmountStockGlobal(),
                                'quantity_to_order' => 0
                            ]);
                        }
                    } else if ($product?->productCategory?->name == "SIROP") {
                        if ($product->getAmountStockGlobal() <= 10) {
                            MakeQueryBuilderHelper::create('product_product_purchase', [
                                'product_id' => $product->id,
                                'product_purchase_id' => $productPurchase->id,
                                'quantity_stock' => $product->getAmountStockGlobal() <= 0 ? 0 : $product->getAmountStockGlobal(),
                                'quantity_to_order' => 0
                            ]);
                        }
                    } else if ($product?->productCategory?->name == "INJECTABLE") {
                        if ($product->getAmountStockGlobal() <= 20) {
                            MakeQueryBuilderHelper::create('product_product_purchase', [
                                'product_id' => $product->id,
                                'product_purchase_id' => $productPurchase->id,
                                'quantity_stock' => $product->getAmountStockGlobal() <= 0 ? 0 : $product->getAmountStockGlobal(),
                                'quantity_to_order' => 0
                            ]);
                        } else if (
                            $product?->productCategory?->name == "LIQUIDE" ||
                            $product?->productCategory?->name == "PERFUSION" ||
                            $product?->productCategory?->name == "INFUSION"
                        ) {
                            if ($product->getAmountStockGlobal() <= 10) {
                                MakeQueryBuilderHelper::create('product_product_purchase', [
                                    'product_id' => $product->id,
                                    'product_purchase_id' => $productPurchase->id,
                                    'quantity_stock' => $product->getAmountStockGlobal() <= 0 ? 0 : $product->getAmountStockGlobal(),
                                    'quantity_to_order' => 0
                                ]);
                            }
                        } else {
                            if ($product->getAmountStockGlobal() <= 5) {
                                MakeQueryBuilderHelper::create('product_product_purchase', [
                                    'product_id' => $product->id,
                                    'product_purchase_id' => $productPurchase->id,
                                    'quantity_stock' => $product->getAmountStockGlobal() <= 0 ? 0 : $product->getAmountStockGlobal(),
                                    'quantity_to_order' => 0
                                ]);
                            }
                        }
                    }
                    $this->dispatch('added', ['message' => "Action bien réalisée !"]);
                }
            }
        } catch (\Exception $ex) {
            $this->dispatch('error', ['message' => $ex->getMessage()]);
        }
    }

    public function render()
    {
        return view('livewire.application.product.product-purchase-view', [
            'productPurcharses' => ProductPurchase::all()
        ]);
    }
}
