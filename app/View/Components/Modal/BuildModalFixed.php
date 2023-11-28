<?php

namespace App\View\Components\Modal;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class BuildModalFixed extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(
        public string $idModal = '',
        public string $size = '',
        public string $headerLabel = '',
        public string $headerLabelIcon,
        public string $bg='bg-primary',
    ) {
        //
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.modal.build-modal-fixed');
    }
}
