<?php

namespace App\Livewire\Application\Sheet\Widget;

use App\Models\ConsultationRequest;
use App\Models\ConsultationRequestNersing;
use App\Models\Currency;
use Livewire\Attributes\Rule;
use Livewire\Component;

class ConsultationRequestNursingWidget extends Component
{

    protected $listeners = [
        'consultationRequestNursingItems' => 'getConsultationRequest'
    ];
    public function getConsultationRequest(?ConsultationRequest $consultationRequest)
    {
        $this->consultationRequest = $consultationRequest;
    }

    public ?ConsultationRequest $consultationRequest;
    public ?ConsultationRequestNersing $consultationRequestNursing;
    public string $currencyName = Currency::DEFAULT_CURRENCY;
    public int $idSelected = 0;
    public bool $isEditing = false;
    #[Rule('required', message: 'Nombre obligatoire', onUpdate: false)]
    #[Rule('numeric', message: 'Nombre format numerique invalide', onUpdate: false)]
    public $numberToEdit;
    #[Rule('required', message: 'Description', onUpdate: false)]
    public $nameToEdit;
    #[Rule('required', message: 'Prix obligatoire', onUpdate: false)]
    #[Rule('numeric', message: 'Prix format numerique invalide', onUpdate: false)]
    public $priceToEdit;


    public function getCurrencyName(string $currency)
    {
        $this->currencyName = $currency;
    }

    public function edit($id, $numberToEdit)
    {
        $this->isEditing = true;
        $this->numberToEdit = $numberToEdit;
        $this->idSelected = $id;
        $this->consultationRequestNursing = ConsultationRequestNersing::find($id);
        $this->nameToEdit = $this->consultationRequestNursing->name;
        $this->priceToEdit = $this->consultationRequestNursing->amount;
    }

    public function update()
    {
        $this->validate();
        try {
            $this->consultationRequestNursing->name = $this->nameToEdit;
            $this->consultationRequestNursing->number = $this->numberToEdit;
            $this->consultationRequestNursing->amount = $this->priceToEdit;
            $this->consultationRequestNursing->update();
            $this->idSelected = 0;
            $this->isEditing = false;
            $this->dispatch('updated', ['message' => 'Action bien réalisée']);
            $this->dispatch('listSheetRefreshed');
            $this->dispatch('consultationRequestItemsTarif', $this->consultationRequest);
            $this->dispatch('consultationRequestProductItems', $this->consultationRequest);
            $this->dispatch('refreshDetail');
        } catch (\Exception $exception) {
            $this->dispatch('error', ['message' => $exception->getMessage()]);
        }
    }

    public function delete(ConsultationRequestNersing $consultationRequestNersing)
    {
        try {
            $consultationRequestNersing->delete();
            $this->dispatch('refreshDetail');;
            $this->dispatch('updated', ['message' => 'Action bien réalisée']);
        } catch (\Exception $exception) {
            $this->dispatch('error', ['message' => $exception->getMessage()]);
        }
    }


    public function mount(ConsultationRequest $consultationRequest)
    {
        $this->consultationRequest = $consultationRequest;

    }
    public function render()
    {
        return view('livewire.application.sheet.widget.consultation-request-nursing-widget');
    }
}
