<?php

class DatabaseConnection
{
    private $host;
    private $user;
    private $password;
    private $dbName;
    public $connection;
    private static $instance;

    private function __construct($host, $user, $password, $dbName)
    {
        $this->connect($host, $user, $password, $dbName);
    }


    public function connect($host, $user, $password, $dbName)
    {
        $this->host = $host;
        $this->user = $user;
        $this->password = $password;
        $this->dbName = $dbName;
        $connectionString = "mysql:host=$host;dbname=$dbName";
        $this->connection = new PDO($connectionString, $user, $password);

        return $this;
    }

    /**
     * @return DatabaseConnection
     */
    static function getinstance()
    {
        if (!self::$instance) {

            self::$instance = new self("localhost", "root", "", "promarket");
        }
        return self::$instance;
    }


    public function insert($table, $data)
    {
        $key_values = [];
        foreach ($data as $key => $value) {
            $key_values[":$key"] = $value;
        }
        $keys = array_keys($data);
        $fields = implode(',', $keys);

        $values = array_keys($key_values);
        $values = implode(',', $values);

        $sql = "INSERT INTO $table ($fields) VALUES ($values)";

        $stmt = $this->connection->prepare($sql);

        foreach ($key_values as $key => $value) {
            $stmt->bindValue($key, $value, is_integer($value) ? PDO::PARAM_INT : PDO::PARAM_STR);
        }

        $stmt->execute();

        return $stmt;
    }

    public function update($table, $data, $filters = null)
    {
        $key_values = [];
        $fields = '';
        $criteria = '';//array_keys($filters);

        foreach ($data as $key => $value) {
            $key_values[":$key"] = $value;

            if (strlen($fields) > 2) {
                $fields .= ", $key = :$key";
            } else {
                $fields .= "$key = :$key";
            }
        }

        foreach ($filters as $key => $value) {
            $key_values[":$key"] = $value;
            if (strlen($criteria) > 2) {
                $criteria .= ", $key = :$key";
            } else {
                $criteria .= "$key = :$key";
            }
        }

        $sql = "UPDATE $table SET $fields  WHERE($criteria)";

        $stmt = $this->connection->prepare($sql);

        foreach ($key_values as $key => $value) {
            $stmt->bindValue($key, $value, is_integer($value) ? PDO::PARAM_INT : PDO::PARAM_STR);
        }
        $stmt->execute();
        return $stmt;
    }

    public function delete($table, $filters = null)
    {
        $criteria = '';//array_keys($filters);

        foreach ($filters as $key => $value) {
            $key_values[":$key"] = $value;
            if (strlen($criteria) > 2) {
                $criteria .= ",$key = :$key";

            } else {
                $criteria .= "$key = :$key";
            }
        }

        $sql = "DELETE FROM $table WHERE ($criteria)";

        $stmt = $this->connection->prepare($sql);

        foreach ($key_values as $key => $value) {
            $stmt->bindValue($key, $value, is_integer($value) ? PDO::PARAM_INT : PDO::PARAM_STR);
        }

        $stmt->execute();
        return $stmt;

    }

    public function select($table, $fields, $filters)
    {
        $criteria = '';
        $key_values = [];
        $fields = implode(',', $fields);
        foreach ($filters as $key => $value) {
            $key_values[":$key"] = $value;
            if (strlen($criteria) > 2) {
                $criteria .= ",$key = :$key";

            } else {
                $criteria .= "$key = :$key";
            }
        }

        if (count($filters) > 0) {
            $sql = "SELECT $fields FROM $table WHERE ($criteria)";
        } else {
            $sql = "SELECT $fields FROM $table";
        }
        $stmt = $this->connection->prepare($sql);

        foreach ($key_values as $key => $value) {
            $stmt->bindValue($key, $value, is_integer($value) ? PDO::PARAM_INT : PDO::PARAM_STR);
        }
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function count($table, $filters = null)
    {

    }

    public function rawQuery($sql)
    {
        $stmt = $this->connection->prepare($sql);

        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
