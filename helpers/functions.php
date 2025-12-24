<?php

use JetBrains\PhpStorm\NoReturn;

function dump_v($data): void
{
    echo "<pre>";
    var_dump($data);
    echo "</pre>";
}


#[NoReturn]
function dd_v($data): void
{
    dump_v($data);
    die;
}


#[NoReturn]
function abort($code = 400): void
{
    http_response_code($code);
    require VIEWS . '/errors/' . $code . '.php';
    die;
}

function print_array($array): void
{
    echo '<pre>' . print_r($array, true) . '</pre>';
}


function createTableIfNotExists($pdo, $table_name, $sql_create_table)
{
    try {
        $pdo->exec($sql_create_table);

        $stmt = $pdo->prepare("SHOW TABLES LIKE ?");
        $stmt->execute([$table_name]);

        if ($stmt->fetch()) {
            return [
                'success' => true,
                'message' => "Таблица '$table_name' готова.",
                'table' => $table_name
            ];
        } else {
            return [
                'success' => false,
                'message' => "Не удалось создать таблицу '$table_name'."
            ];
        }
    } catch (PDOException $e) {
        return [
            'success' => false,
            'message' => "Ошибка при работе с таблицей '$table_name': " . $e->getMessage()
        ];
    }
}