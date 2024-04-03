<?php

namespace App\Livewire\Application\Product\List;

use App\Models\Product;
use App\Models\ProductCategory;
use App\Repositories\Product\Get\GetProductRepository;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

class ListProduct extends Component
{
    use WithPagination;

    protected $listeners = [
        'deleteProductListener' => 'delete',
        'refreshListProducr' => '$refresh'
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
    public bool $isSpecialty = false;
    public bool $is_trashed = false;

    public function updatedCategoryId($value): void
    {
        $this->category_id = $value;
    }
    /**
     * Open creation mode modal
     * @return void
     */
    public function openCreationModal(): void
    {
        $this->dispatch('emptyProduct');
        $this->dispatch('open-form-product');
    }

    /**
     * Show delete dialog
     * @param Product|null $product
     * @return void
     */
    public function showDeleteDialog(?Product $product): void
    {
        $this->dispatch('delete-product-dialog');
        $this->product = $product;
    }

    /**
     * Ope, edition mode modal
     * @param Product $product
     * @return void
     */
    public function edit(Product $product): void
    {
        $this->product = $product;
        $this->dispatch('productData', $product);
        $this->dispatch('open-form-product');
    }

    /**
     * Delete product in DB
     * @return void
     */
    public function delete(): void
    {
        try {
            if ($this->product->is_trashed == true) {
                $this->product->update(['is_trashed' => false]);
            } else {
                $this->product->update(['is_trashed' => true]);
            }
            $this->is_trashed =false;
            $this->dispatch('product-deleted', ['message' => "Produit bien retiré !"]);
        } catch (\Exception $ex) {
            $this->dispatch('error', ['message' => $ex->getMessage()]);
        }
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

    public function getTrached()
    {
        if ($this->is_trashed == false) {
            $this->is_trashed = true;
        } else {
            $this->is_trashed = false;
        }
    }

    /**
     * Render compoent
     * @return Application|Factory|View|\Illuminate\Foundation\Application
     */
    public function render()
    {
        return view('livewire.application.product.list.list-product', [
            'products' => GetProductRepository::getProductList(
                $this->q,
                $this->sortBy,
                $this->sortAsc,
                $this->category_id,
                $this->family_id,
                50,
                $this->is_trashed
            ),
            'categories' => ProductCategory::all()
        ]);
    }
}
