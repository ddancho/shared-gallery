<?php

namespace App\Core;

abstract class DbModel
{
    abstract public function table();
    abstract public function columns();

    public function insert()
    {
        $table = $this->table();
        $columns = $this->columns();
        $params = array_map(fn($column) => ":$column", array_keys($columns));

        try {
            $sql = "INSERT INTO $table (" . \implode(',', array_keys($columns)) . ") VALUES (" . \implode(',', $params) . ")";
            $stmt = self::prepare($sql);
            foreach ($columns as $key => $value) {
                $stmt->bindValue(":$key", $this->{$key}, $value);
            }
            $stmt->execute();

            return $stmt->rowCount() > 0 ? true : false;

        } catch (\PDOException $e) {
            die($e->getMessage());
        }

    }

    public function find($column, $type, $value, $cs = false)
    {
        $table = $this->table();
        $CS = $cs === true ? 'BINARY' : '';

        try {
            $sql = "SELECT * FROM $table WHERE $column = " . $CS . " :attr";
            $stmt = self::prepare($sql);
            $stmt->bindParam(":attr", $value, $type);
            $stmt->execute();

            return $stmt->rowCount() > 0 ? true : false;

        } catch (\PDOException $e) {
            die($e->getMessage());
        }
    }

    public function get($column, $type, $value, $cs = false)
    {
        $table = $this->table();
        $CS = $cs === true ? 'BINARY' : '';

        try {
            $sql = "SELECT * FROM $table WHERE $column = " . $CS . " :attr LIMIT 1";
            $stmt = self::prepare($sql);
            $stmt->bindParam(":attr", $value, $type);
            $stmt->execute();

            return $stmt->fetch(\PDO::FETCH_ASSOC);

        } catch (\PDOException $e) {
            die($e->getMessage());
        }
    }

    public function update($params)
    {
        $table = $this->table();    
        $query = "UPDATE $table SET ";
        $where = " WHERE id = :id";
        $values = '';
        
        foreach($params as $attr => $param) {
            if($attr === "id") continue;
            $values .= "$attr = :$attr,";           
        }
        $values = \rtrim($values, ",");
        
        $sql = $query . $values . $where;

        try {
            $stmt = self::prepare($sql);
            foreach ($params as $key => $param) {
                $stmt->bindParam(":{$key}", $param['value'], $param['type']);
            }
            return $stmt->execute();

        } catch (\PDOException $e) {
            die($e->getMessage());
        }
    }

    public function getCount($params)
    {
        $sql = $params['query'];
        unset($params['query']);

        try {
            $stmt = self::prepare($sql);
            foreach ($params as $key => $param) {
                $stmt->bindParam(":{$key}", $param['value'], $param['type']);
            }
            $stmt->execute();

            return $stmt->fetchColumn();

        } catch (\PDOException $e) {
            die($e->getMessage());
        }
    }

    public function getAll($params)
    {
        $sql = $params['query'];
        unset($params['query']);

        try {
            $stmt = self::prepare($sql);
            foreach ($params as $key => $param) {
                $stmt->bindParam(":{$key}", $param['value'], $param['type']);
            }
            $stmt->execute();

            return $stmt->fetchAll(\PDO::FETCH_ASSOC);

        } catch (\PDOException $e) {
            die($e->getMessage());
        }
    }

    public static function prepare($sql)
    {
        return Application::$app->database->pdo->prepare($sql);
    }
}
