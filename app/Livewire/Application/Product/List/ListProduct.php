<?php

namespace App\Livewire\Application\Product\List;

use App\Models\Product;
use App\Repositories\Product\Get\GetProductRepository;
use JetBrains\PhpStorm\NoReturn;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

class ListProduct extends Component
{
    use WithPagination;

    protected $listeners = [
        'deleteProductListener' => 'delete'
    ];
    #[Url(as: 'q')]
    public $q = '';
    #[Url(as: 'sortBy')]
    public $sortBy = 'name';
    #[Url(as: 'sortAsc')]
    public $sortAsc = true;

    public string $category_id = '';
    public string $family_id = '';
    public ?Product $product;

    public function openCreationModal(): void
    {
        $this->dispatch('emptyProduct');
        $this->dispatch('open-form-product');
    }

    public function showDeleteDialog(?Product $product): void
    {
        $this->dispatch('delete-product-dialog');
        $this->product = $product;
    }

    public function edit(Product $product): void
    {
        $this->product = $product;
        $this->dispatch('productData', $product);
        $this->dispatch('open-form-product');
    }

    #[NoReturn] public function delete(): void
    {
        try {
            $this->product->delete();
            $this->dispatch('product-deleted', ['message' => "Produit bien supprimé !"]);
        } catch (\Exception $ex) {
            $this->dispatch('error', ['message' => $ex->getMessage()]);
        }
    }

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
