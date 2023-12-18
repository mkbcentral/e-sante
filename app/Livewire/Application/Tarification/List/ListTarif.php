<?php

namespace App\Livewire\Application\Tarification\List;

use App\Models\Tarif;
use App\Repositories\Tarif\GetListTarifRepository;
use Livewire\Attributes\Rule;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

class ListTarif extends Component
{
    use WithPagination;
    protected $listeners = [
        'selectedIndex' => 'getSelectedIndex',
        'deleteTarifListener' => 'delete',
        'listTarifRefreshed' => '$refresh'
    ];
    public int $selectedIndex;
    public ?Tarif $tarif;
    public bool $isEditing = false;
    public int $idSelected = 0;

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

    /**
     * Get Category Tarif id on selected id in parent view
     * @param int $selectedIndex
     * @return void
     */
    public function getSelectedIndex(int $selectedIndex): void
    {
        $this->selectedIndex = $selectedIndex;
        $this->resetPage();
    }

    /**
     * Show delete Tarif dialog
     * @param Tarif $tarif
     * @return void
     */
    public function showDeleteDialog(Tarif $tarif): void
    {
        $this->tarif = $tarif;
        $this->dispatch('delete-tarif-dialog');
    }

    /**
     * Get Tarif to update
     * @param Tarif $tarif
     * @return void
     */
    public  function edit(Tarif $tarif): void
    {
        $this->isEditing = true;
        $this->tarif = $tarif;
        $this->idSelected = $tarif->id;
        $this->name = $tarif->name;
        $this->abbreviation = $tarif->abbreviation;
        $this->price_private = $tarif->price_private;
        $this->subscriber_price = $tarif->subscriber_price;
    }
    /**
     * Update tarif
     * @return void
     */
    public function update(): void
    {
        $fields = $this->validate();
        try {
            $this->tarif->update($fields);
            $this->isEditing = false;
            $this->idSelected = 0;
            $this->dispatch('updated', ['message' => 'Action bien réalisée']);
        } catch (\Exception $ex) {
            $this->dispatch('error', ['message' => $ex->getMessage()]);
        }
    }

    /**
     * Make deleted tarif to change is_changed value to true or false
     * Disable en enable state of tarif
     * @return void
     */
    public function delete(): void
    {
        try {
            $this->tarif->is_changed = true;
            $this->tarif->update();
            $this->dispatch('tarif-deleted', ['message' => "Tarif bien rétiré !"]);
        } catch (\Exception $ex) {
            $this->dispatch('error', ['message' => $ex->getMessage()]);
        }
    }

    /**
     * Sort tarif (Asc or Desc
     * @param $value
     * @return void
     */
    public function sortTarif($value): void
    {
        if ($value == $this->sortBy) {
            $this->sortAsc = !$this->sortAsc;
        }
        $this->sortBy = $value;
    }

    public  function mount(int $selectedIndex): void
    {
        $this->selectedIndex = $selectedIndex;
    }
    public function render()
    {
        return view('livewire.application.tarification.list.list-tarif', [
            'tarifs' => GetListTarifRepository::getListTarif(
                $this->q,
                $this->sortBy,
                $this->sortAsc,
                $this->selectedIndex,
                5
            )
        ]);
    }
}
