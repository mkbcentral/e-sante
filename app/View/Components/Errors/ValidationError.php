<?php

namespace App\View\Components\Errors;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class ValidationError extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(public string $value)
    {
        //
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.errors.validation-error');
    }
}
