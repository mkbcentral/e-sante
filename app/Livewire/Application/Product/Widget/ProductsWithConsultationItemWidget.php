<?php

namespace App\Livewire\Application\Product\Widget;

use App\Livewire\Helpers\Query\MakeQueryBuilderHelper;
use App\Models\ConsultationRequest;
use Livewire\Component;

class ProductsWithConsultationItemWidget extends Component
{
    protected $listeners=['refreshProductItems'=>'$refresh'];
    public ?ConsultationRequest $consultationRequest;
    public int $idSelected = 0, $qty = 1, $idProduct = 0;
    public bool $isEditing = false;
    public function mount(?ConsultationRequest $consultationRequest){
        $this->consultationRequest=$consultationRequest;
    }
    public function edit(int $id, int $qty, $productId,){
        $this->qty=$qty;$this->idSelected=$id;$this->idProduct=$productId;
        $this->isEditing=true;
    }
    public  function  update(): void
    {
        try {
            MakeQueryBuilderHelper::update(
                $this->idSelected,
                ['qty' => $this->qty], 'consultation_request_product');
            $this->isEditing = false;
            $this->idSelected = 0;
        }catch (\Exception $exception){
            $this->dispatch('error', ['message' => $exception->getMessage()]);
        }
    }
    public function delete(int $id): void
    {
        try {
            MakeQueryBuilderHelper::delete($id, 'consultation_request_product');
            $this->dispatch('updated', ['message' => 'Action bien réalisée']);
        } catch (\Exception $exception) {
            $this->dispatch('error', ['message' => $exception->getMessage()]);
        }
    }
    public function render()
    {
        return view('livewire.application.product.widget.products-with-consultation-item-widget');
    }
}
