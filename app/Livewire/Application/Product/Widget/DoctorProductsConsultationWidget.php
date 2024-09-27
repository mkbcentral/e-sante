<?php

namespace App\Livewire\Application\Product\Widget;

use App\Livewire\Helpers\Query\MakeQueryBuilderHelper;
use App\Models\ConsultationRequest;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class DoctorProductsConsultationWidget extends Component
{
    protected $listeners = [
        'refreshProductItems' => '$refresh',
    ];
    public ?ConsultationRequest $consultationRequest;
    public int $idSelected = 0, $qty = 1, $idProduct = 0;
    public $dosage;
    public bool $isEditing = false;
    /**
     * Mounted component
     * @param ConsultationRequest|null $consultationRequest
     * @return void
     */
    public function mount(ConsultationRequest $consultationRequest): void
    {
        $this->consultationRequest = $consultationRequest;
    }

    /**
     * Make table items products selected editable
     * @param int $id
     * @param int $qty
     * @param $productId
     * @return void
     */
    public function edit(int $id): void
    {
        $this->idSelected = $id;
        $this->isEditing = true;
        $data = DB::table('consultation_request_product')->where('id', $id)->first();
        $this->idProduct = $data->product_id;
        $this->qty = $data->qty;
        $this->dosage = $data->dosage;

    }

    /**
     * Update product item selected
     * @return void
     */
    public function update(): void
    {
        try {
            MakeQueryBuilderHelper::update(
                'consultation_request_product',
                'id',
                $this->idSelected,
                ['qty' => $this->qty, 'dosage' => $this->dosage]
            );
            $this->isEditing = false;
            $this->idSelected = 0;
            $this->dispatch('updated', ['message' => 'Action bien réalisée']);
        } catch (\Exception $exception) {

            $this->dispatch('error', ['message' => $exception->getMessage()]);
        }
    }

    /**
     * Delete product item
     * @param int $id
     * @return void
     */
    public function delete(int $id): void
    {
        try {
            MakeQueryBuilderHelper::delete(
                'consultation_request_product',
                'id',
                $id
            );
            $this->dispatch('updated', ['message' => 'Action bien réalisée']);
            $this->dispatch('listSheetRefreshed');
            $this->dispatch('refreshDetail');
            $this->dispatch('refreshAmount');
        } catch (\Exception $exception) {
            $this->dispatch('error', ['message' => $exception->getMessage()]);
        }
    }

    public function render()
    {
        return view('livewire.application.product.widget.doctor-products-consultation-widget');
    }
}
