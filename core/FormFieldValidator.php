<?php

namespace BOOKSLibraryCORE;

class FormFieldValidator
{
  protected $errors = [];

  public function validate($data = [], $rules = [])
  {
    dump($data);
    dump($rules);
  }


  const VALIDATION_DEFAULTS = [
    'MAX_EMAIL_LENGTH' => 255,
    'MAX_FILE_SIZE' => 10 * 1024 * 1024, // 10MB в байтах
    'MAX_FILES' => 5,
    'FIELD_NAME' => 'Поле'
  ];

  /**
   * Валидация текста
   */
  public static function text(
    ?string $value,
    array $options = []
  ): string {
    $required = $options['required'] ?? false;
    $fieldName = $options['fieldName'] ?? self::VALIDATION_DEFAULTS['FIELD_NAME'];
    $minLength = $options['minLength'] ?? 0;
    $maxLength = $options['maxLength'] ?? 10;
    $numbersAllowed = $options['numbersAllowed'] ?? false;
    $pattern = $options['pattern'] ?? null;

    $trimmedValue = trim($value ?? '');

    // Проверка на обязательность
    if ($required && empty($trimmedValue)) {
      return "{$fieldName} обязательно для заполнения";
    }

    // Если значение пустое и не обязательное - дальше не проверяем
    if (empty($trimmedValue)) {
      return '';
    }

    // Проверка HTML-тегов
    if (preg_match('/<[^>]*>/', $trimmedValue)) {
      return 'HTML-теги запрещены';
    }

    // Проверка минимальной длины
    if ($minLength > 0 && mb_strlen($trimmedValue) < $minLength) {
      return "{$fieldName} должно содержать минимум {$minLength} символов";
    }
    // Проверка максимальной длины
    if (mb_strlen($trimmedValue) > $maxLength) {
      return "{$fieldName} должно содержать максимум {$maxLength} символов";
    }

    // Проверка кастомного паттерна
    if ($pattern !== null && !preg_match($pattern, $trimmedValue)) {
      return "{$fieldName} содержит недопустимые символы";
    }

    // Стандартные проверки, если не указан кастомный паттерн
    if ($pattern === null && !$numbersAllowed) {
      // Проверка на цифры
      if (preg_match('/[0-9]/', $trimmedValue)) {
        return "{$fieldName} не должно содержать цифры";
      }

      // Проверка на запрещенные символы (только буквы, пробелы и дефисы)
      if (preg_match('/[^\p{L}\s-]/u', $trimmedValue)) {
        return "{$fieldName} содержит запрещённые символы";
      }
    }

    return '';
  }

  // Валидация email
  public static function email(
    ?string $value,
    array $options = []
  ): string {
    $required = $options['required'] ?? false;
    $fieldName = $options['fieldName'] ?? 'Email';

    // Проверка на обязательность
    if ($required && empty(trim($value ?? ''))) {
      return "{$fieldName} обязателен";
    }

    // Если значение пустое и не обязательное - дальше не проверяем
    $trimmedValue = trim($value ?? '');
    if (empty($trimmedValue)) {
      return '';
    }

    // Проверка на HTML-теги
    if (preg_match('/<[^>]*>/', $value)) {
      return 'HTML-теги запрещены';
    }

    // Проверка на кириллицу
    if (preg_match('/[а-яА-ЯёЁ]/u', $trimmedValue)) {
      return "{$fieldName} должен содержать только латинские буквы";
    }

    // Проверка длины
    if (strlen($trimmedValue) > self::VALIDATION_DEFAULTS['MAX_EMAIL_LENGTH']) {
      return "{$fieldName} не должен превышать " . self::VALIDATION_DEFAULTS['MAX_EMAIL_LENGTH'] . " символов";
    }

    // Проверка формата email
    $emailRegex = '/^[a-zA-Z0-9.!#$%&\'*+\/=?^_`{|}~-]+@[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?(?:\.[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?)*$/';

    if (!preg_match($emailRegex, $trimmedValue)) {
      $fieldNameLower = mb_strtolower($fieldName);
      return "Введите корректный {$fieldNameLower}";
    }

    return '';
  }

  /**
   * Валидация файлов
   */
  public static function file(
    $value,
    array $options = []
  ): string {
    $required = $options['required'] ?? false;
    $maxSize = $options['maxSize'] ?? self::VALIDATION_DEFAULTS['MAX_FILE_SIZE'];
    $allowedTypes = $options['allowedTypes'] ?? [];
    $maxFiles = $options['maxFiles'] ?? self::VALIDATION_DEFAULTS['MAX_FILES'];

    // Обработка массива файлов
    $files = [];
    if (is_array($value)) {
      $files = $value;
    } elseif (!empty($value)) {
      $files = [$value];
    }

    $hasFiles = !empty($files);

    if ($required && !$hasFiles) {
      return 'Файл обязателен для загрузки';
    }

    if (!$hasFiles) {
      return '';
    }

    if (count($files) > $maxFiles) {
      return "Максимальное количество файлов: {$maxFiles}";
    }

    // Проверка всех файлов
    foreach ($files as $file) {
      $error = self::validateSingleFile($file, $maxSize, $allowedTypes);
      if (!empty($error)) {
        return $error;
      }
    }

    return '';
  }

  /**
   * Валидация одиночного файла
   */
  private static function validateSingleFile(
    $file,
    int $maxSize,
    array $allowedTypes
  ): string {
    // Проверка на ошибки загрузки
    if (isset($file['error']) && $file['error'] !== UPLOAD_ERR_OK) {
      return 'Ошибка загрузки файла';
    }

    // Проверка размера
    if (isset($file['size']) && $file['size'] > $maxSize) {
      $maxSizeMB = round($maxSize / (1024 * 1024), 1);
      return "Максимальный размер файла: {$maxSizeMB}MB";
    }

    // Проверка типа файла
    if (!empty($allowedTypes) && isset($file['type'])) {
      if (!in_array($file['type'], $allowedTypes, true)) {
        $allowedTypesStr = implode(', ', $allowedTypes);
        return "Разрешены только файлы типов: {$allowedTypesStr}";
      }
    }

    return '';
  }

  /**
   * Валидация выбора (select)
   */
  public static function select(
    $value,
    array $options = []
  ): string {
    $required = $options['required'] ?? false;
    $fieldName = $options['fieldName'] ?? 'Поле';

    if ($required) {
      if (is_array($value)) {
        if (empty($value)) {
          return "{$fieldName} обязательно для выбора";
        }
      } elseif ($value === null || $value === '' || $value === false) {
        return "{$fieldName} обязательно для выбора";
      }
    }

    return '';
  }

  /**
   * Валидация телефона
   */
  public static function phone(
    ?string $value,
    array $options = []
  ): string {
    $required = $options['required'] ?? false;
    $fieldName = $options['fieldName'] ?? 'Телефон';

    // Проверка на обязательность
    if ($required && empty(trim($value ?? ''))) {
      return "{$fieldName} обязателен для заполнения";
    }

    // Если значение пустое и не обязательное - дальше не проверяем
    $trimmedValue = trim($value ?? '');
    if (empty($trimmedValue)) {
      return '';
    }

    if (!self::validatePhone($trimmedValue)) {
      return 'Введите корректный российский номер (+7 XXX XXX-XX-XX)';
    }

    return '';
  }

  /**
   * Валидация российского номера телефона
   */
  private static function validatePhone(string $phone): bool
  {
    // Убираем все нецифровые символы, кроме +
    $cleanedPhone = preg_replace('/[^\d+]/', '', $phone);

    // Проверяем форматы: +7..., 7..., 8...
    if (preg_match('/^(\+7|7|8)\d{10}$/', $cleanedPhone)) {
      return true;
    }

    return false;
  }

  /**
   * Валидация пароля
   */
  public static function password(
    ?string $value,
    array $options = []
  ): string {
    $required = $options['required'] ?? false;
    $fieldName = $options['fieldName'] ?? 'Пароль';
    $minLength = $options['minLength'] ?? 0;

    // Проверка на обязательность
    if ($required && empty(trim($value ?? ''))) {
      return "{$fieldName} обязательно для заполнения";
    }

    // Если значение пустое и не обязательное - дальше не проверяем
    $trimmedValue = trim($value ?? '');
    if (empty($trimmedValue)) {
      return '';
    }

    // Проверка минимальной длины
    if ($minLength > 0 && strlen($trimmedValue) < $minLength) {
      $charWord = $minLength === 1 ? 'символ' : ($minLength >= 2 && $minLength <= 4 ? 'символа' : 'символов');
      return "{$fieldName} должно содержать минимум {$minLength} {$charWord}";
    }

    // Проверка на наличие цифры
    if (!preg_match('/\d/', $trimmedValue)) {
      return 'Пароль должен иметь хотя бы одну цифру';
    }

    // Проверка на наличие буквы
    if (!preg_match('/[a-zа-яё]/iu', $trimmedValue)) {
      return 'Пароль должен иметь хотя бы одну букву';
    }

    // Проверка на пробелы
    if (preg_match('/\s/', $trimmedValue)) {
      return 'Пароль не должен содержать пробелы';
    }

    return '';
  }
}
