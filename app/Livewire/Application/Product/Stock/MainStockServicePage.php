<?php

namespace App\Livewire\Application\Product\Stock;

use App\Livewire\Helpers\Query\MakeQueryBuilderHelper;
use App\Models\StockService;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Url;
use Livewire\Component;

class MainStockServicePage extends Component
{

    protected $listeners = [
        'refreshStock' => '$refresh'
    ];

    public bool $isEditing=false;
    public $qtyToEdit;
    public $idProductToEdit;
    #[Url(as: 'q')]
    public $q = '';

    public function edit($id,$qty){
        $this->idProductToEdit = $id;
        $this->isEditing = true;
        $this->qtyToEdit = $qty;
    }

    public function update(){
        try {
            MakeQueryBuilderHelper::update(
                'product_stock_service',
                'product_id',
                $this->idProductToEdit,
                [
                    'qty' => $this->qtyToEdit
                ]
            );
            $this->isEditing = false;
            $this->idProductToEdit = 0;
            $this->dispatch('updated', params: ['message' => 'Quantité bein mise à jour']);
        } catch (\Exception $ex) {
            $this->dispatch('error', ['message' => $ex->getMessage()]);
        }
    }
    public function createNewStock(){
        try {
            if (Auth::user()->stockService) {
                $this->dispatch('error', ['message' => 'Vous avez déjà un stock']);
            }else{
                StockService::create(['user_id' => Auth::id()]);
                $this->dispatch('added', ['message' => 'Stock bien crée']);
            }
        } catch (\Exception $ex) {
            $this->dispatch('error', ['message' => $ex->getMessage()]);
        }
    }

    public function delete($id){
        try {
            MakeQueryBuilderHelper::delete('product_stock_service','id',$id);
        } catch (\Exception $ex) {
            $this->dispatch('error', ['message' => $ex->getMessage()]);
        }
    }

    public function openAddProuctForm(){
        $this->dispatch('open-stock-service-product');
    }
    public function render()
    {
        return view('livewire.application.product.stock.main-stock-service-page',[
            'products'=> Auth::user()->stockService?->products()
                ->where('name','like','%'.$this->q.'%')
                ->paginate(20)
        ]);
    }
}
