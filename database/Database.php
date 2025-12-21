<?php

namespace database;
class Database
{

    private $pdo;

    public function __construct(
        private string $driver = 'mysql',
        private string $host,
        private string $database,
        private string $charset = 'utf8mb4',
        private string $username,
        private string $password = '',
        private array  $options = []
    )
    {
    }

    public function fetchAll(string $sql, array $params = []): array
    {
        return $this->query($sql, $params)->fetchAll();
    }

    public function query(string $sql, array $params = []): PDOStatement
    {
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute($params);
        return $stmt;
    }

    public function connect(): PDO
    {
        if ($this->pdo === null) {
            $dsn = "{$this->driver}:host={$this->host};dbname={$this->database};charset={$this->charset}";

            try {
                $this->pdo = new PDO($dsn, $this->username, $this->password, $this->options);
            } catch (PDOException $e) {
                throw new PDOException("Ошибка подключения к базе данных: " . $e->getMessage());
            }
        }

        return $this->pdo;
    }

    public function fetchOne(string $sql, array $params = []): ?array
    {
        return $this->query($sql, $params)->fetch() ?: null;
    }

    public function insert(string $table, array $data): int
    {
        $columns = implode(', ', array_keys($data));
        $placeholders = implode(', ', array_fill(0, count($data), '?'));

        $sql = "INSERT INTO {$table} ({$columns}) VALUES ({$placeholders})";
        $this->query($sql, array_values($data));

        return (int)$this->connect()->lastInsertId();
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


    public function __destruct()
    {
        $this->close();
    }

    public function close(): void
    {
        $this->pdo = null;
    }
}