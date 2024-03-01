<?php

namespace App\Livewire\Application\Product\Purcharse;

use App\Livewire\Helpers\Query\MakeQueryBuilderHelper;
use App\Models\ProductPurchase;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

class ListProductPurchase extends Component
{
    use WithPagination;
    protected $listeners = [
        'productPurchase' => 'getProductPurchase',
    ];
    #[Url(as: 'q')]
    public $q = '';
    public $quantity_to_order, $idProduct;
    public bool $isEditing = false;

    public ?ProductPurchase $productPurchase = null;

    public function getProductPurchase(ProductPurchase $productPurchase)
    {
        $this->productPurchase = $productPurchase;
    }

    public function edit($idProduct)
    {
        $data = MakeQueryBuilderHelper::getSingleData('product_product_purchase', 'product_id', $idProduct);
        $this->isEditing = true;
        $this->idProduct = $data->product_id;
        $this->quantity_to_order = $data->quantity_to_order;
    }

    public function update()
    {
        try {
            MakeQueryBuilderHelper::update(
                'product_product_purchase',
                'product_id',
                $this->idProduct,
                ['quantity_to_order' => $this->quantity_to_order]
            );
            $this->isEditing = false;
            $this->idProduct = 0;
            $this->dispatch('added', ['message' => "Action bien réalisée !"]);
        } catch (\Exception $ex) {
            $this->dispatch('error', ['message' => $ex->getMessage()]);
        }
    }

    public function delete($idProduct){
        try {
            MakeQueryBuilderHelper::deleteWithKey('product_product_purchase', 'product_id',$idProduct);
            $this->dispatch('added', ['message' => "Action bien réalisée !"]);
        } catch (\Exception $ex) {
            $this->dispatch('error', ['message' => $ex->getMessage()]);
        }
    }

    public function render()
    {
        return view('livewire.application.product.purcharse.list-product-purchase', [
            'products' =>
            $this->productPurchase != null ? $this->productPurchase->products()->orderBy('name', 'ASC')
                ->where('name', 'like', '%' . $this->q . '%')
                ->paginate(20)
                : []
        ]);
    }
}
