<?php

namespace App\Livewire\Application\Product\Requisition\List;

use App\Models\AgentService;
use Livewire\Component;

class ListAmountRequistionByService extends Component
{
    public function render()
    {
        return view('livewire.application.product.requisition.list.list-amount-requistion-by-service',[
            'agentServices'=>AgentService::all()
        ]);
    }
}
