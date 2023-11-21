<?php

use App\Livewire\Application\Dashboard\MainDashboard;
use App\Livewire\Application\Sheet\MainSheet;
use Illuminate\Support\Facades\Route;
use App\Livewire\Application\Patient\FolderPatient;
use App\Livewire\Application\Tarification\TarifView;
use App\Livewire\Application\Tarification\PriceList;
use App\Livewire\Application\Sheet\MainConsultationRequest;
use App\Livewire\Application\Sheet\MainConsultPatient;

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

Route::get('/',MainDashboard::class)->name('dashboard');
Route::get('/sheet',MainSheet::class)->name('sheet');
Route::get('/patient/folder/{sheetId}',FolderPatient::class)->name('patient.folder');
Route::get('tarification',TarifView::class)->name('tarification');
Route::get('tarification/prices',PriceList::class)->name('tarification.prices');
Route::get('consultation/req',MainConsultationRequest::class)->name('consultation.req');
Route::get('consultation/consult-patient/{consultationRequestId}',MainConsultPatient::class)->name('consultation.consult.patient');

