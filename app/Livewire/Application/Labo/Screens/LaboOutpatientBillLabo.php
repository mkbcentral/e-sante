<?php

namespace App\Livewire\Application\Labo\Screens;

use App\Models\OutpatientBill;
use Livewire\Attributes\Url;
use Livewire\Component;

class LaboOutpatientBillLabo extends Component
{
    protected $listeners = [
        'byDate' => 'getDate',
        'byMonth' => 'getMonth',
        'byPeriod' => 'getPeriod',
    ];
    #[Url(as: 'q')]
    public string $q = '';
    public bool $isByDate = true, $isByMonth = false, $isByPeriod = false;
    public $date_filter, $month_name, $start_date, $end_date;


    public function getDate($isByDate){
        $this->isByDate=$isByDate;
        $this->isByMonth=false;
        $this->isByPeriod = false;
    }
    public function getMonth($isByMonth)
    {
        $this->isByMonth = $isByMonth;
        $this->isByDate = false;
        $this->isByPeriod = false;
    }
    public function getPeriod($isByPeriod)
    {
        $this->isByPeriod = $isByPeriod;
        $this->isByDate = false;
        $this->isByMonth = false;
    }

    public function mount()
    {
        $this->date_filter=date('Y-m-d');
        $this->month_name = date('m');
    }
    public function render()
    {
        $outpatientBills=null;
        if ($this->isByDate==true) {
            $outpatientBills= OutpatientBill::query()
                ->whereDate('created_at', $this->date_filter)
                ->where('client_name','like', '%'.$this->q.'%')
                ->get();
        }else if ($this->isByMonth==true) {
            $outpatientBills= OutpatientBill::query()
                ->whereMonth('created_at', $this->date_filter)
                ->where('client_name','like', '%'.$this->q.'%')
                ->get();
        }else if ($this->isByPeriod==true) {
            $outpatientBills= OutpatientBill::query()
                ->whereBetween('created_at', [$this->start_date, $this->end_date])
                ->where('client_name','like', '%'.$this->q.'%')
                ->get();
        }
        return view('livewire.application.labo.screens.labo-outpatient-bill-labo',[
            'outpatientBills'=>$outpatientBills
        ]);
    }
}
