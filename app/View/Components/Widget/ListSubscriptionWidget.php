<?php

namespace App\View\Components\Widget;

use App\Models\Hospital;
use App\Models\Subscription;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Collection;
use Illuminate\View\Component;

class ListSubscriptionWidget extends Component
{
    public Collection $listSubscription;
    /**
     * Create a new component instance.
     */
    public function __construct()
    {
        $this->listSubscription=Subscription::orderBy('id','ASC')
            ->where('hospital_id',Hospital::DEFAULT_HOSPITAL())
            ->get();
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.widget.list-subscription-widget');
    }
}
