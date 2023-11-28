<?php

namespace App\View\Components\Navigation;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class BreadCrumb extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(public string $icon='',public string $label='',public string $color='text-primary')
    {
        //
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.navigation.bread-crumb');
    }
}
