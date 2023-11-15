<?php

namespace App\Livewire\Application\Sheet\Form;

use App\Models\ConsultationRequest;
use App\Models\MedicalOffice;
use Livewire\Attributes\Rule;
use Livewire\Component;

class AddViatlSign extends Component
{
    protected $listeners=['consultationRequest'=>'getConsultationRequest'];
    public ?ConsultationRequest $consultationRequest;
    public array $vitalSignForm=[];
    public int $selectedMedicalOfficeIndex=0;
    public bool $itemsVitalSignSend=false;

    public function addNewVitalSignToForm(): void
    {
        $this->vitalSignForm[]=[
            'vital_sign_id'=>0,
            'value'=>0
        ];
    }
    public function removeVitalSignToForm($index): void
    {
       if (count($this->vitalSignForm) > 1){
           unset($this->vitalSignForm[$index]);
           array_values($this->vitalSignForm);
       }
    }

    public function addVitalSignItems(): void
    {
        try {
            foreach ($this->vitalSignForm as $item){
                if($item['vital_sign_id']==0 && $item['value']==0 ){
                    $this->dispatch('error', ['message' => 'Valeur saisie invalide']);
                }else{
                    $this->consultationRequest->vitalSigns()->attach(
                        $item['vital_sign_id'],['value' => $item['value']]
                    );
                    $this->dispatch('added', ['message' => 'Action bien réalisée']);
                }
            }
            $this->itemsVitalSignSend=true;
            $this->vitalSignForm=[
                [
                    'vital_sign_id'=>0,
                    'value'=>0
                ]
            ];
        }catch (\Exception $exception){
            $this->dispatch('error', ['message' => 'Une erreur se produite']);
        }

    }

    public function selectedMedicalOffice(MedicalOffice $medicalOffice): void
    {
        $this->selectedMedicalOfficeIndex=$medicalOffice->id;
    }

    public function sendConsultationToDoctor(): void
    {
        try {
            if($this->selectedMedicalOfficeIndex==0){
                $this->dispatch('error', ['message' => 'Selection un médecin SVP !']);
            }else{
                $this->consultationRequest->medicalOffices()->attach($this->selectedMedicalOfficeIndex);
                $this->dispatch('added', ['message' => 'Action bien réalisée']);
            }
        }catch (\Exception $exception){}

    }

    public function mount(){
        $this->vitalSignForm=[
            [
                'vital_sign_id'=>0,
                'value'=>0
            ]
        ];
    }

    public function getConsultationRequest(ConsultationRequest $consultationRequest): void
    {
        $this->consultationRequest=$consultationRequest;
    }
    public function render()
    {
        return view('livewire.application.sheet.form.add-viatl-sign',[
            'medicalOffices'=>MedicalOffice::where('medical_offices.hospital_id',1)->get()
        ]);
    }
}
