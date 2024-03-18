<div wire:ignore.self>
    @if (Auth::user()->roles->pluck('name')->contains('Ag') || Auth::user()->roles->pluck('name')->contains('Admin'))
        <div class="bg-navy p-1 rounded-lg pr-2" wire:ignore.self>
            <h3 wire:loading.class="d-none"><i class="fas fa-coins ml-2"></i>
                <span class="money_format">CDF: {{ app_format_number($total_cdf, 1) }}</span> |
                <span class="money_format">USD: {{ app_format_number($total_usd, 1) }}</span>
            </h3>
        </div>
    @elseif(Auth::user()->roles->pluck('name')->contains('Pharma'))
        <div class="bg-navy p-1 rounded-lg pr-2" wire:ignore.self>
            <h3 wire:loading.class="d-none"><i class="fas fa-coins ml-2"></i>
                <span class="money_format">CDF:
                    {{ app_format_number($total_product_amount_cdf, 1) }}</span>
                |
                <span class="money_format">USD:
                    {{ app_format_number($total_product_amount_usd, 1) }}</span>

            </h3>
        </div>
    @endif
</div>
