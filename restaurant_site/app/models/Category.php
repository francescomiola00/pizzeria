<?php
// ─────────────────────────────────────────
//  app/models/Category.php
// ─────────────────────────────────────────

class Category
{
    private PDO $db;

    public function __construct()
    {
        $this->db = Database::getInstance();
    }

    public function getAll(): array
    {
        $stmt = $this->db->query('SELECT * FROM categories ORDER BY sort_order ASC, name ASC');
        return $stmt->fetchAll();
    }

    public function getById(int $id): array|false
    {
        $stmt = $this->db->prepare('SELECT * FROM categories WHERE id = ? LIMIT 1');
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    public function create(string $name, int $sortOrder = 0): bool
    {
        $stmt = $this->db->prepare('INSERT INTO categories (name, sort_order) VALUES (?, ?)');
        return $stmt->execute([trim($name), $sortOrder]);
    }

    public function update(int $id, string $name, int $sortOrder = 0): bool
    {
        $stmt = $this->db->prepare('UPDATE categories SET name = ?, sort_order = ? WHERE id = ?');
        return $stmt->execute([trim($name), $sortOrder, $id]);
    }

    public function delete(int $id): bool
    {
        $stmt = $this->db->prepare('DELETE FROM categories WHERE id = ?');
        return $stmt->execute([$id]);
    }

    public function count(): int
    {
        return (int) $this->db->query('SELECT COUNT(*) FROM categories')->fetchColumn();
    }

    public function nameExists(string $name, int $excludeId = 0): bool
    {
        $stmt = $this->db->prepare('SELECT COUNT(*) FROM categories WHERE name = ? AND id != ?');
        $stmt->execute([trim($name), $excludeId]);
        return (int) $stmt->fetchColumn() > 0;
    }
}