<?php
// ─────────────────────────────────────────
//  app/models/Product.php
// ─────────────────────────────────────────

class Product
{
    private PDO $db;

    public function __construct()
    {
        $this->db = Database::getInstance();
    }

    public function getAll(): array
    {
        $stmt = $this->db->query('
            SELECT p.*, c.name AS category_name
            FROM products p
            JOIN categories c ON p.category_id = c.id
            ORDER BY c.sort_order ASC, p.sort_order ASC, p.name ASC
        ');
        return $stmt->fetchAll();
    }

    public function getById(int $id): array|false
    {
        $stmt = $this->db->prepare('
            SELECT p.*, c.name AS category_name
            FROM products p
            JOIN categories c ON p.category_id = c.id
            WHERE p.id = ? LIMIT 1
        ');
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    public function getByCategory(int $categoryId): array
    {
        $stmt = $this->db->prepare('
            SELECT * FROM products
            WHERE category_id = ? AND is_available = 1
            ORDER BY sort_order ASC, name ASC
        ');
        $stmt->execute([$categoryId]);
        return $stmt->fetchAll();
    }

    public function create(array $data): bool
    {
        $stmt = $this->db->prepare('
            INSERT INTO products (category_id, name, description, price, is_available, sort_order)
            VALUES (?, ?, ?, ?, ?, ?)
        ');
        return $stmt->execute([
            (int)   $data['category_id'],
            trim(   $data['name']),
            trim(   $data['description'] ?? ''),
            (float) $data['price'],
            isset(  $data['is_available']) ? 1 : 0,
            (int)   ($data['sort_order'] ?? 0),
        ]);
    }

    public function update(int $id, array $data): bool
    {
        $stmt = $this->db->prepare('
            UPDATE products
            SET category_id = ?, name = ?, description = ?, price = ?, is_available = ?, sort_order = ?
            WHERE id = ?
        ');
        return $stmt->execute([
            (int)   $data['category_id'],
            trim(   $data['name']),
            trim(   $data['description'] ?? ''),
            (float) $data['price'],
            isset(  $data['is_available']) ? 1 : 0,
            (int)   ($data['sort_order'] ?? 0),
            $id,
        ]);
    }

    public function delete(int $id): bool
    {
        $stmt = $this->db->prepare('DELETE FROM products WHERE id = ?');
        return $stmt->execute([$id]);
    }

    public function toggleAvailability(int $id): bool
    {
        $stmt = $this->db->prepare('UPDATE products SET is_available = NOT is_available WHERE id = ?');
        return $stmt->execute([$id]);
    }

    public function count(): int
    {
        return (int) $this->db->query('SELECT COUNT(*) FROM products')->fetchColumn();
    }

    public function countAvailable(): int
    {
        return (int) $this->db->query('SELECT COUNT(*) FROM products WHERE is_available = 1')->fetchColumn();
    }
}