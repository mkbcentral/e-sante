<?php

namespace App\Livewire\Application\Dashboard\Finance;
use App\Models\Subscription;
use Livewire\Component;

class DashConsultationRequestFinance extends Component
{
    public $month, $year;
    public $dataChart=[],$labelsChart=[];

    public function updatedDateFilter()
    {
        $this->month = '';
    }

    public function mount()
    {
        $this->month = date('m');
        $this->year = date('Y');
        $this->dataChart=[25000,15000,7500,8500,5000];
        $this->labelsChart=['OCC','IFS','SEK','CNSS','SASE'];

    }

    public function render()
    {

        return view('livewire.application.dashboard.finance.dash-consultation-request-finance',[
            'subscriptions'=>Subscription::where('is_private',false)->where('is_personnel',false)->get(),
        ]);
    }
}
