<?php

namespace App\Livewire\Application\Finance\Widget;

use App\Models\Currency;
use Livewire\Component;

class CurrencyWidget extends Component
{
    public string $currencyName;

    public function updatedCurrencyName($val): void
    {
        $this->dispatch('currencyName', $val);
    }
    public function render()
    {
        return view('livewire.application.finance.widget.currency-widget', [
            'currencies' => Currency::orderBy('name', 'ASC')->get()
        ]);
    }
}
