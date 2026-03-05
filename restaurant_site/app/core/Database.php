<?php
// ─────────────────────────────────────────
//  app/core/Database.php
//  Singleton PDO – connessione al database
// ─────────────────────────────────────────

class Database
{
    private static ?PDO $instance = null;

    /**
     * Restituisce l'istanza unica PDO.
     * La connessione viene creata solo la prima volta.
     */
    public static function getInstance(): PDO
    {
        if (self::$instance === null) {
            $dsn = sprintf(
                'mysql:host=%s;dbname=%s;charset=%s',
                DB_HOST,
                DB_NAME,
                DB_CHARSET
            );

            $options = [
                PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES   => false,
            ];

            try {
                self::$instance = new PDO($dsn, DB_USER, DB_PASS, $options);
            } catch (PDOException $e) {
                // In produzione non esporre i dettagli dell'errore
                if (APP_DEBUG) {
                    die('Errore di connessione al database: ' . $e->getMessage());
                } else {
                    die('Errore di connessione al database. Riprova più tardi.');
                }
            }
        }

        return self::$instance;
    }

    /** Impedisce la clonazione (pattern Singleton) */
    private function __clone() {}

    /** Impedisce la deserializzazione (pattern Singleton) */
    public function __wakeup() {}
}
