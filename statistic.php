<?php
class Dashboard
{
    private $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    public function getCount($table, $column)
    {
        $stmt = $this->pdo->query("SELECT COUNT($column) AS count FROM $table");
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['count'];
    }

    public function getCountP($table, $column)
    {
        $stmt = $this->pdo->query("SELECT COUNT($column) AS count FROM $table WHERE UserRole='product_owner'");
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['count'];
    }

    public function getCountS($table, $column)
    {
        $stmt = $this->pdo->query("SELECT COUNT($column) AS count FROM $table WHERE UserRole='scrum_master'");
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['count'];
    }
}
?>