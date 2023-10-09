<?php

namespace db;

use PDO;

class DatabaseConn extends DatabaseConfig
{
    private $pdo;
    public function __construct()
    {
        try {

            $this->pdo = new \PDO($this->getDsn(), DatabaseConfig::$username, DatabaseConfig::$password);
            $this->pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
        } catch (\PDOException $e) {
            echo "Database error<br>";
            echo $e->getMessage();
        }

    }
    private function getDsn() {
        $host = DatabaseConfig::$servername;
        $dbname = DatabaseConfig::$database;
        $charset = DatabaseConfig::$charset;
        return "mysql:host=$host; dbname=$dbname; charset=$charset";
    }
    protected function getConn() {
        return $this->pdo;
    }

    protected function query($statement, $allRows = false, $oneRows = false) {
        try {
            if ($allRows) {
                return $this->getConn()->query($statement)->fetchAll(PDO::FETCH_ASSOC);
            } elseif ($oneRows) {
                return $this->getConn()->query($statement)->fetch(PDO::FETCH_ASSOC);
            } else {
                $this->getConn()->query($statement);
            }
        } catch (\PDOException $e) {
            echo "Query error<br>";
            echo $e->getMessage();
        }
    }

}