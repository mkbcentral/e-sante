<?php

namespace App\Livewire\Application\Finance\Billing\Form\Widget;

use App\Models\Currency;
use Livewire\Component;

class CurrencyModeSwitcher extends Component
{
    public string $currencyName = Currency::DEFAULT_CURRENCY;
    public bool $isUSD = false;

    public function updatedCurrencyMode()
    {
        if ($this->isUSD) {
            $this->currencyName = 'USD';
        } else {
            $this->currencyName = 'CDF';
        }
    }
    public function render()
    {
        return view('livewire.application.finance.billing.form.widget.currency-mode-switcher');
    }
}
