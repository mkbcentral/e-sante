<?php

namespace App\Livewire\Application\Product\List;

use App\Repositories\Product\Get\GetProductRepository;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

class ListStockByService extends Component
{
    use WithPagination;
    #[Url(as: 'q')]
    public $q = '';
    #[Url(as: 'sortBy')]
    public $sortBy = 'name';
    #[Url(as: 'sortAsc')]
    public $sortAsc = true;
    public function render()
    {
        return view('livewire.application.product.list.list-stock-by-service',
            [
                'products' => GetProductRepository::getProductListExceptFamilyAndCategory($this->q, $this->sortBy, $this->sortAsc, 10)
            ]
        );
    }
}
