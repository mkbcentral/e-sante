<?php

namespace App\Livewire\Application\Product\List;

use App\Models\Hospital;
use App\Models\Product;
use App\Repositories\Product\Get\GetProductRepository;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

class ListProduct extends Component
{
    use WithPagination;

    #[Url(as: 'q')]
    public $q = '';
    #[Url(as: 'sortBy')]
    public $sortBy = 'name';
    #[Url(as: 'sortAsc')]
    public $sortAsc = true;

    public string $category_id = '';
    public string $family_id = '';

    public function sortProduct($value): void
    {
        if ($value == $this->sortBy) {
            $this->sortAsc = !$this->sortAsc;
        }
        $this->sortBy = $value;
    }

    public function render()
    {
        return view('livewire.application.product.list.list-product', [
            'products' => GetProductRepository::getProductList(
                $this->q,
                $this->sortBy,
                $this->sortAsc,
                $this->category_id,
                $this->family_id,
                50
            )
        ]);
    }
}
