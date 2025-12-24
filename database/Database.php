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

    public static function getInstance(): ?PDO
    {
        if (!self::$instance) {
            self::$instance = new Database();
        }
        return self::$instance->connection;
    }
}