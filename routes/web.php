<?php

use App\Http\Controllers\Application\Navigation\AppNavigationController;
use App\Http\Controllers\Application\Print\ConsultationRequest\ConsultationRequestPrinterController;
use App\Http\Controllers\Application\Print\Finance\OutpatientBillPrinterController;
use App\Http\Controllers\Application\Print\Finance\PayrollPrintController;
use App\Http\Controllers\Application\Product\OtherPrinterController;
use App\Http\Controllers\Application\Product\ProductInvoicePrinterController;
use App\Http\Controllers\Application\Product\ProductPrinterController;
use App\Livewire\Application\Admin\MainAdmin;
use App\Livewire\Application\Configuration\MainConfiguration;
use App\Livewire\Application\Dashboard\MainDashboard;
use App\Livewire\Application\Files\FileManagerView;
use App\Livewire\Application\Finance\Billing\MainOutPatientBillReport;
use App\Livewire\Application\Finance\Billing\OutpatientBillView;
use App\Livewire\Application\Finance\Cashbox\ExpenseVoucherView;
use App\Livewire\Application\Finance\Cashbox\NoteMoneySendingView;
use App\Livewire\Application\Finance\Cashbox\PayrollByMonthView;
use App\Livewire\Application\Finance\Cashbox\PayrollView;
use App\Livewire\Application\Finance\Product\FinanceRapport;
use App\Livewire\Application\Finance\Rapport\RapportFinanceBySubscriptionView;
use App\Livewire\Application\Labo\LaboFinanceRapport;
use App\Livewire\Application\Labo\LaboMonthlyReleases;
use App\Livewire\Application\Labo\MainLabo;
use App\Livewire\Application\Labo\Screens\LaboSubscriberView;
use App\Livewire\Application\Labo\Screens\MakeLaboOutpatientBillView;
use App\Livewire\Application\Localization\MainLocalization;
use App\Livewire\Application\Navigation\Mainnavigation;
use App\Livewire\Application\Sheet\MainSheet;
use Illuminate\Support\Facades\Route;
use App\Livewire\Application\Patient\FolderPatient;
use App\Livewire\Application\Product\Invoice\List\ListProductStockForInvoicePage;
use App\Livewire\Application\Product\Invoice\MainProductInvoice;
use App\Livewire\Application\Product\Invoice\MainProductInvoiceReport;
use App\Livewire\Application\Tarification\TarifView;
use App\Livewire\Application\Tarification\PriceList;
use App\Livewire\Application\Sheet\MainConsultationRequest;
use App\Livewire\Application\Sheet\MainConsultPatient;
use App\Livewire\Application\Product\List\ListProduct;
use App\Livewire\Application\Product\ProductPurchaseView;
use App\Livewire\Application\Product\ProductSupplyView;
use App\Livewire\Application\Product\Requisition\MainProductRequisitionView;
use App\Livewire\Application\Product\Requisition\ProductRequisitionItemsView;
use App\Livewire\Application\Product\Supply\Form\AddProductsInSupply;
use App\Livewire\Application\Sheet\MainConsultationRequestHospitalize;

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

Route::middleware(['auth', 'verified', 'user.redirect.checker'])->group(function () {
    Route::get('/', AppNavigationController::class)->name('main');
    Route::get('/dashboard', MainDashboard::class)->name('dashboard');
    Route::get('/sheet', MainSheet::class)->name('sheet');
    Route::get('/patient/folder/{sheetId}', FolderPatient::class)->name('patient.folder');
    Route::get('tarification', TarifView::class)->name('tarification');

    Route::get('tarification/prices', PriceList::class)->name('tarification.prices');
    Route::get('consultations-request-list', MainConsultationRequest::class)->name('consultations.request.list');
    Route::get('consultation/hospitalize', MainConsultationRequestHospitalize::class)->name('consultation.hospitalize');
    Route::get('consultation/consult-patient/{consultationRequestId}', MainConsultPatient::class)->name('consultation.consult.patient');

    Route::get('product/supplies', ProductSupplyView::class)->name('product.supplies');
    Route::get('product/supply/add-products/{productSupply}', AddProductsInSupply::class)->name('product.supply.add.products');
    Route::get('product/list', ListProduct::class)->name('product.list');
    Route::get('product/invoice/raport', MainProductInvoiceReport::class)->name('product.invoice.report');
    Route::get('product/invoice/stock', ListProductStockForInvoicePage::class)->name('product.invoice.stock');
    Route::get('product/purcharse', ProductPurchaseView::class)->name('product.purcharse');
    Route::get('product/requisitions', MainProductRequisitionView::class)->name('product.requisitions');
    Route::get('product/invoice', MainProductInvoice::class)->name('product.invoice');
    Route::get('product/finance-rapport', FinanceRapport::class)->name('product.finance.rapport');
    Route::get('product-requistion/{productRequisition}', ProductRequisitionItemsView::class)->name('product.requisition');

    Route::get('billing/outpatient', OutpatientBillView::class)->name('bill.outpatient');
    Route::get('billing/outpatient/rapport', MainOutPatientBillReport::class)->name('bill.outpatient.rapport');

    Route::get('finance/payroll/', PayrollView::class)->name('payroll');
    Route::get('finance/payroll/month', PayrollByMonthView::class)->name('payroll.month');
    Route::get('finance/expense-voucher/', ExpenseVoucherView::class)->name('expense.voucher');
    Route::get('finance/money-sending/', NoteMoneySendingView::class)->name('note.money.seding');
    Route::get('finance/rapport/by-subscription/{subscription}/{month}', RapportFinanceBySubscriptionView::class)->name('finance.rapport.by.subscription');

    Route::get('labo', MainLabo::class)->name('labo.main');
    Route::get('labo-subscriber/{consultationRequest}', LaboSubscriberView::class)->name('labo.subscriber');
    Route::get('labo-private/{outpatientBill}', MakeLaboOutpatientBillView::class)->name('labo.outpatientBill');
    Route::get('labo/monthly-release', LaboMonthlyReleases::class)->name('labo.monthly.release');
    Route::get('labo/finance-rapport', LaboFinanceRapport::class)->name('labo.finance.rapport');

    Route::get('/users', MainAdmin::class)->name('users');
    Route::get('/configuration', MainConfiguration::class)->name('configuration');
    Route::get('/navigation', Mainnavigation::class)->name('navigation');
    Route::get('/files', FileManagerView::class)->name('files');
    Route::get('/localization', MainLocalization::class)->name('localization');
});

//Printing route
Route::prefix('print')->group(function () {
    Route::controller(OutpatientBillPrinterController::class)->group(function () {

        Route::get('out-patient-bill/{outPatientBill}/{currency}', 'printOutPatientBill')->name('outPatientBill.print');
        Route::get('rapport-date-out-patient-bill/{date}/{dateVersement}', 'printRapportByDateOutpatientBill')->name('rapport.date.outPatientBill.print');
        Route::get('rapport-month-out-patient-bill/{month}', 'printRapportByMonthOutpatientBill')->name('rapport.month.outPatientBill.print');
        Route::get('print-all-date/{subscriptionId}/{date}', 'pridntAllConsultationRequestBydate')->name('consultation.request.date.all.print');
        Route::get('print-all-month/{subscriptionId}/{month}', 'pridntAllConsultationRequestByMonth')->name('consultation.request.month.all.print');
        Route::get('print-all-period/{subscriptionId}/{startDate}/{endDate}', 'pridntAllConsultationRequestBetweenDate')->name('consultation.request.period.print');
    });
    Route::controller(ProductPrinterController::class)->group(function () {
        Route::get('product-purcharse/{productPurchase}', 'printProductPurcharseList')->name('product.purcharse.print');
        Route::get('product/price', 'printProductListPrice')->name('product.list.price.print');
        Route::get('product/requisition/{id}', 'printListProductRequisition')
            ->name('product.requisition.print');
    });

    Route::controller(ConsultationRequestPrinterController::class)->group(function () {
        Route::get('consultation-request-private-/{id}', 'printPrivateInvoiceByDate')->name('consultation.request.private.invoice');
        Route::get('consultation-requests-has-not-shipping-ticket/{subscriptionId}/{month}', 'printConsultationRequestHasNotShippingTicket')
            ->name('consultation.request.lits.has_a_shipping_ticket');

        Route::get('list-invoices-by-month/{subscriptionId}/{month}', 'printListInvoicesByMonth')
            ->name('list.invoices.month');

        Route::get('list-labo-by-month/{subscriptionId}/{month}', 'printListILaboByMonth')
        ->name('list.labo.month');

        Route::get('monthly-frequentation/{month?}/{year?}', 'printMonthlyFrequentation')
            ->name('monthly.frequentation');
        Route::get('monthly-frequentation-hospitalize/{month?}/{year?}', 'printMonthlyFrequentationHospitalize')
            ->name('monthly.frequentation.hospitalize');
    });

    Route::controller(ProductInvoicePrinterController::class)->group(function () {
        Route::get('product-invoice/{id}', 'printInvoiceProduct')->name('product.invoice.print');
        Route::get('product-invoice-rapport-date/{date}/{dateVersement}/{isByDate}', 'printOutpatientBillRapportByDate')->name('product.invoice.rapport.date.print');
        Route::get('product-invoice-rapport-month/{month}/{dateVersement}/0', 'printOutpatientBillRapportByMonth')->name('product.invoice.rapport.month.print');
    });

    Route::controller(OtherPrinterController::class)->group(function () {
        Route::get('tarif-list-price/{type}/{categoryTarif?}', 'printListPriceTarif')->name('print.tarification.prices');
        Route::get('product-finance-repport/{month}', 'printProductFinanceRapportByMonth')->name('print.product.finance.repport');

        //labo monthly release
        Route::get('labo-monthly-releases/{month}/{subscription_id}', 'printLaboMonthlyReleases')->name('print.labo.monthly.releases');
        Route::get('labo-finance-rapport', 'printLaboMonthlyReleases')->name('print.labo.finance.repport');
    });

    Route::controller(PayrollPrintController::class)->group(function () {
        //payroll
        Route::get('payroll/{id}', 'printPayroll')->name('print.payroll');
        Route::get('payroll-month/{month}/{source}/{category}/{currency}/', 'printPayrollByMonth')->name('print.payroll.month');
        Route::get('payroll-date/{date}/{source}/{category}/{currency}/', 'printPayrollByDate')->name('print.payroll.date');
    });
});
