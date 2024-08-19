<?php

namespace App\Livewire\Application\Product\Invoice\List;

use App\Models\ProductCategory;
use App\Repositories\Product\Get\GetProductRepository;
use Livewire\Attributes\Url;
use Livewire\Component;

class ListProductStockForInvoicePage extends Component
{
    #[Url(as: 'q')]
    public $q = '';
    #[Url(as: 'sortBy')]
    public $sortBy = 'name';
    #[Url(as: 'sortAsc')]
    public $sortAsc = true;

    public string $category_id = '';
    public string $family_id = '';

    public ?string $date_filter=null,$start_date= null,$end_date= null;


    public function updatedEndDate($val){
        $this->date_filter=null;
    }

    public function updatedDateFilter($val){
        $this->end_date=null;
        $this->start_date = null;
    }

    public function mount(){
        $this->date_filter=date('Y-m-d');
    }

    public function render()
    {
        return view('livewire.application.product.invoice.list.list-product-stock-for-invoice-page',[
            'products' => GetProductRepository::getList(
                $this->q,
                $this->sortBy,
                $this->sortAsc,
                $this->category_id,
                $this->family_id,
                50,
                false
            ),
            'categories' => ProductCategory::all()
        ]);
    }
}
