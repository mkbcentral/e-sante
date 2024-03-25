<?php

namespace App\Livewire\Application\Dashboard\Product;

use App\Repositories\Product\Get\GetProductInvoiceRepository;
use Livewire\Component;

class DashInvoiceProduct extends Component
{
    public $date_filter;
    public function mount()
    {
        $this->date_filter = date('Y-m-d');
    }

    public function render()
    {
        return view('livewire.application.dashboard.product.dash-invoice-product',[
            'totalInvoice' => GetProductInvoiceRepository::getTotalInvoiceByDate($this->date_filter)
        ]);
    }
}
