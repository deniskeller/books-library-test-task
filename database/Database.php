<?php

namespace BOOKSLibraryDATABASE;

use PDO;
use PDOException;

class Database
{
    private static ?Database $instance = null;
    private ?PDO $connection = null;
    private array $config = [];
    private array $options = [];

    private function __construct()
    {
        $this->config = require ROOT . '/config/database.php';
        $connectionConfig = $this->config['connections']['mysql'];

        $defaultOptions = [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false
        ];

        $this->options = array_merge(
            $defaultOptions,
            $connectionConfig['options'] ?? []
        );

        try {
            $dsn = "{$connectionConfig['driver']}:host={$connectionConfig['host']};dbname={$connectionConfig['database']};charset={$connectionConfig['charset']}";

            $this->connection = new PDO(
                $dsn,
                $connectionConfig['username'],
                $connectionConfig['password'],
                $this->options
            );

        } catch (PDOException $e) {
            error_log('Ошибка подключения к базе данных: ' . $e->getMessage());
            throw new PDOException("Ошибка подключения к базе данных. Проверьте конфигрурацию.", 0, $e);
        }
    }

    public static function getInstance(): ?Database
    {
        if (!self::$instance) {
            self::$instance = new Database();
        }
        return self::$instance;
    }

    public function getConnection(): ?PDO
    {
        return $this->connection;
    }

    public function query(string $sql, array $params = []): bool|\PDOStatement
    {
        $stmt = $this->connection->prepare($sql);
        $stmt->execute($params);
        return $stmt;
    }

    public function fetchAll(string $sql, array $params = []): array
    {
        return $this->query($sql, $params)->fetchAll();
    }

    public function fetch(string $sql, array $params = [])
    {
        return $this->query($sql, $params)->fetch();
    }

    public function fetchColumn(string $sql, array $params = []): mixed
    {
        return $this->query($sql, $params)->fetchColumn();
    }

    public function insert(string $table, array $data): int
    {
        $columns = implode(', ', array_keys($data));
        $placeholders = implode(', ', array_fill(0, count($data), '?'));

        $sql = "INSERT INTO {$table} ({$columns}) VALUES ({$placeholders})";
        $this->query($sql, array_values($data));

        return (int)$this->connection->lastInsertId();
    }

    public function delete(string $table, string $where, array $whereParams = []): int
    {
        $sql = "DELETE FROM {$table} WHERE {$where}";
        $stmt = $this->query($sql, $whereParams);

        return $stmt->rowCount();
    }

    public function exists(string $table, string $where, array $params = []): bool
    {
        $sql = "SELECT COUNT(*) FROM {$table} WHERE {$where}";
        return $this->fetchColumn($sql, $params) > 0;
    }

    public function update(string $table, array $data, string $where, array $whereParams = []): int
    {
        $set = [];
        $params = [];
        foreach ($data as $column => $value) {
            $set[] = "{$column} = ?";
            $params[] = $value;
        }

        $setClause = implode(', ', $set);
        $params = array_merge($params, $whereParams);

        $sql = "UPDATE {$table} SET {$setClause} WHERE {$where}";
        $stmt = $this->query($sql, $params);

        return $stmt->rowCount();
    }
}