<?php

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
