<?php

namespace App\Livewire\Application\Sheet\Form;

use App\Livewire\Helpers\Query\MakeQueryBuilderHelper;
use App\Models\ConsultationRequest;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class DoctorMedicalPrescription extends Component
{
    public ?ConsultationRequest $consultationRequest;
    public array $productsForm = [];
    public $product_id;
    public $qty=1;
    public $dosage;

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
        //Check if input form is empty or value equal 0
        if ($this->product_id == 0 && $this->qty == 0) {
            $this->dispatch('error', ['message' => 'Valeur saisie invalide']);
        } else {
            $data = DB::table('consultation_request_product')
                ->where(
                    'consultation_request_id',
                    $this->consultationRequest->id
                )
                ->where(
                    'product_id',
                    $this->product_id
                )
                ->first();
            //Check if product item exist
            $item = [
                'product_id' => $this->product_id,
                'qty' => $this->qty,
                'dosage' => $this->dosage
            ];
            if ($data) {
                if ($data->product_id == $this->product_id and $data->consultation_request_id == $this->consultationRequest->id) {
                    $product = Product::find($this->product_id);
                    $this->dispatch('error', ['message' => $product->name . ' déjà prescrit']);
                } else {
                    $this->saveData($item);
                }
            } else {
                //Save items data in DB
                $this->saveData($item);
            }
        }
        try {
        } catch (\Exception $exception) {
            //Get message error exception
            $this->dispatch('error', ['message' => 'Une erreur se produite']);
        }
    }

    /**
     * Summary of saveData
     * @param array $item
     * @return void
     */
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

    public function mount(ConsultationRequest $consultationRequest)
    {
        $this->consultationRequest = $consultationRequest;
    }

    public function render()
    {
        return view('livewire.application.sheet.form.doctor-medical-prescription');
    }
}
