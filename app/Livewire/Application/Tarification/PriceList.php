<?php

namespace App\Livewire\Application\Tarification;

use App\Models\CategoryTarif;
use App\Models\Tarif;
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


    public function updatedQ($val): void
    {
        $this->dispatch('ketToSearch',$val);
    }

    public function sortTarif($value): void
    {
        if($value==$this->sortBy){
            $this->sortAsc=!$this->sortAsc;
        }
        $this->sortBy = $value;
    }

    public function render()
    {
        return view('livewire.application.tarification.price-list',[
            'tarifs'=>Tarif::join('category_tarifs','category_tarifs.id','tarifs.category_tarif_id')
                ->when($this->q, function ($query) {
                    return $query->where(function ($query) {
                        return $query->where('tarifs.name', 'like', '%' . $this->q . '%')
                            ->orWhere('tarifs.price_private', 'like', '%' . $this->q . '%')
                            ->orWhere('tarifs.subscriber_price', 'like', '%' . $this->q . '%');
                    });
                })->orderBy($this->sortBy, $this->sortAsc ? 'ASC' : 'DESC')
                ->where('tarifs.is_changed',false)
                ->select('tarifs.*','category_tarifs.name as category')
                ->where('tarifs.category_tarif_id','like','%'.$this->category.'%')
                ->where('category_tarifs.hospital_id',1)
            ->paginate(15)
        ]);
    }
}
