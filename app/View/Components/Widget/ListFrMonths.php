<?php

namespace App\View\Components\widget;

use Closure;
use App\Livewire\Helpers\Date\DateFormatHelper;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class ListFrMonths extends Component
{
    public array $listMonths=[];
    /**
     * Create a new component instance.
     */
    public function __construct()
    {
        $this->listMonths=DateFormatHelper::getFrMonths();
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.widget.list-fr-months');
    }
}
