<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Auth;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'butch_number', 'initial_quantity', 'name',
        'price', 'expiration_date', 'product_family_id', 'product_category_id',
        'hospital_id', 'is_specialty', 'source_id', 'is_trashed', 'created_by', 'updated_by'
    ];

    protected $casts = [
        'expiration_date' => 'datetime'
    ];

    public function getInitialQuantityAttribute($value): int
    {
        $number = 0;
        if (Auth::user()->roles->pluck('name')->contains('Pharma')&& Auth::user()->source->name == Source::GOLF ){
            $number = $value;
        } else {
            $number =  0;
        }
        return $number;
    }

    public function source(): BelongsTo
    {
        return $this->belongsTo(Source::class);
    }

    public function hospital(): BelongsTo
    {
        return $this->belongsTo(Hospital::class);
    }

    public function productFamily(): BelongsTo
    {
        return $this->belongsTo(ProductFamily::class, 'product_family_id');
    }

    /**
     * Get the productCategory that owns the Product
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function productCategory(): BelongsTo
    {
        return $this->belongsTo(ProductCategory::class, 'product_category_id');
    }
    public function getExpirationDateAttribute($value): string
    {
        return Carbon::parse($value)->toFormattedDate();
    }

    public function productInvoices(): BelongsToMany
    {
        return $this->belongsToMany(ProductInvoice::class)->withPivot('id', 'qty');
    }

    /**
     * Get all of the productSupplyProducts for the Product
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function productSupplyProducts(): HasMany
    {
        return $this->hasMany(productSupplyProduct::class);
    }

    /**
     * The productPurcharses that belong to the Product
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function productPurcharses(): BelongsToMany
    {
        return $this->belongsToMany(ProductPurchase::class)->withPivot(['id', 'quantity_stock', 'quantity_to_order']);
    }
    /**
     * Get all of the productRequistionProducts for the Product
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function productRequistionProducts(): HasMany
    {
        return $this->hasMany(ProductRequisitionProduct::class);
    }
    /**
     * Sortie sur toutes les factures en cash
     */
    public function getNumberProductInvoice(): int|float
    {
        return ProductInvoice::query()
            ->join('product_product_invoice', 'product_product_invoice.product_invoice_id', 'product_invoices.id')
            ->join('users', 'users.id', 'product_invoices.user_id')
            ->where('product_product_invoice.product_id', $this->id)
            ->where('product_invoices.hospital_id', Hospital::DEFAULT_HOSPITAL())
            ->where('product_invoices.user_id', Auth::id())
            ->where('users.source_id', Auth::user()->source->id)
            ->where('is_valided', true)
            ->sum('product_product_invoice.qty');
    }
    /**
     * Sortie sur les factures des privés hospitalisé, abonées et personels
     */
    public function getNumberProducByConsultationRequest(): int|float
    {
        return ConsultationRequest::query()
            ->join(
                'consultation_request_product',
                'consultation_request_product.consultation_request_id',
                'consultation_requests.id'
            )
            ->join(
                'consultation_sheets',
                'consultation_sheets.id',
                'consultation_requests.consultation_sheet_id'
            )
            ->where('consultation_request_product.product_id', $this->id)
            ->where('consultation_sheets.hospital_id', Hospital::DEFAULT_HOSPITAL())
            ->where('consultation_sheets.source_id', Source::DEFAULT_SOURCE())
            ->where('consultation_request_product.created_by', Auth::id())
            ->sum('consultation_request_product.qty');
    }
    /**
     * get number of product by supply
     */
    public function getNumberProductSupply(): int|float
    {
        return ProductSupply::query()
            ->join('product_supply_products', 'product_supply_products.product_supply_id', 'product_supplies.id')
            ->join('users', 'users.id', 'product_supplies.user_id')
            ->where('product_supply_products.product_id', $this->id)
            ->where('users.hospital_id', Hospital::DEFAULT_HOSPITAL())
            ->where('product_supplies.user_id', Auth::id())
            ->where('product_supplies.is_valided', true)
            ->sum('product_supply_products.quantity');
    }
    /**
     * Sortie sur chaque requisition faite par le service
     */
    public function getOutputFormRequisition(): int|float
    {
        $quantity = 0;
        $inputs = ProductRequisitionProduct::query()
            ->join('products', 'products.id', 'product_requisition_products.product_id')
            ->join('product_requisitions', 'product_requisitions.id', 'product_requisition_products.product_requisition_id')
            ->with(['product'])
            ->where('product_requisition_products.product_id', $this->id)
            ->get();

        foreach ($inputs as $input) {
            $quantity += $input->quantity;
        }
        return $quantity;
    }

    public function getOutputFormRequisitionByService(): int|float
    {
        $quantity = 0;
        $inputs = ProductRequisitionProduct::query()
            ->join('products', 'products.id', 'product_requisition_products.product_id')
            ->join('product_requisitions', 'product_requisitions.id', 'product_requisition_products.product_requisition_id')
            ->select('product_requisition_products.*', 'products.name as product_name')
            ->with(['product'])
            ->where('product_requisition_products.product_id', $this->id)
            ->where('product_requisitions.user_id', Auth::id())
            ->where('product_requisitions.is_valided', true)
            ->get();

        foreach ($inputs as $input) {
            $quantity += $input->quantity;
        }
        return $quantity;
    }

    public function getTotalInputProducts(): int|float
    {
        $number = 0;
        if (Auth::user()->roles->pluck('name')->contains('Pharma')) {
            $number =  $this->initial_quantity + $this->getOutputFormRequisitionByService();
        } elseif (Auth::user()->roles->pluck('name')->contains('Depot-Pharma')) {
            $number =   $this->getNumberProductSupply();
        } else {
            $this->getOutputFormRequisitionByService();
        }
        return $number;
    }
    /**
     * get total output products
     */
    public function getTotalOutputProducts(): int|float
    {
        $number = 0;
        if (Auth::user()->roles->pluck('name')->contains('Pharma')) {
            $number = $this->getNumberProductInvoice() + $this->getNumberProducByConsultationRequest();
        } elseif (Auth::user()->roles->pluck('name')->contains('Depot-Pharma')) {
            $number = $this->getOutputFormRequisition();
        } else {
            $this->getNumberProducByConsultationRequest();
        }
        return $number;
    }
    /**
     * Stotck global
     */
    public function getAmountStockGlobal(): int|float
    {
        return    $number = $this->getTotalInputProducts() - $this->getTotalOutputProducts();;
    }
    /**
     * get product stock status
     */
    public function getProductStockStatus(): string
    {
        $status = '';
        if ($this->productCategory?->name == "COMPRIME") {
            if ($this->getAmountStockGlobal() <= 30) {
                $status = 'bg-danger';
            }
        } else if ($this->productCategory?->name == "SIROP") {
            if ($this->getAmountStockGlobal() <= 10) {
                $status = 'bg-danger';
            }
        } else if ($this->productCategory?->name == "INJECTABLE") {
            if ($this->getAmountStockGlobal() <= 20) {
                $status = 'bg-danger';
            }
        } else if (
            $this->productCategory?->name == "LIQUIDE" ||
            $this->productCategory?->name == "PERFUSION" ||
            $this->productCategory?->name == "INFUSION"
        ) {
            if ($this->getAmountStockGlobal() <= 10) {
                $status = 'bg-danger';
            }
        } else {
            if ($this->getAmountStockGlobal() <= 5) {
                $status = 'bg-danger';
            }
        }
        return $status;
    }
}
