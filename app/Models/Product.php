<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Auth;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'butch_number', 'initial_quantity', 'name',
        'price', 'expiration_date', 'product_family_id', 'product_category_id',
        'hospital_id', 'is_specialty', 'source_id'
    ];

    protected $casts = [
        'expiration_date' => 'datetime'
    ];
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
    /***
     * get number of product by invoice
     */
    public function getNumberProductInvoice(): int|float
    {
        return ProductInvoice::query()
            ->join('product_product_invoice', 'product_product_invoice.product_invoice_id', 'product_invoices.id')
            ->where('product_product_invoice.product_id', $this->id)
            ->where('product_invoices.hospital_id', Hospital::DEFAULT_HOSPITAL())
            ->where('product_invoices.user_id', Auth::id())
            ->sum('product_product_invoice.qty');
    }
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

    public function getNumberProductSupply(): int|float
    {
        return ProductSupply::query()
            ->join('product_supply_products', 'product_supply_products.product_supply_id', 'product_supplies.id')
            ->join('users', 'users.id', 'product_supplies.user_id')
            ->where('product_supply_products.product_id', $this->id)
            ->where('users.hospital_id', Hospital::DEFAULT_HOSPITAL())
            ->where('product_supplies.user_id', Auth::id())
            ->sum('product_supply_products.quantity');
    }

    public function getAmountStockGlobal(): int|float
    {
        if (Auth::user()->roles->pluck('name')->contains('Pharma') && Auth::user()->source->name=="GOLF") {
            return ($this->initial_quantity + $this->getNumberProductSupply()) -
                ($this->getNumberProductInvoice() + $this->getNumberProducByConsultationRequest());
        } else {
            return ($this->getNumberProductSupply()) -
                ($this->getNumberProductInvoice() + $this->getNumberProducByConsultationRequest());
        }


    }

    public function getTotalInputsByService(): int|float
    {
        $quantity = 0;
        $inputs = ProductSupplyProduct::join('products', 'products.id', 'product_supply_products.product_id')
            ->join('product_supplies', 'product_supplies.id', 'product_supply_products.product_supply_id')
            ->join('users', 'users.id', 'product_supplies.user_id')
            ->select('product_supply_products.*', 'products.name as product_name')
            ->with(['product'])
            ->where('users.agent_service_id', Auth::user()->agentService->id)
            ->where('product_supply_products.product_id', $this->id)
            ->get();

        foreach ($inputs as $input) {
            $quantity += $input->quantity;
        }
        return $quantity;
    }



    public function TotalOutputsByService()
    {
    }
}
