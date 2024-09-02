<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Symfony\Component\HttpFoundation\Response;

class UserRedirectChecker
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $cucrrentRouteName = Route::currentRouteName();
        if (in_array(
            $cucrrentRouteName,
            $this->userAccessRole()[auth()->user()->roles()->pluck('name')[0]]
        )) {
            return $next($request);
        } else {
            abort(403);
        }
    }

    public function userAccessRole()
    {
        return [
            'Admin' => [
                'main',
                'dashboard',
                'sheet',
                'consultations.request.list',
                'tarification.prices',
                'consultation.consult.patient',
                'product.finance.rapport',
                'product.invoice.report',
                'users',
                'tarification',
                'finance.rapport.by.subscription'
            ],
            'Reception' => [
                'main',
                'dashboard',
                'sheet',
                'consultations.request.list',
                'tarification.prices'
            ],
            'Pharma' => [
                'main',
                'dashboard',
                'product.invoice',
                'product.list',
                'consultations.request.list',
                'consultation.hospitalize',
                'product.requisitions',
                'product.purcharse',
                'product.finance.rapport',
                'product.invoice.report',
                'product.requisition',
                'product.invoice.stock',
            ],
            'Caisse'=>[
                'main',
                'dashboard',
                'bill.outpatient',
                'bill.outpatient.rapport',
                'consultation.hospitalize',
                'tarification.prices'
            ],
            'Urgence' => [
                'main',
                'dashboard',
                'bill.outpatient',
                'bill.outpatient.rapport',
                'consultation.hospitalize',
                'tarification.prices',


            ],
            'Depot-Pharma'=>[
                'main',
                'dashboard',
                'product.list',
                'product.supplies',
                'product.requisitions',
                'product.requisition',
                'product.supply.add.products'
            ],
            'Nurse'=>[
                'main',
                'dashboard',
                'consultations.request.list',
                'consultation.hospitalize',
                'tarification.prices',
                'product.requisitions',
                'consultation.consult.patient',
                'product.requisition',
                'sheet',
            ],
            'Labo'=>[
                'main',
                'dashboard',
                'consultation.hospitalize',
                'labo.main',
                'labo.subscriber',
                'labo.outpatientBill',
                'labo.monthly.release',
                'tarification.prices',
                'product.requisitions',
                'product.requisition',
                'labo.finance.rapport'
            ],
            'Finance'=>[
                'main',
                'dashboard',
                'bill.outpatient.rapport',
                'payroll',
                'payroll.month',
                'expense.voucher',
                'note.money.seding',
                'print.payroll.month',
                'expense.voucher',
                'note.money.seding'
            ],
            'Finance-F' => [
                'main',
                'dashboard',
                'bill.outpatient.rapport',
                'payroll',
                'payroll.month',
                'expense.voucher',
                'note.money.seding',
                'print.payroll.month',
                'expense.voucher',
                'note.money.seding'
            ],
            'IT'=>[
                'main',
                'dashboard',
                'users',
                'configuration',
                'navigation',
                'files',
                'localization',
                'tarification'
            ]
        ];
    }
}
