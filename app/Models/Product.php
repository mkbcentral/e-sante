<?php

namespace App\Models;

use App\Repositories\Product\Get\GetProductRepository;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class Product extends Model
{
    use HasFactory;
    protected $fillable = [
        'butch_number',
        'initial_quantity',
        'name',
        'price',
        'expiration_date',
        'product_family_id',
        'product_category_id',
        'hospital_id',
        'is_specialty',
        'source_id',
        'is_trashed',
    ];

    protected $casts = [
        'expiration_date' => 'datetime'
    ];

    public function getExpirationDateAttribute($value): string
    {
        return Carbon::parse($value)->toFormattedDate();
    }
    /**
     * The stockServices that belong to the Product
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function stockServices(): BelongsToMany
    {
        return $this->belongsToMany(related: StockService::class)->withPivot('id', 'qty', 'is_trashed');
    }

    public function source(): BelongsTo
    {
        return $this->belongsTo(Source::class, 'source_id');
    }

    public function hospital(): BelongsTo
    {
        return $this->belongsTo(Hospital::class, 'hospital_id');
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


    public function productInvoices(): BelongsToMany
    {
        return $this->belongsToMany(ProductInvoice::class)->withPivot('id', 'qty');
    }

    /**
     * The consultationRequests that belong to the Product
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function consultationRequests(): BelongsToMany
    {
        return $this->belongsToMany(ConsultationRequest::class)->withPivot('id', 'qty', 'dosage');
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
        if (Auth::user()->roles->pluck('name')->contains('PHARMA') && Auth::user()->source_id == Source::GOLF_ID) {
            return $this->pharma_g_stk;
        } else if (Auth::user()->roles->pluck('name')->contains('PHARMA') && Auth::user()->source_id == Source::VILLE_ID) {
            return  $this->pharma_v_stk;
        } else if (Auth::user()->roles->pluck('name')->contains('DEPOSIT_PHARMA') && Auth::user()->source_id == Source::GOLF_ID) {
            return  $this->initial_quantity;
        }
    }
    /**
     * Sortie sur toutes les factures en cash périodiquement
     * Nous allons réinitiliser les  à partir du 14 juillet
     */
    public function getNumberProductInvoiceByPeriod(?string $date, ?string $startDate, ?string $endDate): int|float
    {
        return GetProductRepository::getNumberProductOutputOnProductInvoice(
            $this->id,
            $date,
            $startDate,
            $endDate
        );
    }

    /**
     * Sortie sur toutes les factures en cash
     * Nous allons réinitiliser les  à partir du 14 juillet
     */
    public function getNumberProductInvoice(): int|float
    {
        $startDate = Carbon::create(2024, 7, 14); //Retourner la 14;
        $date = Auth::user()?->stockService?->created_at;
        $date == null ? $startDate = date(format: 'Y-m-d') : $startDate = Carbon::create($date?->format('Y'), $date?->format('m'), $date->format('d'));
        return DB::table(table: 'product_product_invoice')
            ->join('product_invoices', 'product_invoices.id', 'product_product_invoice.product_invoice_id')
            ->where('product_product_invoice.product_id', $this->id)
            ->where('product_invoices.user_id', Auth::id())
            ->where('product_product_invoice.created_at', '>=', $startDate)
            ->sum('product_product_invoice.qty');
    }
    /**
     * Sortie sur les factures abonées et personels
     * Nous allons réinitiliser les  à partir du 14 juille
     */
    public function getNumberProducByConsultationRequest(): int|float
    {
        $startDate = Carbon::create(2024, 7, 14); //Retourner la 14;
        $date = Auth::user()?->stockService?->created_at;
        $date == null ? $startDate = date('Y-m-d') : $startDate = Carbon::create($date?->format('Y'), $date?->format('m'), $date->format('d'));
        return DB::table('consultation_request_product')
            ->where('created_by', Auth::id())
            ->where('product_id', $this->id)
            ->where('created_at', '>=', $startDate)
            ->sum('qty');
    }


    /**
     * Reoutner la quantité requisitionnée par service
     * @return int|float
     */
    public function getRequisitionByServiceProducts(): int|float
    {
        $startDate = Carbon::create(2024, 7, 14); //Retourner la 14;
        $date = Auth::user()?->stockService?->created_at;
        $date == null ? $startDate = date(format: 'Y-m-d') : $startDate = Carbon::create($date?->format('Y'), $date?->format('m'), $date->format('d'));
        return DB::table(table: 'product_requisition_products')
            ->join(
                'product_requisitions',
                'product_requisitions.id',
                operator: 'product_requisition_products.product_requisition_id'
            )
            ->where('product_requisition_products.product_id', operator: $this->id)
            ->where('product_requisitions.user_id', Auth::id())
            ->where('product_requisition_products.created_at', '>=', $startDate)
            ->sum('product_requisition_products.quantity');
    }
    /**
     * Approvisionnenet stock principale à partir du 15/07/2024
     * @return int|float
     */
    public function getNumberProductSupply(): int|float
    {
        $startDate = Carbon::create(2024, 7, 14); //Retourner la 14;
        return ProductSupply::query()
            ->join('product_supply_products', 'product_supply_products.product_supply_id', 'product_supplies.id')
            ->join('users', 'users.id', 'product_supplies.user_id')
            ->where('product_supply_products.product_id', $this->id)
            ->where('users.hospital_id', Hospital::DEFAULT_HOSPITAL())
            ->where('product_supplies.user_id', Auth::id())
            ->where('product_supplies.created_at', '>=', $startDate)
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
            ->whereIn('product_requisitions.source_id', [Source::GOLF_ID, Source::VILLE_ID])
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

    /**
     * Les sorties de la pharmacie et autres service
     * @return int|float
     */
    public function getOutputPharmancy(): int|float
    {

        return $this->getNumberProductInvoice() + $this->getNumberProducByConsultationRequest();
    }
    /**
     * Stock disponible de la pharmacie
     * (quan_ini+entree-sortie)
     * Summary of getStockPharma
     * @return int|float
     */
    public function getStockPharma(int $initQty): int|float
    {
        return ($initQty + $this->getInputPharmacy()) - $this->getOutputPharmancy();
    }

    /**
     * Quntité entrée en stock
     * @return int|float
     */
    public function getInputStock(): int|float
    {
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
        return ($this->getInitQuantity() + $this->getInputStock()) - $this->getOutputStock();
    }

    /**
     * Quantité total des entrées
     * @return float|int
     */
    public function getGlobalInput()
    {
        $qty = 0;
        if (Auth::user()->roles->pluck('name')->contains('PHARMA')) {
            $qty = $this->getInputPharmacy();
        } else if (Auth::user()->roles->pluck('name')->contains('DEPOSIT_PHARMA')) {
            $qty =  $this->getInputStock();
        }
        return $qty;
    }
    /**
     * Quantité total des sorties
     * @return float|int
     */
    public function getGlobalOutput()
    {
        $qty = 0;
        if (Auth::user()->roles->pluck('name')->contains('PHARMA')) {
            $qty = $this->getOutputPharmancy();
        } else if (Auth::user()->roles->pluck('name')->contains('DEPOSIT_PHARMA')) {
            $qty =  $this->getOutputStock();
        }
        return $qty;
    }
    /**
     * Stock total des produits
     * @param int $initQty
     * @return float|int
     */
    public function getGlobalStock(int $initQty = 0)
    {
        $qty = 0;
        if (Auth::user()->roles->pluck('name')->contains('PHARMA')) {
            $qty = $this->getStockPharma($initQty) <= 0 ? 0 : $this->getStockPharma($initQty);
        } else if (Auth::user()->roles->pluck('name')->contains('DEPOSIT_PHARMA')) {
            $qty =  $this->getStockDedpotQuantity() <= 0 ? 0 : $this->getStockDedpotQuantity();
        }
        return $qty;
    }
}
