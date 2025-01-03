<?php

namespace App\Livewire\Application\Dashboard\Product;

use App\Repositories\Product\Get\GetProductInvoiceRepository;
use Livewire\Component;

class DashInvoiceProduct extends Component
{
    public $date = '', $month, $year;

    protected $listeners = [
        'updatedDateData' => 'getDate',
        'updatedMonthData' => 'getMonth',
        'updatedYearData' => 'getYear',
    ];
    public function getDate(string $date)
    {
        $this->date = $date;
        $this->month = '';
    }
    public function getMonth($month)
    {
        $this->month = $month;
        $this->date = '';
    }
    public function getYear($year)
    {
        $this->year = $year;
    }

    public function mount(String $date, $month, $year)
    {
        $this->date = $date;
        $this->month = $month;
        $this->year = $year;
    }
    public function render()
    {
        return view('livewire.application.dashboard.product.dash-invoice-product', [

            'total'
            => $this->month == '' ? GetProductInvoiceRepository::getTotalInvoiceByDate($this->date) :
                GetProductInvoiceRepository::getTotalInvoiceByMonth($this->month, $this->year),
        ]);
    }
}
