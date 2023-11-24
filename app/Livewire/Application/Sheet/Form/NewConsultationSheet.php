<?php

namespace App\Livewire\Application\Sheet\Form;

use App\Livewire\Forms\SheetForm;
use App\Models\ConsultationSheet;
use App\Models\Subscription;
use Livewire\Component;

class NewConsultationSheet extends Component
{
    protected $listeners = ['selectedIndex' => 'getSelectedIndex', 'sheetInfo' => 'getSheet'];
    public SheetForm $form;
    public int $selectedIndex = 0;
    public ?Subscription $subscription;
    public string $municipality_name = '';
    public ?ConsultationSheet $sheet=null;

    public function getSelectedIndex(int $selectedIndex): void
    {
        $this->selectedIndex = $selectedIndex;
        $this->subscription = Subscription::find($this->selectedIndex);
    }
    public function getSheet(?ConsultationSheet $sheet): void
    {
        $this->sheet = $sheet;
        if ($this->sheet == null) {
            $this->form->reset();
        }else{
            $this->form->fill($sheet->toArray());
        }
    }

    public function store(): void
    {
        $this->validate();
        try {
            $fields = $this->form->all();
            $fields['hospital_id'] = 1;
            $fields['subscription_id'] = $this->selectedIndex;
            ConsultationSheet::create($fields);
            $this->dispatch('added', ['message' => 'Action bien réalisée']);
            $this->dispatch('listSheetRefreshed');
            $this->dispatch('close-form-new');
        } catch (\Exception $ex) {
            $this->dispatch('error', ['message' => $ex->getMessage()]);
        }
    }

    public function update(): void
    {
        try {
            $this->sheet->update($this->form->all());
            $this->dispatch('close-form-new');
            $this->dispatch('updated', ['message' => 'Action bien réalisée']);
            $this->dispatch('listSheetRefreshed');
            $this->form->reset();
        } catch (\Exception $ex) {
            $this->dispatch('error', ['message' => $ex->getMessage()]);
        }
    }
    public function handlerSubmit()
    {
        if ($this->sheet == null) {
            $this->store();
        } else {
            $this->update();
        }
    }

    public function mount()
    {
        $last_number_sheet = ConsultationSheet::orderBy('created_at', 'DESC')->first()->number_sheet;
        $this->form->number_sheet = $last_number_sheet;
    }

    public function render()
    {
        $this->municipality_name = $this->form->municipality;
        return view('livewire.application.sheet.form.new-consultation-sheet');
    }
}
