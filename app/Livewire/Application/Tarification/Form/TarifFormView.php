<?php

namespace App\Livewire\Application\Tarification\Form;

use App\Models\Tarif;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Livewire\Attributes\Rule;
use Livewire\Component;

class TarifFormView extends Component
{
    protected $listeners = [
        'selectedIndex' => 'getSelectedIndex',
    ];
    public int $selectedIndex;

    #[Rule('required|min:3|string')]
    public $name;
    #[Rule('nullable|string')]
    public $abbreviation;
    #[Rule('required|numeric')]
    public $price_private;
    #[Rule('required|numeric')]
    public $subscriber_price;

    public Tarif $tarif;
    /**
     * Get Category Tarif id on selected id in parent view
     * @param int $selectedIndex
     * @return void
     */
    public function getSelectedIndex(int $selectedIndex): void
    {
        $this->selectedIndex = $selectedIndex;
    }

    /**
     * Save Tarif in DB
     * @return void
     */
    public  function store(): void
    {
        $fields = $this->validate();
        try {
            $fields['category_tarif_id'] = $this->selectedIndex;
            Tarif::create($fields);
            $this->dispatch('added', ['message' => 'Action bien réalisée']);
            $this->dispatch('listTarifRefreshed');
            $this->name = '';
            $this->price_private = '';
            $this->subscriber_price = '';
        } catch (\Exception $ex) {
            $this->dispatch('error', ['message' => $ex->getMessage()]);
        }
    }

    /**
     * Mounted Component
     * And get Tarif to pass in Editing Mode
     * @param int $selectedIndex
     * @param Tarif|null $tarif
     * @return void
     */
    public  function mount(int $selectedIndex, ?Tarif $tarif): void
    {
        $this->selectedIndex = $selectedIndex;
        $this->tarif = $tarif;
    }

    /**
     * Render component
     * @return Application|Factory|View|\Illuminate\Foundation\Application
     */
    public function render()
    {
        return view('livewire.application.tarification.form.tarif-form-view');
    }
}
