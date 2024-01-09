<?php

namespace App\Livewire\Application\Product\Widget;

use App\Livewire\Helpers\Query\MakeQueryBuilderHelper;
use App\Models\ConsultationRequest;
use App\Models\Currency;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Livewire\Component;

class ProductsWithConsultationItemWidget extends Component
{
    protected $listeners = [
        'refreshProductItems' => '$refresh',
        'currencyName' => 'getCurrencyName'
    ];
    public ?ConsultationRequest $consultationRequest;
    public int $idSelected = 0, $qty = 1, $idProduct = 0;
    public bool $isEditing = false;
    public string $currency;

    public function getCurrencyName(string $currency): void
    {
        $this->currency = $currency;
    }

    /**
     * Mounted component
     * @param ConsultationRequest|null $consultationRequest
     * @return void
     */
    public function mount(?ConsultationRequest $consultationRequest): void
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
    public function edit(int $id, int $qty, $productId,): void
    {
        $this->qty = $qty;
        $this->idSelected = $id;
        $this->idProduct = $productId;
        $this->isEditing = true;
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
                ['qty' => $this->qty],
                ''
            );
            $this->isEditing = false;
            $this->idSelected = 0;
            $this->dispatch('listSheetRefreshed');
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
        } catch (\Exception $exception) {
            $this->dispatch('error', ['message' => $exception->getMessage()]);
        }
    }

    /**
     * Render component
     * @return Application|Factory|View|\Illuminate\Foundation\Application
     */
    public function render()
    {
        $this->currency = Currency::DEFAULT_CURRENCY;
        return view('livewire.application.product.widget.products-with-consultation-item-widget');
    }
}
