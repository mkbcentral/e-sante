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
        'butch_number',
        'initial_quantity',
        'pharma_g_stk',
        'pharma_v_stk',
        'pharma_klz_stk',
        'name',
        'price',
        'expiration_date',
        'product_family_id',
        'product_category_id',
        'hospital_id',
        'is_specialty',
        'source_id',
        'is_trashed',
        'created_by',
        'updated_by'
    ];

    protected $casts = [
        'expiration_date' => 'datetime'
    ];

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
     * Quantité initial
     * @return mixed
     */
    public function getInitQuantity()
    {
        if (Auth::user()->roles->pluck('name')->contains('Pharma') && Auth::user()->source_id == Source::GOLF_ID) {
            return $this->pharma_g_stk;
        } else if (Auth::user()->roles->pluck('name')->contains('Pharma') && Auth::user()->source_id == Source::VILLE_ID) {
            return  $this->pharma_v_stk;
        } else if (Auth::user()->roles->pluck('name')->contains('Depot-Pharma') && Auth::user()->source_id == Source::GOLF_ID) {
            return  $this->initial_quantity;
        }
    }

    /**
     * Sortie sur toutes les factures en cash
     * Nous allons réinitiliser les  à partir du 14 juillet
     */
    public function getNumberProductInvoice(): int|float
    {
        $currentDate = Carbon::now();
        $startDate = $currentDate->copy()->startOfMonth()->addDays(13); //Retourner la 14;
        return ProductInvoice::query()
            ->join('product_product_invoice', 'product_product_invoice.product_invoice_id', 'product_invoices.id')
            ->join('users', 'users.id', 'product_invoices.user_id')
            ->where('product_product_invoice.product_id', $this->id)
            ->where('product_invoices.hospital_id', Hospital::DEFAULT_HOSPITAL())
            ->where('product_invoices.user_id', Auth::id())
            ->where('users.source_id', Auth::user()->source->id)
            ->where('product_invoices.is_valided', true)
            ->whereDate('product_invoices.created_at', '>=', $startDate)
            ->sum('product_product_invoice.qty');
    }
    /**
     * Sortie sur les factures abonées et personels
     * Nous allons réinitiliser les  à partir du 14 juille
     */
    public function getNumberProducByConsultationRequest(): int|float
    {
        $currentDate = Carbon::now();
        $startDate = $currentDate->copy()->startOfMonth()->addDays(13); //Retourner la 14;
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
            ->where('consultation_requests.is_hospitalized', false)
            ->whereDate('consultation_requests.created_at', '>=', $startDate)
            ->sum('consultation_request_product.qty');
    }

    /**
     * Reoutner la quantité requisitionnée par service
     * @return int|float
     */
    public function getRequisitionByServiceProducts(): int|float
    {
        $quantity = 0;
        $inputs = ProductRequisitionProduct::query()
            ->join('products', 'products.id', 'product_requisition_products.product_id')
            ->join('product_requisitions', 'product_requisitions.id', 'product_requisition_products.product_requisition_id')
            ->where('product_requisitions.source_id', Auth::user()->source_id)
            ->where('product_requisitions.user_id', Auth::id())
            ->where('product_requisitions.agent_service_id', Auth::user()->agent_service_id)
            ->with(['product'])
            ->where('product_requisition_products.product_id', $this->id)
            ->where('product_requisitions.is_valided', true)
            ->get();
        foreach ($inputs as $input) {
            $quantity += $input->quantity;
        }
        return $quantity;
    }
    /**
     * Retouner la quantité disponible d'un produit à la pharmacie
     * (QuantitIni+QuantiteReq) - '(SortieAmbu+SortieFactAbn+ortieFactHost)
     * @return  int|float
     */
    public function getInputPharmacy(): int|float
    {
        return ($this->getRequisitionByServiceProducts());
    }

    public function getOutputPharmancy(): int|float
    {

        return $this->getNumberProductInvoice()+$this->getNumberProducByConsultationRequest();
    }
    /**
     * Stock disponible de la pharmacie
     * (quan_ini+entree-sortie)
     * Summary of getStockPharma
     * @return int|float
     */
    public function getStockPharma(): int|float
    {
        return ($this->getInitQuantity() + $this->getInputPharmacy()) - $this->getOutputPharmancy();
    }


    /**
     * Approvisionnenet stock principale à partir du 15/07/2024
     * @return int|float
     */
    public function getNumberProductSupply(): int|float
    {
        //$currentDate = Carbon::now();
        //$startDate = $currentDate->copy()->startOfMonth()->addDays(13); //Retourner la 14;
        return ProductSupply::query()
            ->join('product_supply_products', 'product_supply_products.product_supply_id', 'product_supplies.id')
            ->join('users', 'users.id', 'product_supplies.user_id')
            ->where('product_supply_products.product_id', $this->id)
            ->where('users.hospital_id', Hospital::DEFAULT_HOSPITAL())
            ->where('product_supplies.user_id', Auth::id())
            //->whereMonth('product_supplies.created_at', '>=', $startDate)
            ->where('product_supplies.is_valided', true)
            ->sum('product_supply_products.quantity');
    }

    /**
     * Reoutner la quantité requisitionnée pour tout les service
     * @return int|float
     */
    public function getRequisitioFoAllServicesProducts(): int|float
    {
        $quantity = 0;
        $inputs = ProductRequisitionProduct::query()
            ->join('products', 'products.id', 'product_requisition_products.product_id')
            ->join('product_requisitions', 'product_requisitions.id', 'product_requisition_products.product_requisition_id')
            ->whereIn('product_requisitions.source_id', [Source::GOLF_ID,Source::VILLE_ID])
            ->with(['product'])
            ->where('product_requisition_products.product_id', $this->id)
            ->where('product_requisitions.is_valided', true)
            ->get();
        foreach ($inputs as $input) {
            $quantity += $input->quantity;
        }
        return $quantity;
    }

    /**
     * Quntité entrée en stock
     * @return int|float
     */
    public function getInputStock():int|float{
        return ($this->getNumberProductSupply());
    }


    /**
     * Quantité sortie en stock
     * @return int|float
     */
    public function getOutputStock(): int|float
    {
        return $this->getRequisitioFoAllServicesProducts();
    }


    /**
     * Quantité disponible en stock principal
     * @return int|float
     */
    public function getStockDedpotQuantity(): int|float
    {
        return ($this->getInitQuantity() + $this->getInputStock())-$this->getOutputStock();
    }

    public function getGlobalInput()
    {
        if (Auth::user()->roles->pluck('name')->contains('Pharma')) {
            return $this->getInputPharmacy();
        } else if (Auth::user()->roles->pluck('name')->contains('Depot-Pharma')) {
            return  $this->getInputStock();
        }
    }

    public function getGlobalOutput()
    {
        if (Auth::user()->roles->pluck('name')->contains('Pharma')) {
            return $this->getOutputPharmancy();
        } else if (Auth::user()->roles->pluck('name')->contains('Depot-Pharma')) {
            return  $this->getOutputStock();
        }
    }



    public function getGlobalStock()
    {
        if (Auth::user()->roles->pluck('name')->contains('Pharma')) {
            return $this->getStockPharma();
        } else if (Auth::user()->roles->pluck('name')->contains('Depot-Pharma')) {
            return  $this->getStockDedpotQuantity();
        }
    }
}
