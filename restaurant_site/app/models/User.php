<?php
// ─────────────────────────────────────────
//  app/models/User.php
//  Model per la gestione degli amministratori
// ─────────────────────────────────────────

class User
{
    private PDO $db;

    public function __construct()
    {
        $this->db = Database::getInstance();
    }

    /**
     * Trova un admin per username.
     * Restituisce l'array con i dati o false se non trovato.
     */
    public function findByUsername(string $username): array|false
    {
        $stmt = $this->db->prepare(
            'SELECT id, username, password_hash, created_at 
             FROM admins 
             WHERE username = ? 
             LIMIT 1'
        );
        $stmt->execute([$username]);
        return $stmt->fetch();
    }

    /**
     * Verifica la password contro l'hash salvato nel DB.
     */
    public function verifyPassword(string $password, string $hash): bool
    {
        return password_verify($password, $hash);
    }

    /**
     * Crea un nuovo amministratore.
     * Restituisce l'ID del nuovo record o false in caso di errore.
     */
    public function createAdmin(string $username, string $password): int|false
    {
        // Controlla che lo username non esista già
        if ($this->findByUsername($username)) {
            return false;
        }

        $hash = password_hash($password, PASSWORD_BCRYPT, ['cost' => 12]);

        $stmt = $this->db->prepare(
            'INSERT INTO admins (username, password_hash) VALUES (?, ?)'
        );
        $stmt->execute([$username, $hash]);

        return (int) $this->db->lastInsertId();
    }

    /**
     * Aggiorna la password di un admin esistente.
     */
    public function updatePassword(int $id, string $newPassword): bool
    {
        $hash = password_hash($newPassword, PASSWORD_BCRYPT, ['cost' => 12]);

        $stmt = $this->db->prepare(
            'UPDATE admins SET password_hash = ? WHERE id = ?'
        );
        $stmt->execute([$hash, $id]);

        return $stmt->rowCount() > 0;
    }

    /**
     * Restituisce tutti gli amministratori (senza password_hash).
     */
    public function getAll(): array
    {
        $stmt = $this->db->query(
            'SELECT id, username, created_at FROM admins ORDER BY created_at DESC'
        );
        return $stmt->fetchAll();
    }
}