<?php

namespace App\View\Components\Widget;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class LoadingCircumarSm extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(public string $action='')
    {
        //
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.widget.loading-circumar-sm');
    }
}
