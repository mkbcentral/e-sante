<?php

namespace App\Livewire\Application\Labo\Screens;

use App\Livewire\Helpers\Query\MakeQueryBuilderHelper;
use App\Models\CategoryTarif;
use App\Models\OutpatientBill;
use Exception;
use Livewire\Component;

class ListItemsOutpatientLabo extends Component
{
    protected $listeners = [
        'listLaboOutpatientBillRefreshed' => '$refresh'
    ];

    public ?OutpatientBill $outpatientBill;
    public ?CategoryTarif $categroryTarif;
    public bool $isEditing = false;
    public $idTarif;
    public $result, $qty;
    public $tarifData;


    public function edit($id)
    {
        $this->idTarif = $id;
        $this->isEditing = true;
        $this->tarifData = MakeQueryBuilderHelper::getSingleData('outpatient_bill_tarif', 'id', $id);
        $this->qty = $this->tarifData->qty;
        $this->result = $this->tarifData->result;
    }

    public function update()
    {
        try {
            MakeQueryBuilderHelper::update('outpatient_bill_tarif', 'id', $this->idTarif, [
                'qty' => $this->qty,
                'result' => $this->result,
            ]);
            $this->dispatch('updated', ['message' => 'Action bien réalisée']);
            $this->isEditing = false;
            $this->tarifData = 0;
        } catch (Exception $ex) {
            $this->dispatch('error', ['message' => $ex->getMessage()]);
        }
    }

    public function delete($id)
    {
        try {
            MakeQueryBuilderHelper::delete('outpatient_bill_tarif', 'id', $id);
            $this->dispatch('error', ['message' => 'Action bien réalisée']);
        } catch (Exception $ex) {
            $this->dispatch('error', ['message' => $ex->getMessage()]);
        }
    }


    public function mount(?outpatientBill $outpatientBill)
    {
        $this->outpatientBill = $outpatientBill;
        $this->categroryTarif = CategoryTarif::find(1);
    }


    public function render()
    {
        return view('livewire.application.labo.screens.list-items-outpatient-labo');
    }
}
