<?php

namespace App\View\Components\Form;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class InputCheckBox extends Component
{
    public string $label,$color='',$text,$icon='',$idAndFor;
    /**
     * Create a new component instance.
     */
    public function __construct(
        string $label,
        string $text,
        string $color= 'danger',
        string $icon= "",
        string $idAndFor)
    {
        $this->label=$label;
        $this->color=$color;
        $this->text=$text;
        $this->icon=$icon;
        $this->idAndFor=$idAndFor;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.form.input-check-box');
    }
}
