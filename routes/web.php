<?php

use App\Http\Controllers\Application\Print\Finance\OutpatientBillPrinterController;
use App\Livewire\Application\Admin\MainAdmin;
use App\Livewire\Application\Configuration\MainConfiguration;
use App\Livewire\Application\Dashboard\MainDashboard;
use App\Livewire\Application\Files\FileManagerView;
use App\Livewire\Application\Finance\Billing\MainOutPatientBillReport;
use App\Livewire\Application\Finance\Billing\OutpatientBillView;
use App\Livewire\Application\Localization\MainLocalization;
use App\Livewire\Application\Sheet\MainSheet;
use Illuminate\Support\Facades\Route;
use App\Livewire\Application\Patient\FolderPatient;
use App\Livewire\Application\Product\Invoice\MainProductInvoice;
use App\Livewire\Application\Product\Invoice\MainProductInvoiceReport;
use App\Livewire\Application\Tarification\TarifView;
use App\Livewire\Application\Tarification\PriceList;
use App\Livewire\Application\Sheet\MainConsultationRequest;
use App\Livewire\Application\Sheet\MainConsultPatient;
use App\Livewire\Application\Product\List\ListProduct;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/administration', MainAdmin::class)->name('admin');
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/configuration', MainConfiguration::class)->name('configuration');
    Route::get('/files', FileManagerView::class)->name('files');
    Route::get('/localization', MainLocalization::class)->name('localization');
    Route::get('/', MainDashboard::class)->name('dashboard');
    Route::get('/sheet', MainSheet::class)->name('sheet');
    Route::get('/patient/folder/{sheetId}', FolderPatient::class)->name('patient.folder');
    Route::get('tarification', TarifView::class)->name('tarification');
    Route::get('tarification/prices', PriceList::class)->name('tarification.prices');
    Route::get('consultation/req', MainConsultationRequest::class)->name('consultation.req');
    Route::get('consultation/consult-patient/{consultationRequestId}', MainConsultPatient::class)->name('consultation.consult.patient');
    Route::get('product/list', ListProduct::class)->name('product.list');
    Route::get('product/invoice/raport', MainProductInvoiceReport::class)->name('product.invoice.report');
    Route::get('product/invoice', MainProductInvoice::class)->name('product.invoice');
    Route::get('billing/outpatient', OutpatientBillView::class)->name('bill.outpatient');
    Route::get('billing/outpatient/rapport', MainOutPatientBillReport::class)->name('bill.outpatient.rapport');

    Route::prefix('print')->group(function () {
        Route::controller(OutpatientBillPrinterController::class)->group(function () {
            Route::get('out-patient-bill/{outPatientBill}/{currency}', 'printOutPatientBill')->name('outPatientBill.print');
        });
    });
});
