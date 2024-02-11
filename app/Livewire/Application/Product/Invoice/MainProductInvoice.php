<?php

namespace App\Livewire\Application\Product\Invoice;

use App\Models\Hospital;
use App\Models\ProductInvoice;
use App\Repositories\Product\Get\GetProductInvoiceRepository;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class MainProductInvoice extends Component
{

    /**
     * listeners
     *Array of listeners
     * @var array
     */
    protected $listeners = [
        'productInvoice' => 'getProductInvoice',
        'productInvoiceToEdit' => 'getProductInvoiceToEdit',
        'productInvoiceRefreshedMainView' => '$refresh'
    ];
    public ?ProductInvoice $productInvoice=null;
    public bool $isEditing = false;

    public function newInvoice(){
        $this->isEditing=false;
        $this->productInvoice=null;
    }

    /**
     * Get ProductInvoice if ProductInvoiceListener is emitted
     * getOutpatient
     * @return void
     */
    public function getProductInvoice(): void
    {
        $this->productInvoice = ProductInvoice::latest()->first();
    }
    /**
     * Get productInvoice if productInvoiceToEditListener is emitted with edition mode
     * getOutpatientToEdit
     * @param  mixed $productInvoice
     * @return void
     */
    public function getProductInvoiceToEdit(?ProductInvoice $productInvoice): void
    {
        $this->productInvoice = $productInvoice;
        $this->isEditing = true;
        $this->dispatch('productInvoiceToFrom', $productInvoice);
    }

    /**
     * openNewProductInvoice
     *Open modal to create new Invoice
     * @return void
     */
    public function openNewProductInvoice(): void
    {
        $this->dispatch('open-form-product-invoice');
    }
    /**
     * openListListProductInvoice
     *Open modal to show list Invoices
     * @return void
     */
    public function openListListProductInvoice(): void
    {
        $this->dispatch('open-list-product-invoice-by-date-modal');
        $this->dispatch('refreshListInvoice');
    }

    public function mount(){
        $this->productInvoice = ProductInvoice::query()
                ->wheredate('created_at',Carbon::now())
                ->where('user_id',Auth::id())
                ->where('hospital_id',Hospital::DEFAULT_HOSPITAL())
                ->orderBy('created_at','DESC')
                ->first();
    }
    public function render()
    {
        return view('livewire.application.product.invoice.main-product-invoice',[
            'totalInvoice' => GetProductInvoiceRepository::getTotalInvoiceByDate(date('Y-m-d'))
        ]);
    }
}
