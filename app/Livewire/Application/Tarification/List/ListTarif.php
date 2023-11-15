<?php

namespace App\Livewire\Application\Tarification\List;

use App\Models\Tarif;
use Livewire\Attributes\Rule;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

class ListTarif extends Component
{
    use WithPagination;
    protected $listeners=[
        'selectedIndex'=>'getSelectedIndex',
        'deleteTarifListener'=>'delete',
        'listTarifRefreshed'=>'$refresh'
    ];
    public int $selectedIndex;
    public ?Tarif $tarif;
    public bool $isEditing=false;
    public int $idSelected=0;

    #[Rule('required|min:3|string')]
    public $name;
    #[Rule('nullable|string')]
    public $abbreviation;
    #[Rule('required|numeric')]
    public $price_private;
    #[Rule('required|numeric')]
    public $subscriber_price;
    //
    #[Url(as: 'q')]
    public $q = '';
    #[Url(as: 'sortBy')]
    public $sortBy = 'name';
    #[Url(as: 'sortAsc')]
    public $sortAsc = true;

    public function getSelectedIndex(int $selectedIndex): void
    {
        $this->selectedIndex=$selectedIndex;
        $this->resetPage();
    }
    public function showDeleteDialog(Tarif $tarif): void
    {
        $this->tarif=$tarif;
        $this->dispatch('delete-tarif-dialog');
    }
    public  function edit(Tarif $tarif){
        $this->isEditing=true;
        $this->tarif=$tarif;
        $this->idSelected=$tarif->id;
        $this->name=$tarif->name;
        $this->abbreviation=$tarif->abbreviation;
        $this->price_private=$tarif->price_private;
        $this->subscriber_price=$tarif->subscriber_price;
    }

    public function update(): void
    {
       $fields= $this->validate();
        try {
            $this->tarif->update($fields);
            $this->isEditing=false;
            $this->idSelected=0;
            $this->dispatch('updated', ['message' => 'Action bien réalisée']);
        }catch (\Exception $ex){
            $this->dispatch('error', ['message' => $ex->getMessage()]);
        }
    }

    public function delete(): void
    {
        try {
            $this->tarif->is_changed=true;
            $this->tarif->update();
            $this->dispatch('tarif-deleted', ['message' => "Fiche de consultation bien rétiré !"]);
        }catch (\Exception $ex){
            $this->dispatch('error', ['message' => $ex->getMessage()]);
        }
    }
    public function sortTarif($value): void
    {
        if($value==$this->sortBy){
            $this->sortAsc=!$this->sortAsc;
        }
        $this->sortBy = $value;
    }

    public  function mount(int $selectedIndex): void
    {
        $this->selectedIndex=$selectedIndex;
    }
    public function render()
    {
        return view('livewire.application.tarification.list.list-tarif',[
            'tarifs'=>Tarif::join('category_tarifs','category_tarifs.id','tarifs.category_tarif_id')
            ->where('tarifs.category_tarif_id',$this->selectedIndex)
                ->when($this->q, function ($query) {
                    return $query->where(function ($query) {
                        return $query->where('tarifs.name', 'like', '%' . $this->q . '%')
                            ->orWhere('tarifs.price_private', 'like', '%' . $this->q . '%')
                            ->orWhere('tarifs.subscriber_price', 'like', '%' . $this->q . '%');
                    });
                })->orderBy($this->sortBy, $this->sortAsc ? 'ASC' : 'DESC')
                ->select('tarifs.*','category_tarifs.name as category')
                ->where('tarifs.is_changed',false)
                ->where('category_tarifs.hospital_id',1)
                ->paginate(5)
        ]);
    }
}
