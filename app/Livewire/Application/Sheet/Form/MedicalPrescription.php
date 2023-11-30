<?php

namespace App\Livewire\Application\Sheet\Form;

use App\Livewire\Helpers\Query\MakeQueryBuilderHelper;
use App\Models\ConsultationRequest;
use App\Models\Product;
use Livewire\Component;

class MedicalPrescription extends Component
{
    protected $listeners = ['consultationRequest' => 'getConsultationRequest'];
    public ?ConsultationRequest $consultationRequest;
    public array $productsForm = [];

    public function getDefaultArrayData(): array
    {
        return [
            'product_id' => 0,
            'qty' => 0,
            'dosage' => ''
        ];
    }

    public function getConsultationRequest(?ConsultationRequest $consultationRequest): void
    {
        $this->productsForm=[];
        $this->consultationRequest = $consultationRequest;
        $this->productsForm[] = $this->getDefaultArrayData();
    }

    public function addNewProductToForm(): void
    {
        $this->productsForm[] = $this->getDefaultArrayData();
    }

    public function removeProductToForm($index): void
    {
        if (count($this->productsForm) > 1) {
            unset($this->productsForm[$index]);
            array_values($this->productsForm);
        }
    }

    public function addProductItems(): void
    {
        try {
            foreach ($this->productsForm as $item) {
                $data = MakeQueryBuilderHelper::getData(
                    'consultation_request_product',
                    $this->consultationRequest->id,
                    $item['product_id']
                );
                //Check in array data is empty to return a error message
                if ($item['product_id'] == 0 && $item['qty'] == 0) {
                    $this->dispatch('error', ['message' => 'Valeur saisie invalide']);
                } else {
                    if ($data) {
                        if ($data->product_id == $item['product_id'] and $data->consultation_request_id == $this->consultationRequest->id) {
                            $product=Product::find($item['product_id']);
                            $this->dispatch('error', ['message' => $product->name.' déjà prescrit']);
                        } else {
                            MakeQueryBuilderHelper::create('consultation_request_product', [
                                'consultation_request_id' => $this->consultationRequest->id,
                                'product_id' => $item['product_id'],
                                'qty' => $item['qty'],
                                'dosage' => $item['dosage']
                            ]);
                            $this->dispatch('refreshProductItems');
                            $this->dispatch('added', ['message' => 'Action bien réalisée']);
                        }
                    } else {
                        MakeQueryBuilderHelper::create('consultation_request_product', [
                            'consultation_request_id' => $this->consultationRequest->id,
                            'product_id' => $item['product_id'],
                            'qty' => $item['qty'],
                            'dosage' => $item['dosage']
                        ]);
                        $this->dispatch('refreshProductItems');
                        $this->dispatch('added', ['message' => 'Action bien réalisée']);
                    }
                }
            }
        } catch (\Exception $exception) {
            $this->dispatch('error', ['message' => 'Une erreur se produite']);
        }

    }

    public function mount(): void
    {

    }

    public function render()
    {
        return view('livewire.application.sheet.form.medical-prescription');
    }
}
