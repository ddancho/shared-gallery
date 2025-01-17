<?php

class m001_create_table_users
{
    private $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    public function up()
    {
        try {
            $sql = "CREATE TABLE IF NOT EXISTS users (
                id INT AUTO_INCREMENT PRIMARY KEY,
                name VARCHAR(255) NOT NULL,
                email VARCHAR(255) BINARY UNIQUE,
                password VARCHAR(255) NOT NULL,
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
            )  ENGINE=INNODB DEFAULT CHARSET=utf8;";
            $this->pdo->exec($sql);
        } catch (\PDOException $e) {
            die($e->getMessage());
        }
    }

    public function down()
    {
        try {
            $sql = "DROP TABLE IF EXISTS users;";
            $this->pdo->exec($sql);
        } catch (\PDOException $e) {
            die($e->getMessage());
        }
    }
}
