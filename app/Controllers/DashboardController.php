<?php

namespace App\Controllers;

use App\Models\Transaction;
use App\Models\Investment;
use App\Models\Budget;
use App\Services\ReportService;

class DashboardController extends BaseController
{
    public function index()
    {
        $userId = $_SESSION['user']['id'] ?? null;

        if (!$userId) {
            redirect('/login');
        }

        // Dados para os cards de resumo
        $reportService = new ReportService();
        $summary = $reportService->getMonthlySummary($userId);

        // Dados para os gráficos
        $expensesByCategory = Transaction::getExpensesByCategory($userId);
        $upcomingBills = Transaction::getUpcomingBills($userId);

        // Dados de investimentos
        $investmentAllocation = Investment::getAllocation($userId);
        $investmentPerformance = Investment::getPerformance($userId);

        // Dados de orçamentos
        $budgets = Budget::getUserBudgetsWithProgress($userId);

        // Últimas transações
        $transactions = Transaction::getRecentTransactions($userId, 10);

        // Categorias para o modal
        $categories = Transaction::getUserCategories($userId);

        return view('dashboard', [
            'balance' => $summary['balance'],
            'monthlyIncome' => $summary['income'],
            'monthlyExpenses' => $summary['expenses'],
            'expensesByCategory' => $expensesByCategory,
            'upcomingBills' => $upcomingBills,
            'investmentAllocation' => $investmentAllocation,
            'investmentPerformance' => $investmentPerformance,
            'budgets' => $budgets,
            'transactions' => $transactions,
            'categories' => $categories
        ]);
    }

    public function getChartData()
    {
        $userId = $_SESSION['user']['id'] ?? null;

        if (!$userId) {
            return jsonResponse(['error' => 'Unauthorized'], 401);
        }

        $type = $_GET['type'] ?? 'expenses';
        $period = $_GET['period'] ?? 'monthly';

        switch ($type) {
            case 'expenses':
                $data = Transaction::getExpensesChartData($userId, $period);
                break;
            case 'income':
                $data = Transaction::getIncomeChartData($userId, $period);
                break;
            case 'investment':
                $data = Investment::getPerformanceChartData($userId, $period);
                break;
            default:
                $data = [];
        }

        return jsonResponse($data);
    }
}
