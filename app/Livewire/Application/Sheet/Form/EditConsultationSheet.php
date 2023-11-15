<?php

namespace App\Livewire\Application\Sheet\Form;

use App\Livewire\Forms\SheetForm;
use App\Models\ConsultationSheet;
use App\Models\Subscription;
use Livewire\Component;

class EditConsultationSheet extends Component
{
    protected $listeners=['sheetInfo'=>'getSheet','selectedIndex'=>'getSelectedIndex'];
    public SheetForm $form;
    public ConsultationSheet $sheet;
    public string $municipality_name='';
    public ?Subscription $subscription;

    public function getSelectedIndex(int $selectedIndex): void
    {
        $this->subscription=Subscription::find($selectedIndex);
    }

    public function getSheet(ConsultationSheet $sheet): void
    {
        $this->sheet=$sheet;
        //$this->form=$sheet->toArray();
        $this->form->number_sheet=$sheet->number_sheet;
        $this->form->name=$sheet->name;
        $this->form->date_of_birth=$sheet->date_of_birth;
        $this->form->gender=$sheet->gender;
        $this->form->phone=$sheet->phone;
        $this->form->other_phone=$sheet->other_phone;
        $this->form->email=$sheet->email;
        $this->form->blood_group=$sheet->blood_group;
        $this->form->municipality=$sheet->municipality;
        $this->form->street=$sheet->street;
        $this->form->street_number=$sheet->street_number;
        $this->form->registration_number=$sheet->registration_number;
        $this->form->rural_area=$sheet->rural_area;
        $this->form->type_patient_id=$sheet->type_patient_id;
        $this->form->agent_service_id=$sheet->agent_service_id;
        $this->form->subscription_id=$sheet->subscription_id;
    }

    public  function  update(): void
    {
        try {
            $this->sheet->update($this->form->all());
            $this->dispatch('close-form');
            $this->dispatch('updated', ['message' => 'Action bien réalisée']);
            $this->dispatch('listSheetRefreshed');
        }catch (\Exception $ex){
            $this->dispatch('error', ['message' => $ex->getMessage()]);
        }
    }
    public function render()
    {
        $this->municipality_name=$this->form->municipality;
        return view('livewire.application.sheet.form.edit-consultation-sheet');
    }
}
