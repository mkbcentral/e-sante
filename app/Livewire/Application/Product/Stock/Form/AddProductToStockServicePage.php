<?php

namespace App\Livewire\Application\Product\Stock\Form;

use App\Livewire\Helpers\Query\MakeQueryBuilderHelper;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class AddProductToStockServicePage extends Component
{
    public $product_id;
    public $qty;
    public function addProduct()
    {
        $this->validate([
            'product_id' => 'required',
            'qty' => 'required',
        ]);
        try {
            MakeQueryBuilderHelper::create(
                'product_stock_service',
                [
                    'product_id' => $this->product_id,
                    'qty' => $this->qty,
                    'stock_service_id' => Auth::user()->stockService->id
                ]
            );
            $this->dispatch('added', ['message' => 'Stock bien crée']);
            $this->dispatch('refreshStock');
            $this->product_id = '';
            $this->qty = '';
        } catch (\Exception $ex) {
            $this->dispatch('error', ['message' => $ex->getMessage()]);
        }
    }
    public function render()
    {
        return view('livewire.application.product.stock.form.add-product-to-stock-service-page', [
            'peoducts' => Product::query()
                ->where('is_trashed', false)
                ->orderBy('name', 'ASC')
                ->get()
        ]);
    }
}
