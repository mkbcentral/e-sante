<?php

namespace App\Livewire\Application\Product\Invoice\List;

use App\Repositories\Product\Get\GetProductInvoiceRepository;
use Carbon\Carbon;
use Livewire\Component;

class ListInvoiceByMonth extends Component
{
    public string $month = '';
    public $date_filter, $date_versement;
    public bool $isByDate = true;

    public function updatedDateFilter()
    {
        $this->isByDate = true;
    }

    public function updatedMonth()
    {
        $this->isByDate = false;
    }

    public function mount()
    {
        $this->date_filter = date('Y-m-d');
        $this->date_versement = Carbon::tomorrow()->format('Y-m-d');
    }
    public function render()
    {
        return view('livewire.application.product.invoice.list.list-invoice-by-month', [
            'listInvoices' => $this->isByDate == true ?
                GetProductInvoiceRepository::getInvoiceByDate($this->date_filter,true) :
                GetProductInvoiceRepository::getInvoiceByMonth($this->month),
            'totalInvoice' => $this->isByDate == true ?
                GetProductInvoiceRepository::getTotalInvoiceByDate($this->date_filter) :
                GetProductInvoiceRepository::getTotalInvoiceByMonth($this->month)
        ]);
    }
}
