<?php

namespace App\Core;

class Migration
{
    private $root;
    private $pdo;

    public function __construct($config, $root)
    {
        $dsn = $config['dsn'] ?? '';
        $user = $config['user'] ?? '';
        $password = $config['password'] ?? '';

        try {
            $this->pdo = new \PDO($dsn, $user, $password);
            $this->pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
            $this->root = $root;
        } catch (\PDOException $e) {
            die($e->getMessage());
        }
    }

    public function applyMigrations()
    {
        $migrations = [];
        $files = [];

        $this->createTable();
        $files = \scandir($this->root . '/migrations');

        $appliedMigrations = $this->getAppliedMigrations();
        $toApplyMigrations = array_diff($files, $appliedMigrations);

        foreach ($toApplyMigrations as $migration) {
            if ($migration === '.' || $migration === '..') {
                continue;
            }

            $this->log("Applying migration $migration");

            require_once $this->root . "/migrations/" . $migration;

            $className = \pathinfo($migration, PATHINFO_FILENAME);

            $instance = new $className($this->pdo);

            $instance->up();

            $this->log("Migration $migration applied");

            $migrations[] = $migration;
        }

        if (!empty($migrations)) {
            $this->saveMigrations($migrations);
            $this->log("Updated migrations table with new migrations");
        } else {
            $this->log("All migrations are applied");
        }

    }

    private function saveMigrations($migrations)
    {
        try {
            $str = \implode(',', array_map(fn($m) => "('$m')", $migrations));
            $stm = $this->pdo->prepare("INSERT INTO migrations (migration) VALUES $str");
            $stm->execute();
        } catch (\PDOexception $e) {
            die($this->log($e->getMessage()));
        }
    }

    private function log($message)
    {
        echo '[' . date('Y-m-d H:i:s') . '] - ' . $message . PHP_EOL;
    }

    private function createTable()
    {
        try {
            $sql = "CREATE TABLE IF NOT EXISTS migrations (
                id INT AUTO_INCREMENT PRIMARY KEY,
                migration VARCHAR(255),
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
                ) ENGINE=INNODB;";
            $this->pdo->exec($sql);
        } catch (\PDOexception $e) {
            die($this->log($e->getMessage()));
        }
    }

    private function getAppliedMigrations()
    {
        try {
            $sql = "SELECT migration FROM migrations";
            $stm = $this->pdo->prepare($sql);
            $stm->execute();
            return $stm->fetchAll(\PDO::FETCH_COLUMN);
        } catch (\PDOexception $e) {
            die($this->log($e->getMessage()));
        }

    }
}
