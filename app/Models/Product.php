<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Auth;
use PhpOffice\PhpSpreadsheet\Calculation\Statistical\Distributions\F;

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
     * Sortie sur les factures des privés hospitalisé, abonées et personels
     * Nous allons réinitiliser les  à partir du 14 juille
     */
    public function getNumberProducByConsultationRequest(): int|float
    {
        $currentDate = Carbon::now();
        $startDate = $currentDate->copy()->startOfMonth()->addDays(13); //Retourner la 14;
        //dd($startDate);
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
            ->whereDate('consultation_requests.created_at', '>=', $startDate)
            ->sum('consultation_request_product.qty');
    }

    /**
     * Retouner la quantité disponible d'un produit à la pharmacie
     * (QuantitIni+QuantiteReq) - '(SortieAmbu+SortieFactAbn+ortieFactHost)
     * @return  int|float
     */
    public function getInputPharmacy(): int|float
    {
        return ($this->getOutputFromRequisition());
    }

    public function getOutputPharmancy(): int|float
    {

        return $this->getNumberProductInvoice()+$this->getNumberProducByConsultationRequest();
    }

    public function getStockPharma(): int|float
    {
        return ($this->getInitQuantity() + $this->getInputPharmacy()) - $this->getOutputPharmancy();
    }

    /**
     * Reoutner la quantité requisitionnée par service
     * @return int|float
     */
    public function getOutputFromRequisition(): int|float
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
            ->get();
        foreach ($inputs as $input) {
            $quantity += $input->quantity;
        }
        return $quantity;
    }

    /*
    public function getNumberProductSupply(): int|float
    {
        return ProductSupply::query()
            ->join('product_supply_products', 'product_supply_products.product_supply_id', 'product_supplies.id')
            ->join('users', 'users.id', 'product_supplies.user_id')
            ->where('product_supply_products.product_id', $this->id)
            ->where('users.hospital_id', Hospital::DEFAULT_HOSPITAL())
            ->where('product_supplies.user_id', Auth::id())
            //->whereMonth('product_supplies.created_at', date('m'))
            ->where('product_supplies.is_valided', true)
            ->sum('product_supply_products.quantity');
    }
    /**
     * Sortie sur chaque requisition faite par le service


    /**
     * Sortie sur chaque requisition faite par le service à partir du mois de mars jusqu'à la fin de l'année

    public function getOutputRequisitionWithMarchToEndOfYear()
    {
        $quantity = 0;
        $startDate = date('Y') . '-04-01'; // March 1st of the current year
        $endDate = date('Y') . '-12-31'; // December 31st of the current year
        $inputs = ProductRequisitionProduct::query()
            ->join('products', 'products.id', 'product_requisition_products.product_id')
            ->join('product_requisitions', 'product_requisitions.id', 'product_requisition_products.product_requisition_id')
            ->select('product_requisition_products.*', 'products.name as product_name')
            ->with(['product'])
            ->where('product_requisition_products.product_id', $this->id)
            ->where('product_requisitions.is_valided', true)
            //->whereMonth('product_requisition_products.created_at', [$startDate, $endDate])
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

    public function getTotalOutputProducts(): int|float
    {
        $number = 0;
        if (Auth::user()->roles->pluck('name')->contains('Pharma')) {
            $number = $this->getNumberProductInvoice() + $this->getNumberProducByConsultationRequest();
        } elseif (Auth::user()->roles->pluck('name')->contains('Depot-Pharma')) {
            $number = $this->getOutputRequisitionWithMarchToEndOfYear();
        } else {
            $this->getNumberProducByConsultationRequest();
        }
        return $number;
    }
    /**
     * Stotck global

    public function getAmountStockGlobal(): int|float
    {
        return    $number = $this->getTotalInputProducts() - $this->getTotalOutputProducts();;
    }
    /*
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
    */
}
