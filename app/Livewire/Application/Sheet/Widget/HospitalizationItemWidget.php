<?php

namespace App\Livewire\Application\Sheet\Widget;

use App\Models\ConsultationRequest;
use App\Models\ConsultationRequestHospitalization;
use App\Models\Currency;
use Livewire\Attributes\Rule;
use Livewire\Component;

class HospitalizationItemWidget extends Component
{
    protected $listeners = ['currencyName' => 'getCurrencyName'];
    #[Rule('required', message: 'Nombre jour obligation', onUpdate: false)]
    #[Rule('numeric', message: 'Nombre de jour format numerique', onUpdate: false)]
    public $numberOfDay;
    #[Rule('required', message: 'Chambre obligation', onUpdate: false)]
    public $hospitalization_room_id;

    public ?ConsultationRequest $consultationRequest;
    public int $idSelected = 0;
    public bool $isEditing = false;
    public ?ConsultationRequestHospitalization $consultationRequestHospitalization;
    public string $currencyName = Currency::DEFAULT_CURRENCY;

    public function getCurrencyName(string $currency)
    {
        $this->currencyName = $currency;
    }
    public function edit($id, $numberOfDay)
    {
        $this->isEditing = true;
        $this->numberOfDay = $numberOfDay;
        $this->idSelected = $id;
        $this->consultationRequestHospitalization = ConsultationRequestHospitalization::find($id);
        $this->hospitalization_room_id = $this->consultationRequestHospitalization->hospitalizationRoom->id;
    }

    public function update()
    {
        $this->validate();
        try {
            $this->consultationRequestHospitalization->hospitalization_room_id = $this->hospitalization_room_id;
            $this->consultationRequestHospitalization->number_of_day = $this->numberOfDay;
            $this->consultationRequestHospitalization->update();
            $this->isEditing = false;
            $this->idSelected = 0;
            $this->dispatch('updated', ['message' => 'Action bien réalisée']);
            $this->dispatch('listSheetRefreshed');
            $this->dispatch('refreshDetail');
        } catch (\Exception $exception) {
            $this->dispatch('error', ['message' => $exception->getMessage()]);
        }
    }
    public function delete(ConsultationRequestHospitalization $consultationRequestHospitalization)
    {
        try {
            $consultationRequestHospitalization->delete();
            $this->dispatch('refreshDetail');;
            $this->dispatch('updated', ['message' => 'Action bien réalisée']);
        } catch (\Exception $exception) {
            $this->dispatch('error', ['message' => $exception->getMessage()]);
        }
    }
    public function mount(?ConsultationRequest $consultationRequest)
    {
        $this->consultationRequest = $consultationRequest;
    }
    public function render()
    {
        return view('livewire.application.sheet.widget.hospitalization-item-widget');
    }
}
