<?php

namespace App\View\Components\Navigation;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class BreadCrumbItem extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(public string $link='',public string $label='',public bool $isLinked=false)
    {
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.navigation.bread-crumb-item');
    }
}
