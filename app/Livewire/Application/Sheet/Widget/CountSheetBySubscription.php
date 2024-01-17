<?php

namespace App\Livewire\Application\Sheet\Widget;

use App\Repositories\Sheet\Countig\CountConsultationSheetRepository;
use Livewire\Component;

class CountSheetBySubscription extends Component
{
    protected $listeners=[
        'subscriptionId'=>'getSubscriptionId',
        'refreshSheetCounter'=>'$refresh'
    ];
    public int $subscriptionId;

    /**
     * Get Subscription if listener emitted in parent view
     * @param int $subscriptionId
     * @return void
     */
    public function getSubscriptionId(int $subscriptionId): void
    {
        $this->subscriptionId=$subscriptionId;
    }

    /**
     * Mounted component
     * @param int $subscriptionId
     * @return void
     */
    public function mount(int $subscriptionId): void
    {
        $this->subscriptionId=$subscriptionId;
    }
    public function render()
    {
        return view('livewire.application.sheet.widget.count-sheet-by-subscription',[
            'sheet_counter'=>CountConsultationSheetRepository::countAllConsultationBySubscription($this->subscriptionId)
        ]);
    }
}
