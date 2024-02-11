<?php

namespace App\Livewire\Application\Sheet\Form;

use App\Livewire\Helpers\Query\MakeQueryBuilderHelper;
use App\Models\ConsultationRequest;
use App\Models\Product;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class MedicalPrescription extends Component
{
    protected $listeners = ['consultationRequest' => 'getConsultationRequest'];
    public ?ConsultationRequest $consultationRequest;
    public array $productsForm = [];
    /**
     * Get initial array data for product form items
     * @return array
     */
    public function getDefaultArrayData(): array
    {
        return [
            'product_id' => 0,
            'qty' => 1,
            'dosage' => ''
        ];
    }

    /**
     * Get consultation if consultationRequest listener emitted
     * @param ConsultationRequest|null $consultationRequest
     * @return void
     */
    public function getConsultationRequest(?ConsultationRequest $consultationRequest): void
    {
        $this->productsForm = [];
        $this->consultationRequest = $consultationRequest;
        $this->productsForm[] = $this->getDefaultArrayData();
    }

    /**
     * Add new line in form prescription array
     * @return void
     */
    public function addNewProductToForm(): void
    {
        $this->productsForm[] = $this->getDefaultArrayData();
    }

    /**
     * Remove item in form prescription array
     * @param $index
     * @return void
     */
    public function removeProductToForm($index): void
    {
        if (count($this->productsForm) > 1) {
            unset($this->productsForm[$index]);
            array_values($this->productsForm);
        }
    }

    /**
     * Save items array product data in DB
     * @return void
     */
    public function addProductItems(): void
    {
        try {
            //Loop in array form data to get all products items
            foreach ($this->productsForm as $item) {
                //Check if input form is empty or value equal 0
                if ($item['product_id'] == 0 && $item['qty'] == 0) {
                    $this->dispatch('error', ['message' => 'Valeur saisie invalide']);
                } else {
                    //Get product items by id in arryu
                    $data = MakeQueryBuilderHelper::getSingleDataWithTowWhereClause(
                        'consultation_request_product',
                        'consultation_request_id',
                        'product_id',
                        $this->consultationRequest->id,
                        $item['product_id']
                    );
                    //Check if product item exist
                    if ($data) {
                        if ($data->product_id == $item['product_id'] and $data->consultation_request_id == $this->consultationRequest->id) {
                            $product = Product::find($item['product_id']);
                            $this->dispatch('error', ['message' => $product->name . ' déjà prescrit']);
                        } else {
                            $this->saveData($item);
                        }
                    } else {
                        //Save items data in DB
                        $this->saveData($item);
                    }
                }
            }
        } catch (\Exception $exception) {
            //Get message error exception
            $this->dispatch('error', ['message' => 'Une erreur se produite']);
        }

    }

    public function saveData(array $item): void
    {
        MakeQueryBuilderHelper::create('consultation_request_product', [
            'consultation_request_id' => $this->consultationRequest->id,
            'product_id' => $item['product_id'],
            'qty' => $item['qty'],
            'dosage' => $item['dosage'],
            'created_by' => Auth::id()
        ]);
        $this->dispatch('refreshProductItems');
        $this->dispatch('listSheetRefreshed');
        $this->dispatch('added', ['message' => 'Action bien réalisée']);
    }

    /**
     * Render component
     * @return Application|Factory|View|\Illuminate\Foundation\Application
     */
    public function render()
    {
        return view('livewire.application.sheet.form.medical-prescription');
    }
}
