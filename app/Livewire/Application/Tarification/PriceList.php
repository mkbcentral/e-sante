<?php

namespace App\Livewire\Application\Tarification;

use App\Repositories\Tarif\GetListTarifRepository;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Livewire\Attributes\Url;
use Livewire\Component;

class PriceList extends Component
{
    #[Url(as: 'category')]
    public string $category='';
    #[Url(as: 'q')]
    public string $q='';
    #[Url(as: 'sortBy')]
    public $sortBy = 'name';
    #[Url(as: 'sortAsc')]
    public $sortAsc = true;


    /**
     * Pass key to search when ketToSearch listener emitted
     * Change state of Q property
     * @param $val
     * @return void
     */
    public function updatedQ($val): void
    {
        $this->dispatch('ketToSearch',$val);
    }

    /**
     * Sort Tarif
     * @param $value
     * @return void
     */
    public function sortTarif($value): void
    {
        if($value==$this->sortBy){
            $this->sortAsc=!$this->sortAsc;
        }
        $this->sortBy = $value;
    }

    /**
     * Render component
     * @return Application|Factory|View|\Illuminate\Foundation\Application
     */
    public function render()
    {
        return view('livewire.application.tarification.price-list',[
            'tarifs'=>GetListTarifRepository::getListTarif(
                $this->q,
                $this->sortBy,
                $this->sortAsc,
                $this->category,
                15
            )
        ]);
    }
}
