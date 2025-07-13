<?php

namespace App\Models;

class Transaction extends BaseModel
{
    public static function getRecentTransactions(int $userId, int $limit = 10)
    {
        $sql = "SELECT t.*, c.name as category_name, c.color as category_color 
                FROM transactions t
                LEFT JOIN categories c ON t.category_id = c.id
                WHERE t.user_id = ?
                ORDER BY t.date DESC
                LIMIT ?";

        $stmt = self::executeQuery($sql, [$userId, $limit]);
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public static function getExpensesByCategory(int $userId)
    {
        $sql = "SELECT c.name as category, SUM(t.value) as amount, c.color
                FROM transactions t
                JOIN categories c ON t.category_id = c.id
                WHERE t.user_id = ? AND t.type = 'expense' 
                AND MONTH(t.date) = MONTH(CURRENT_DATE())
                GROUP BY c.name, c.color";

        $stmt = self::executeQuery($sql, [$userId]);
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }
}
