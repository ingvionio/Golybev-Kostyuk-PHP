<?php

namespace SupportModule;

use PDO;

class ReportManager
{
    private PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    // Получаем все отчеты (CRUD: Read)
    public function getAllReports(): array
    {
        $stmt = $this->pdo->query("
            SELECT e.*, u.name as user_name, u.email as user_email 
            FROM error_reports e 
            LEFT JOIN users u ON e.user_id = u.id 
            ORDER BY e.created_at DESC
        ");
        
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    // Ответ админа (CRUD: Update)
    public function replyToReport(int $id, string $reply): bool
    {
        $stmt = $this->pdo->prepare("
            UPDATE error_reports 
            SET admin_reply = :reply, status = 'resolved', updated_at = CURRENT_TIMESTAMP 
            WHERE id = :id
        ");

        return $stmt->execute([
            ':reply' => $reply,
            ':id' => $id
        ]);
    }
}