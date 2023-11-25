<?php

namespace App\Livewire\Application\Sheet\Form;

use App\Models\ConsultationComment;
use App\Models\ConsultationRequest;
use Livewire\Attributes\Rule;
use Livewire\Component;
use Mockery\Exception;

class NewConsultationComment extends Component
{
    protected $listeners=['consultationRequest'=>'getConsultationRequest'];
    public ?ConsultationRequest $consultationRequest;

    #[Rule('required|min:3|string',message: 'Champs est obligatoire SVP')]
    public $note = '';

    public function addNewDiagnostic(): void
    {
        $this->dispatch('open-diagnostic-items');
        $this->dispatch('consultationRequest',$this->consultationRequest);
    }
    public function store(){
        $fields= $this->validate();
        try {
            $fields['consultation_request_id']=$this->consultationRequest->id;
            $fields['body']=$this->note;
            ConsultationComment::create($fields);
            $this->dispatch('added', ['message' => 'Action bien réalisée']);
        }catch (Exception $exception){
            $this->dispatch('error', ['message' => $exception->getMessage()]);
        }
    }

    public function update(){
        $fields= $this->validate();
        try {
            $fields['body']=$this->note;
            $this->consultationRequest->consultationComment->update($fields);
            $this->dispatch('added', ['message' => 'Action bien réalisée']);
        }catch (Exception $exception){
            $this->dispatch('error', ['message' => $exception->getMessage()]);
        }
    }

    public function handlerSubmit(): void
    {
        if ($this->consultationRequest->consultationComment == null){
            $this->store();
        }else{
            $this->update();
        }
    }
    public function mount(ConsultationRequest $consultationRequest): void
    {
        $this->consultationRequest=$consultationRequest;
        if ($this->consultationRequest?->consultationComment != null){
            $this->note=$this->consultationRequest->consultationComment->body;
        }
;    }
    public function render()
    {
        return view('livewire.application.sheet.form.new-consultation-comment');
    }
}
