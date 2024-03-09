<?php

namespace App\Livewire\Application\Product\Invoice\List;

use App\Models\ProductInvoice;
use App\Repositories\Product\Get\GetProductInvoiceRepository;
use Exception;
use Livewire\Component;

class ListInvoiceByDate extends Component
{
    protected $listeners = [
        'currencyName' => 'getCurrencyName',
        'refreshListInvoice' => '$refresh'
    ];

    public string $date_filter;

    public function mount(): void
    {
        $this->date_filter = date('Y-m-d');
    }
    public function edit(?ProductInvoice $productInvoice): void
    {
        $this->dispatch('selectedInvoice', $productInvoice);
        $this->dispatch('productInvoiceToEdit', $productInvoice);
        $this->dispatch('productInvoiceToadd', $productInvoice);
        $this->dispatch('close-list-product-invoice-by-date-modal');
    }
    public function delete(?ProductInvoice $productInvoice)
    {
        try {
            $productInvoice->delete();
            $this->dispatch('productInvoiceRefreshedMainView');
            $this->dispatch('updated', ['message' => 'Action bien réalisée']);
        } catch (Exception $ex) {
            $this->dispatch('error', ['message' => $ex->getMessage()]);
        }
    }
    public function changeStatus(?ProductInvoice $productInvoice)
    {
        try {
            if ($productInvoice->is_valided) {
                $productInvoice->is_valided = false;
            } else {
                $productInvoice->is_valided = true;
            }
            $productInvoice->update();
            $this->dispatch('updated', ['message' => 'Action bien réalisée']);
        } catch (Exception $ex) {
            $this->dispatch('error', ['message' => $ex->getMessage()]);
        }
    }
    public function render()
    {
        return view('livewire.application.product.invoice.list.list-invoice-by-date', [
            'listInvoices' => GetProductInvoiceRepository::getInvoiceByDate($this->date_filter),
            'totalInvoice' => GetProductInvoiceRepository::getTotalInvoiceByDate($this->date_filter)
        ]);
    }
}
