<?php

namespace App\Livewire\Application\Labo;

use App\Livewire\Helpers\Date\DateFormatHelper;
use App\Models\Tarif;
use Livewire\Component;

class LaboMonthlyReleases extends Component
{
    public string $month_name, $year;

    public function mount()
    {
        $this->month_name = date('m');
        $this->year = date('Y');
    }
    public function render()
    {
        return view('livewire.application.labo.labo-monthly-releases', [
            'tarifs' => Tarif::query()->where('category_tarif_id', 1)
                ->orderBy('name', 'asc')
                ->get(),
            'days' => DateFormatHelper::getListDateForMonth($this->month_name, $this->year)
        ]);
    }
}
