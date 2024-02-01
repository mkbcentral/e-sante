<?php

namespace App\Livewire\Application\Product\List;

use App\Models\ProductSupplyProduct;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class ListStockByService extends Component
{
    public function render()
    {
        return view('livewire.application.product.list.list-stock-by-service',
         [
            'productProductSupplies' => ProductSupplyProduct::join('products', 'products.id', 'product_supply_products.product_id')
                ->join('product_supplies', 'product_supplies.id', 'product_supply_products.product_supply_id')
                ->join('users', 'users.id', 'product_supplies.user_id')
                ->select('product_supply_products.*', 'products.name as product_name')
                ->with(['product'])
                ->where('users.agent_service_id',Auth::user()->agentService->id)
                ->get()
        ]);
    }
}
