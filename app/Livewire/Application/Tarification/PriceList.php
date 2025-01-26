<?php

namespace App\Livewire\Application\Tarification;

use App\Repositories\Tarif\GetListTarifRepository;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

class PriceList extends Component
{
    use WithPagination;
    #[Url(as: 'category')]
    public string $category = '';
    #[Url(as: 'q')]
    public string $q = '';
    #[Url(as: 'sortBy')]
    public $sortBy = 'name';
    #[Url(as: 'sortAsc')]
    public $sortAsc = true;
    public $type_data = 'all';

    public array $rows = [
        ['label' => 'Tout', 'value' => 'all'],
        ['label' => 'Privé', 'value' => 'private'],
        ['label' => 'Abonné', 'value' => 'subscriber'],
    ];


    /**
     * Pass key to search when ketToSearch listener emitted
     * Change state of Q property
     * @param $val
     * @return void
     */
    public function updatedQ($val): void
    {
        $this->dispatch('ketToSearch', $val);
    }

    /**
     * Sort Tarif
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

    /**
     * Render component
     * @return Application|Factory|View|\Illuminate\Foundation\Application
     */

    public function mount(): void {}
    public function render()
    {
        return view('livewire.application.tarification.price-list', [
            'tarifs' => GetListTarifRepository::getListTarif(
                $this->q,
                $this->sortBy,
                $this->sortAsc,
                $this->category,
                15
            )
        ]);
    }
}
