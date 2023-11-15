<?php

namespace App\View\Components\Widget\Patient;

use App\Models\ConsultationSheet;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Collection;
use Illuminate\View\Component;

class CardPatientInfo extends Component
{
    //public ?ConsultationSheet $consultationSheet;
    /**
     * Create a new component instance.
     */
    public function __construct(public ?ConsultationSheet $sheet)

    {

    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.widget.patient.card-patient-info');
    }
}
