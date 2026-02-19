<?php

function dump_v($data): void
{
    echo "<pre>";
    var_dump($data);
    echo "</pre>";
}

function dd_v($data): void
{
    dump_v($data);
    die;
}

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


// функция создания таблицы
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

//обработка входящего массива полей из формы
function loadDataFormFields($fillable = []): array
{
    $data = [];

    foreach ($_POST as $key => $value) {
        if (in_array($key, $fillable)) {
            $data[$key] = trim($value);
        }
    }
    return $data;

    //    return array_filter($_POST, function ($key) use ($fillable) {
    //        return in_array($key, $fillable);
    //    }, ARRAY_FILTER_USE_KEY);
}


//вывод значения в поле ввода
function oldFieldValue($fieldName): string
{
    return isset($_POST[$fieldName]) ? htmlspecialchars($_POST[$fieldName], ENT_QUOTES) : '';
}


function redirect($url = '')
{
    if ($url) {
        $redirect = $url;
    } else {
        $redirect = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : PATH;
    }

    header("Location: {$redirect}");
    die;
}


function getFormValue($field, $oldData, $param = null, $default = '')
{
    if (isset($oldData[$field])) {
        return htmlspecialchars($oldData[$field]);
    }

    if (isset($param[$field])) {
        return htmlspecialchars($param[$field]);
    }

    return $default;
}

function getSelectedAuthorIds($book = null)
{
    $selectedAuthorIds = [];
    $oldData = $_SESSION['old_data'] ?? [];

    // из SESSION
    if (isset($oldData['authors_ids'])) {
        $selectedAuthorIds = $oldData['authors_ids'];
        // из POST
    } elseif (isset($_POST['authors_ids'])) {
        $selectedAuthorIds = $_POST['authors_ids'];
    } elseif (isset($book['authors'])) {
        // из БД
        foreach ($book['authors'] as $author) {
            $selectedAuthorIds[] = $author['id'];
        }
    }

    return $selectedAuthorIds;
}

function showError($field)
{
    if (isset($_SESSION['errors'][$field])) {
        echo '<span style="color: red">' . $_SESSION['errors'][$field] . '</span>';
    }
}


function getAlert()
{
    if (!empty($_SESSION['success']) or !empty($_SESSION['error'])) {
        require_once COMPONENTS . '/alert.php';
        unset($_SESSION['success']);
        unset($_SESSION['error']);
    }
}
