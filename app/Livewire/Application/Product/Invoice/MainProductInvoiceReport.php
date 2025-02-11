<?php

namespace App\Livewire\Application\Product\Invoice;

use App\Models\ConsultationRequest;
use Carbon\Carbon;
use Livewire\Component;

class MainProductInvoiceReport extends Component
{
    //mount

    public function mount()
    {
        /*
        $subscriptionId = 1;
        $consultationRequests = ConsultationRequest::whereHas('consultationSheet', function ($query) use ($subscriptionId) {
            $query->where('subscription_id', $subscriptionId);
        })->with('tarifs')
            ->whereDate('created_at', Carbon::now())
            ->get();

        foreach ($consultationRequests as $request) {
            $totalAmount = 0;

            foreach ($request->tarifs as $tarif) {
                $price = $tarif->pivot->is_private ? $tarif->price_private : $tarif->price_subscriber;
                $totalAmount += $price * $tarif->pivot->qty;
            }

            dd("ConsultationRequest ID: {$request->id}, Total Amount: {$totalAmount}\n");
            }
            */
    }

    public function render()
    {
        return view('livewire.application.product.invoice.main-product-invoice-report');
    }
}
