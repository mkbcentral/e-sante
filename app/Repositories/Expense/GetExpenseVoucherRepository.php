<?php
namespace App\Repositories\Expense;

use App\Models\ExpenseVoucher;

class GetExpenseVoucherRepository{
    public static function getList(
        ?string $date,
        ?string $month,
        ?int $categorySpendMoneyId,
        ?int $agentServiceId,
        ?int $currencyId,
        ?int $per_page,
    ):mixed{
        return ExpenseVoucher::query()
            ->when($date,function($query,$val){
                return $query->whereDate('created_at',$val);
            })
            ->when($month, function ($query, $val) {
                return $query->whereMonth('created_at', $val);
            })
            ->when($categorySpendMoneyId, function ($query, $val) {
                return $query->where('category_spend_money_id', $val);
            })
            ->when($agentServiceId, function ($query, $val) {
                return $query->whereDate('agent_service_id', $val);
            })
            ->when($currencyId, function ($query, $val) {
                return $query->whereDate('currency_id', $val);
            })
            ->paginate($per_page);
    }

    public static function getAmountToatl(
        ?string $date,
        ?string $month,
        ?int $categorySpendMoneyId,
        ?int $agentServiceId,
        ?string $currency,
    ): mixed {
        return ExpenseVoucher::query()
        ->join('currencies','currencies.id', 'expense_vouchers.currency_id')
            ->when($date, function ($query, $val) {
                return $query->whereDate('expense_vouchers.created_at', $val);
            })
            ->when($month, function ($query, $val) {
                return $query->whereMonth('expense_vouchers.created_at', $val);
            })
            ->when($categorySpendMoneyId, function ($query, $val) {
                return $query->where('expense_vouchers.category_spend_money_id', $val);
            })
            ->when($agentServiceId, function ($query, $val) {
                return $query->whereDate('expense_vouchers.agent_service_id', $val);
            })
            ->where('currencies.name',$currency)
            ->where('expense_vouchers.is_valided',true)
            ->select('expense_vouchers')
            ->sum('expense_vouchers.amount');


    }
}
