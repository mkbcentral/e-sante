<?php

namespace App\Livewire\Application\Product\Invoice\List;

use App\Repositories\Product\Get\GetProductInvoiceRepository;
use Livewire\Component;

class ListInvoiceByMonth extends Component
{
    public string $month='';

    public function mount(){
        $this->month=date('m');
    }
    public function render()
    {
        return view('livewire.application.product.invoice.list.list-invoice-by-month', [
            'listInvoices' => GetProductInvoiceRepository::getInvoiceByMonth($this->month),
            'totalInvoice' => GetProductInvoiceRepository::getTotalInvoiceByMonth($this->month)
        ]);
    }
}
