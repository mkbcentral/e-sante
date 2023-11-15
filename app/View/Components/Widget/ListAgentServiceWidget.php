<?php

namespace App\View\Components\Widget;

use App\Models\AgentService;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Collection;
use Illuminate\View\Component;

class ListAgentServiceWidget extends Component
{
    public ?Collection $listServices;
    /**
     * Create a new component instance.
     */
    public function __construct()
    {
        $this->listServices=AgentService::where('hospital_id',1)
            ->get();
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.widget.list-agent-service-widget');
    }
}
