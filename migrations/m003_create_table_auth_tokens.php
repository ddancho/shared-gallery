<?php

class m003_create_table_auth_tokens
{
    private $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    public function up()
    {
        try {
            $sql = "CREATE TABLE IF NOT EXISTS auth_tokens (
                id INT AUTO_INCREMENT PRIMARY KEY,
                selector CHAR(12) NOT NULL,
                token CHAR(64) NOT NULL,
                user_id INTEGER(11) UNSIGNED NOT NULL,
                expires DATETIME
            )  ENGINE=INNODB DEFAULT CHARSET=utf8;";
            $this->pdo->exec($sql);
        } catch (\PDOException $e) {
            die($e->getMessage());
        }
    }

    public function down()
    {
        try {
            $sql = "DROP TABLE IF EXISTS auth_tokens;";
            $this->pdo->exec($sql);
        } catch (\PDOException $e) {
            die($e->getMessage());
        }
    }
}
