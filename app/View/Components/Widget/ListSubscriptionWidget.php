<?php

namespace App\View\Components\Widget;

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
        $this->listSubscription=Subscription::orderBy('name','ASC')
            ->where('hospital_id',1)
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
