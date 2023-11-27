<?php

namespace App\Livewire\Application\Sheet\Form;

use App\Models\ConsultationRequest;
use App\Models\Hospital;
use App\Models\MedicalOffice;
use App\Repositories\Sheet\Get\GetMedicalOfficeRepository;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Livewire\Attributes\Rule;
use Livewire\Component;
class AddViatlSign extends Component
{
    protected $listeners=['consultationRequest'=>'getConsultationRequest'];
    public ?ConsultationRequest $consultationRequest;
    public array $vitalSignForm=[];
    public int $selectedMedicalOfficeIndex=0;
    public bool $itemsVitalSignSend=false;

    /**
     * Creted new line in form  vital sign array
     * @return void
     */
    public function addNewVitalSignToForm(): void
    {
        $this->vitalSignForm[]=[
            'vital_sign_id'=>0,
            'value'=>0
        ];
    }
    /**
     * Remove line on form  vital signe array
     * @param $index
     * @return void
     */
    public function removeVitalSignToForm($index): void
    {
       if (count($this->vitalSignForm) > 1){
           unset($this->vitalSignForm[$index]);
           array_values($this->vitalSignForm);
       }
    }
    /**
     * Save items vital sign in DB after completed
     * @return void
     */
    public function addVitalSignItems(): void
    {
        try {
            foreach ($this->vitalSignForm as $item){
                //Check in array data is empty to retun a error message
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
            //Reset form array values after saving completed successfully
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
    /**
     * Select a Medical Office to affect patient to consult
     * @param MedicalOffice $medicalOffice
     * @return void
     */
    public function selectedMedicalOffice(MedicalOffice $medicalOffice): void
    {
        $this->selectedMedicalOfficeIndex=$medicalOffice->id;
    }
    /**
     * Send ConsultationRequest to Medical Office for consulting
     * @return void
     */
    public function sendConsultationToDoctor(): void
    {
        try {
            //Check in Medical Office is selected
            if($this->selectedMedicalOfficeIndex==0){
                $this->dispatch('error', ['message' => 'Selection un médecin SVP !']);
            }else{
                $this->consultationRequest->medicalOffices()->attach($this->selectedMedicalOfficeIndex);
                $this->dispatch('added', ['message' => 'Action bien réalisée']);
            }
        }catch (\Exception $exception){}
    }
    /**
     * Mounted Component
     * Set default values on vatal signs arry
     * @return void
     */
    public function mount(){
        $this->vitalSignForm=[
            [
                'vital_sign_id'=>0,
                'value'=>0
            ]
        ];
    }
    /**
     * Execute this functon to get ConsultationRequest select in parent view
     * @param ConsultationRequest $consultationRequest
     * @return void
     */
    public function getConsultationRequest(ConsultationRequest $consultationRequest): void
    {
        $this->consultationRequest=$consultationRequest;
    }
    /**
     * Render view
     * @return Application|Factory|View|\Illuminate\Foundation\Application
     */
    public function render()
    {
        return view('livewire.application.sheet.form.add-viatl-sign',[
            'medicalOffices'=>GetMedicalOfficeRepository::getMedicalOfficeList()
        ]);
    }
}
