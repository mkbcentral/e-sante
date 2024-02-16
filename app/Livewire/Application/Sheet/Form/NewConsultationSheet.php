<?php

namespace App\Livewire\Application\Sheet\Form;

use App\Livewire\Forms\SheetForm;
use App\Models\ConsultationSheet;
use App\Models\Hospital;
use App\Models\Subscription;
use App\Repositories\OutpatientBill\CreateOutpatientBillRepository;
use App\Repositories\Sheet\Creation\CreateNewConsultationRequestRepository;
use App\Repositories\Sheet\Creation\CreateSheetRepository;
use App\Repositories\Sheet\Get\GetConsultationSheetRepository;
use Livewire\Component;

class NewConsultationSheet extends Component
{
    protected $listeners = [
        'selectedIndex' => 'getSelectedIndex',
        'emptySheet' => 'getEmptySheet',
        'sheetInfo' => 'getSheet'
    ];
    public SheetForm $form;
    public int $selectedIndex = 0;
    public ?Subscription $subscription;
    public string $municipality_name = '';
    public ?ConsultationSheet $sheet = null;
    public $formatedSheetNumber = '';
    public bool  $has_a_shipping_ticket = false;

    /**
     * Get subscription selected in parent component
     * @param int $selectedIndex
     * @return void
     */
    public function getSelectedIndex(int $selectedIndex): void
    {
        $this->selectedIndex = $selectedIndex;
        $this->subscription = Subscription::find($this->selectedIndex);
    }

    public  function getEmptySheet(): void
    {
        $this->sheet = null;
        $this->form->reset();
        $this->form->number_sheet = GetConsultationSheetRepository::getLastConsultationSheetNumber();
    }

    /**
     * Get sheet selected in parent component
     * @param ConsultationSheet|null $sheet
     * @return void
     */
    public function getSheet(?ConsultationSheet $sheet): void
    {
        $this->sheet = $sheet;
        $this->form->fill($sheet->toArray());
    }

    /**
     * Create new Consultation Sheet
     * @return void
     */
    public function store(): void
    {
        $this->validate();

        try {
            $fields = $this->form->all();
            $fields['hospital_id'] = Hospital::DEFAULT_HOSPITAL();
            $fields['subscription_id'] = $this->selectedIndex;
            $fields['source_id'] = auth()->user()->source->id;
            $existingSheet = GetConsultationSheetRepository::getExistingConsultationSheet(
                $this->form->name,
                $this->form->gender
            );
            if ($existingSheet == null) {
                $inpusoutpatientBill = [];
                $sheet = CreateSheetRepository::create($fields);
                CreateNewConsultationRequestRepository::create([
                    'request_number' => CreateNewConsultationRequestRepository::
                        generateConsultationRequetNumber($this->selectedIndex, date('m')),
                    'consultation_sheet_id' => $sheet->id,
                    'consultation_id' => $this->form->consultation_id,
                    'has_a_shipping_ticket' => $this->has_a_shipping_ticket
                ]);
                if ($sheet->subscription->is_private == true) {
                    $inpusoutpatientBill['client_name'] = $sheet->name;
                    $inpusoutpatientBill['consultation_id'] = $this->form->consultation_id;
                    $inpusoutpatientBill['consultation_sheet_id'] = $sheet->id;
                    $inpusoutpatientBill['currency_id'] = null;
                    CreateOutpatientBillRepository::create($inpusoutpatientBill);
                    $this->dispatch('outpatientBillRefreshedMainView');
                }
                $this->dispatch('added', ['message' => 'Action bien réalisée']);
                $this->dispatch('listSheetRefreshed');
                $this->dispatch('refreshSheetCounter');
                $this->dispatch('close-form-new');
            } else {
                $this->dispatch('error', ['message' => 'Action impossible, Ce patient existe déjà']);
            }
        } catch (\Exception $ex) {
            $this->dispatch('error', ['message' => $ex->getMessage()]);
        }
    }

    /**
     * Update Consultation Sheet
     * @return void
     */
    public function update(): void
    {
        $fields = $this->form->all();
        try {
            $fields['source_id'] = auth()->user()->source->id;
            $this->sheet->update($fields);
            $this->dispatch('close-form-new');
            $this->dispatch('updated', ['message' => 'Action bien réalisée']);
            $this->dispatch('listSheetRefreshed');
            $this->form->reset();
            $this->sheet = null;
        } catch (\Exception $ex) {
            $this->dispatch('error', ['message' => $ex->getMessage()]);
        }
    }
    /**
     * Handler specific action
     * @return void
     */
    public function handlerSubmit(): void
    {

        if ($this->sheet == null) {
            $this->store();
        } else {
            $this->update();
        }
    }
    /**
     * Mounted component
     * @return void
     */
    public function mount()
    {
        //Initialize sheet number
        $this->form->number_sheet = GetConsultationSheetRepository::getLastConsultationSheetNumber();
    }

    public function render()
    {
        $this->municipality_name = $this->form->municipality;
        return view('livewire.application.sheet.form.new-consultation-sheet');
    }
}
