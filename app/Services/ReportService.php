<?php

namespace App\Services;

use App\Models\Transaction;
use App\Models\Investment;

class ReportService
{
    public function getMonthlySummary(int $userId): array
    {
        $income = Transaction::getMonthlyTotal($userId, 'income');
        $expenses = Transaction::getMonthlyTotal($userId, 'expense');

        return [
            'balance' => $income - $expenses,
            'income' => $income,
            'expenses' => $expenses
        ];
    }
}
