<?php

namespace App\View\Components\Widget;

use App\Models\Consultation;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class ListConsultationWidget extends Component
{
    public $listConsultation;
    /**
     * Create a new component instance.
     */
    public function __construct()
    {
        $this->listConsultation=Consultation::where('hospital_id',1)->get();
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.widget.list-consultation-widget');
    }
}
