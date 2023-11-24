<?php

namespace App\Livewire\Application\Sheet\Form;

use App\Models\ConsultationRequest;
use App\Models\Diagnostic;
use App\Models\Tarif;
use Livewire\Attributes\Url;
use Livewire\Component;

class ConsultPatient extends Component
{
    protected $listeners=[
        'selectedIndex'=>'getSelectedIndex',
    ];
    public array $tarifsSelected=[];
    #[Url(as: 'q')]
    public $q = '';
    #[Url(as: 'sortBy')]
    public $sortBy = 'name';
    #[Url(as: 'sortAsc')]
    public $sortAsc = true;
    public int $selectedIndex;
    public ?ConsultationRequest $consultationRequest;

    public function updatedTarifsSelected($val){
        try {
            $this->consultationRequest->tarifs()->sync($this->tarifsSelected);
            $this->dispatch('added', ['message' => 'Action bien réalisée']);
        }catch (\Exception $exception){
            $this->dispatch('error', ['message' => $exception->getMessage()]);
        }
    }
    public function getSelectedIndex(int $selectedIndex): void
    {
        $this->selectedIndex=$selectedIndex;
    }
    public function mount(ConsultationRequest $consultationRequest, int $selectedIndex): void
    {
        $this->selectedIndex=$selectedIndex;
        $this->consultationRequest=$consultationRequest;
    }
    public function sortTarif($value): void
    {
        if($value==$this->sortBy){
            $this->sortAsc=!$this->sortAsc;
        }
        $this->sortBy = $value;
    }
    public function addNewComment(): void
    {
        $this->dispatch('open-form-consultation-comment');
        $this->dispatch('consultationRequest',$this->consultationRequest);
    }
    public function render()
    {
        return view('livewire.application.sheet.form.consult-patient',[
            'tarifs'=>Tarif::join('category_tarifs','category_tarifs.id','tarifs.category_tarif_id')
                ->where('tarifs.category_tarif_id',$this->selectedIndex)
                ->when($this->q, function ($query) {
                    return $query->where(function ($query) {
                        return $query->where('tarifs.name', 'like', '%' . $this->q . '%');
                    });
                })->orderBy($this->sortBy, $this->sortAsc ? 'ASC' : 'DESC')
                ->select('tarifs.*')
                ->where('tarifs.is_changed',false)
                ->where('category_tarifs.hospital_id',1)
                ->get()
        ]);
    }
}
