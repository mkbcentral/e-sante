<?php

namespace App\Livewire\Application\Sheet\Form;

use App\Models\ConsultationComment;
use App\Models\ConsultationRequest;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Livewire\Attributes\Rule;
use Livewire\Component;
use Mockery\Exception;

class NewConsultationComment extends Component
{
    protected $listeners = ['consultationRequest' => 'getConsultationRequest'];
    public ?ConsultationRequest $consultationRequest;

    #[Rule('required|min:3|string', message: 'Champs est obligatoire SVP')]
    public $note = '';

    /**
     * Open modal To add diagnostic items
     * Load ConsultationRequest after listener emitted
     * @return void
     */
    public function openModalToAddDiagnosticItems(): void
    {
        $this->dispatch('open-diagnostic-items');
        $this->dispatch('consultationRequest', $this->consultationRequest);
    }
    /**
     * Store new Consultation Request Comment
     * @return void
     */
    public function store()
    {
        $fields = $this->validate();
        try {
            $fields['consultation_request_id'] = $this->consultationRequest->id;
            $fields['body'] = $this->note;
            ConsultationComment::create($fields);
            $this->dispatch('added', ['message' => 'Action bien réalisée']);
        } catch (Exception $exception) {
            $this->dispatch('error', ['message' => $exception->getMessage()]);
        }
    }
    /**
     * Updated Consultation Request Comment
     * @return void
     */
    public function update()
    {
        $fields = $this->validate();
        try {
            $fields['body'] = $this->note;
            $this->consultationRequest->consultationComment->update($fields);
            $this->dispatch('added', ['message' => 'Action bien réalisée']);
        } catch (Exception $exception) {
            $this->dispatch('error', ['message' => $exception->getMessage()]);
        }
    }
    /**
     * Create new Comment don't exist or Update it if is existed
     * @return void
     */
    public function handlerSubmit(): void
    {
        if ($this->consultationRequest->consultationComment == null) {
            $this->store();
        } else {
            $this->update();
        }
    }
    /**
     * Mounted Compoment
     * @param ConsultationRequest $consultationRequest
     * @return void
     */
    public function mount(ConsultationRequest $consultationRequest): void
    {
        $this->consultationRequest = $consultationRequest;
        if ($this->consultationRequest?->consultationComment != null) {
            $this->note = $this->consultationRequest->consultationComment->body;
        }
    }
    /**
     * Render view
     * @return Application|Factory|View|\Illuminate\Foundation\Application
     */
    public function render()
    {
        return view('livewire.application.sheet.form.new-consultation-comment');
    }
}
