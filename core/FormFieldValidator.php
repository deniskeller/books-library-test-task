<?php

namespace BOOKSLibraryCORE;

class FormFieldValidator
{
  const VALIDATION_DEFAULTS = [
    'MAX_EMAIL_LENGTH' => 255,
    'MAX_FILE_SIZE' => 10 * 1024 * 1024, // 10MB в байтах
    'MAX_FILES' => 5,
    'FIELD_NAME' => 'Поле'
  ];

  protected $errors = [];

  // Валидация текста
  public static function text(
    ?string $value,
    array $options = []
  ): string {
    $required = $options['required'] ?? true;
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

  // Валидация select
  public static function select(
    $value,
    array $options = []
  ): string {
    $required = $options['required'] ?? true;
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
