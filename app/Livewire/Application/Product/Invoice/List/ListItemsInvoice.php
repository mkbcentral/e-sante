<?php

namespace App\Livewire\Application\Product\Invoice\List;

use App\Livewire\Helpers\Query\MakeQueryBuilderHelper;
use App\Models\ProductInvoice;
use Livewire\Component;

class ListItemsInvoice extends Component
{
    protected $listeners = [
        'itemsProductInvoiceRefreshed' => '$refresh',
        'selectedInvoice' => 'getSelectedInvoice'
    ];
    public ?ProductInvoice $productInvoice;
    public int $idSelected = 0, $qty = 1;
    public bool $isEditing = false;

    public function getSelectedInvoice(?ProductInvoice $productInvoice){
        $this->productInvoice=$productInvoice;
    }


    public function edit(int $id, int $qty): void
    {
        $this->idSelected = $id;
        $this->isEditing = true;
        $this->qty = $qty;
    }

    public function update(): void
    {
        try {
            MakeQueryBuilderHelper::update(
                'product_product_invoice',
                'id',
                $this->idSelected,
                ['qty' => $this->qty]
            );
            $this->dispatch('updated', ['message' => 'Action bien réalisée']);
            $this->dispatch('productInvoiceRefreshedMainView');
            $this->isEditing = false;
            $this->idSelected = 0;
        } catch (\Exception $exception) {
            $this->dispatch('error', ['message' => $exception->getMessage()]);
        }
    }

    public function delete(int $id): void
    {
        try {
            MakeQueryBuilderHelper::delete('product_product_invoice', 'id', $id,);
            $this->dispatch('productInvoiceRefreshedMainView');
            $this->dispatch('updated', ['message' => 'Action bien réalisée']);
        } catch (\Exception $exception) {
            $this->dispatch('error', ['message' => $exception->getMessage()]);
        }
    }

    public function validateInvoice(){
        try {
            if ($this->productInvoice->is_valided==true) {
                $this->productInvoice->is_valided = false;
            } else {
                $this->productInvoice->is_valided = true;
            }
            $this->productInvoice->update();
            $this->dispatch('productInvoiceRefreshedMainView');
            $this->dispatch('updated', ['message' => 'Action bien réalisée']);
        } catch (\Exception $exception) {
            $this->dispatch('error', ['message' => $exception->getMessage()]);
        }
    }



    public function mount(ProductInvoice $productInvoice){
        $this->productInvoice=$productInvoice;
    }
    public function render()
    {
        return view('livewire.application.product.invoice.list.list-items-invoice');
    }
}
