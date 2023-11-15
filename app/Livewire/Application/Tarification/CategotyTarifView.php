<?php

namespace App\Livewire\Application\Tarification;

use App\Models\CategoryTarif;
use App\Models\Tarif;
use Livewire\Attributes\Rule;
use Livewire\Component;

class CategotyTarifView extends Component
{
    protected $listeners=['deleteCategoryListener','delete'];
    #[Rule('required|min:3|string')]
    public $name;

    public ?CategoryTarif $categoryTarif;
    public bool $isEditing=false;

    public function store(){
        $fields=$this->validate();
        try {
            $fields['hospital_id']=1;
            CategoryTarif::create($fields);
            $this->dispatch('added', ['message' => 'Action bien réalisée']);
            $this->dispatch('refreshCategory');
        }catch (\Exception $exception){
            $this->dispatch('error', ['message' => $exception->getMessage()]);
        }
    }

    public function edit(CategoryTarif $categoryTarif){
        $this->isEditing=true;
        $this->categoryTarif=$categoryTarif;
        $this->name=$categoryTarif->name;
    }

    public function update(){
        $fields=$this->validate();
        try {
            $this->categoryTarif->update($fields);
            $this->dispatch('added', ['message' => 'Action bien réalisée']);
            $this->dispatch('refreshCategory');
            $this->name='';
            $this->isEditing=false;
        }catch (\Exception $exception){
            $this->dispatch('error', ['message' => $exception->getMessage()]);
        }
    }

    public function delete(CategoryTarif $categoryTarif): void
    {
        try {
            if($categoryTarif->tarifs->isEmpty()){
                $categoryTarif->delete();
                $this->dispatch('added', ['message' => "Action bien réalisée !"]);
            }else{
                $this->dispatch('error', ['message' =>'Cette category contient des données']);
            }
        }catch (\Exception $exception){
            $this->dispatch('error', ['message' => $exception->getMessage()]);
        }
    }

    public function showDeleteDialog(CategoryTarif $categoryTarif): void
    {
        $this->categoryTarif=$categoryTarif;
        $this->dispatch('delete-category-dialog');
    }

    public function render()
    {
        return view('livewire.application.tarification.categoty-tarif-view',[
            'categories'=>CategoryTarif::orderBy('name','ASC')->get()
        ]);
    }
}
