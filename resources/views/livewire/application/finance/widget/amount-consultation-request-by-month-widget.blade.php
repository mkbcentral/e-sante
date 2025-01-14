<div wire:ignore.self>
   <div class="bg-navy p-1 rounded-lg pr-2" wire:ignore.self>
            <h3 wire:loading.class="d-none"><i class="fas fa-coins ml-2"></i>
                <span class="money_format">CDF: {{ app_format_number($total_cdf, 1) }}</span> |
                <span class="money_format">USD: {{ app_format_number($total_usd, 1) }}</span>
            </h3>
        </div>
</div>
