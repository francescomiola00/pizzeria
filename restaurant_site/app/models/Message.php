<?php
// ─────────────────────────────────────────
//  app/models/Message.php
// ─────────────────────────────────────────

class Message
{
    private PDO $db;

    public function __construct()
    {
        $this->db = Database::getInstance();
    }

    public function getAll(): array
    {
        $stmt = $this->db->query('SELECT * FROM messages ORDER BY created_at DESC');
        return $stmt->fetchAll();
    }

    public function getById(int $id): array|false
    {
        $stmt = $this->db->prepare('SELECT * FROM messages WHERE id = ? LIMIT 1');
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    public function getUnread(): array
    {
        $stmt = $this->db->query('SELECT * FROM messages WHERE is_read = 0 ORDER BY created_at DESC');
        return $stmt->fetchAll();
    }

    public function create(array $data): bool
    {
        $stmt = $this->db->prepare('
            INSERT INTO messages (name, email, subject, message, privacy_accepted)
            VALUES (?, ?, ?, ?, ?)
        ');
        return $stmt->execute([
            trim($data['name']),
            trim($data['email']),
            trim($data['subject'] ?? ''),
            trim($data['message']),
            isset($data['privacy_accepted']) ? 1 : 0,
        ]);
    }

    public function markAsRead(int $id): bool
    {
        $stmt = $this->db->prepare('UPDATE messages SET is_read = 1 WHERE id = ?');
        return $stmt->execute([$id]);
    }

    public function delete(int $id): bool
    {
        $stmt = $this->db->prepare('DELETE FROM messages WHERE id = ?');
        return $stmt->execute([$id]);
    }

    public function count(): int
    {
        return (int) $this->db->query('SELECT COUNT(*) FROM messages')->fetchColumn();
    }

    public function countUnread(): int
    {
        return (int) $this->db->query('SELECT COUNT(*) FROM messages WHERE is_read = 0')->fetchColumn();
    }
}






