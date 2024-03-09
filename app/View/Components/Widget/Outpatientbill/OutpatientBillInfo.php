<?php

namespace App\View\Components\Widget\Outpatientbill;

use App\Models\OutpatientBill;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class OutpatientBillInfo extends Component
{
    public OutpatientBill $outpatientBill;
    /**
     * Create a new component instance.
     */
    public function __construct(OutpatientBill $outpatientBill)
    {
        $this->outpatientBill=$outpatientBill;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.widget.outpatientbill.outpatient-bill-info');
    }
}
