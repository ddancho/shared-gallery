<?php

class m002_create_table_images
{
    private $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    public function up()
    {
        try {
            $sql = "CREATE TABLE IF NOT EXISTS images (
                id INT AUTO_INCREMENT PRIMARY KEY,
                user_id INT NOT NULL,
                image_name VARCHAR(255) NOT NULL,
                image_ext VARCHAR(255) NOT NULL,
                image_status INT NOT NULL DEFAULT 0,
                image_data LONGBLOB NOT NULL,
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                CONSTRAINT fk_user
                FOREIGN KEY (user_id)
                REFERENCES users(id)
                ON UPDATE CASCADE
                ON DELETE CASCADE
            )  ENGINE=INNODB DEFAULT CHARSET=utf8;";
            $this->pdo->exec($sql);
        } catch (\PDOException $e) {
            die($e->getMessage());
        }
    }

    public function down()
    {
        try {
            $sql = "DROP TABLE IF EXISTS images;";
            $this->pdo->exec($sql);
        } catch (\PDOException $e) {
            die($e->getMessage());
        }
    }
}
