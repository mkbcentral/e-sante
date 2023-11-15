<?php

namespace App\Livewire\Application\Sheet\Form;

use App\Models\ConsultationRequest;
use App\Models\ConsultationSheet;
use App\Repositories\Rate\RateRepository;
use Livewire\Attributes\Rule;
use Livewire\Component;

class NewConsultationRequest extends Component
{
    protected $listeners=['consultationSheet'=>'getConsultationSheet'];
    public ?ConsultationSheet $consultationSheet;

    #[Rule('required|numeric',message: 'Type de consultation obligatoire')]
    public $sheet_id;

    public function getConsultationSheet(ConsultationSheet $consultationSheet): void
    {
        $this->consultationSheet=$consultationSheet;
    }
    public function store(): void
    {
        $this->validate();
        try {
            ConsultationRequest::create([
                'request_number'=>rand(10,100),
                'consultation_sheet_id'=>$this->consultationSheet->id,
                'consultation_id'=>$this->sheet_id,
                'rate_id'=>RateRepository::getCurrentRate()->id
            ]);
            $this->dispatch('close-request-form');
            $this->dispatch('added', ['message' => 'Action bien réalisée']);
        }catch (\Exception $ex){
            $this->dispatch('error', ['message' => $ex->getMessage()]);
        }
    }

    public function render()
    {
        return view('livewire.application.sheet.form.new-consultation-request');
    }
}
