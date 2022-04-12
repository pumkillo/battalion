<?php
require_once(__DIR__ . '/../Core/Traits/DbTrait.php');
require_once(Loader::load('db_trait'));

class Query
{
    use dbConnection {
        connect as private;
    }
    private $table = '';
    private $mysqli = 'db_connection';

    function __construct(string $tablename)
    {
        $this->table = $tablename;
        $this->mysqli = $this->connect();
    }

    public static function table(string $tablename)
    {
        return new Query($tablename);
    }

    public function where(string $condition, string $select = "*"): array
    {
        return $this->mysqli->query("SELECT $select  FROM " . $this->table . " WHERE $condition")->fetch_all($mode = MYSQLI_ASSOC);
    }

    public function all(): array
    {
        return $this->mysqli->query('SELECT * FROM ' . $this->table)->fetch_all($mode = MYSQLI_ASSOC);
    }

    public function insert(array $data): bool
    {
        $columns = '';
        $values = '';
        foreach ($data as $key => $value) {
            $columns .= $key . ", ";
            $values .= "'" . $value . "', ";
        }
        $columns = substr($columns, 0, -2);
        $values = substr($values, 0, -2);
        return (bool)$this->mysqli->query("INSERT INTO " . $this->table . " ($columns) VALUES ($values)");
    }

    public function delete(string $condition = ''): bool
    {
        $condition = $condition == '' ? $condition : "WHERE $condition";
        return (bool)$this->mysqli->query("DELETE FROM " . $this->table . " $condition");
    }

    public function update(array $data, string $condition, string $whereCondition = "="): bool
    {
        $newData = '';
        foreach ($data as $key => $value) {
            if (preg_match_all("/[\*\/%\+\-]/", $value)){
                $newData .=  " $key $whereCondition $value, ";
                continue;
            }
            $newData .=  " $key $whereCondition '$value', ";
        }
        $newData = substr($newData, 0, -2);
        return (bool)$this->mysqli->query("UPDATE " . $this->table . " SET $newData WHERE $condition");
    }

    public function lastId(): string
    {
        return (string)$this->mysqli->insert_id;
    }
}
