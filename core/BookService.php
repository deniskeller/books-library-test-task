<?php

namespace BOOKSLibraryCORE;

use BOOKSLibraryCORE\FormFieldValidator;

class BookService
{
  public function validateBookData(array $data): array
  {
    $errors = [];

    $errors['title'] = FormFieldValidator::text($data['title'], [
      'fieldName' => 'Название книги',
      'minLength' => 2,
      'maxLength' => 10,
    ]);

    $errors['year'] = FormFieldValidator::text($data['year'], [
      'fieldName' => 'Год',
      'numbersAllowed' => true,
      'pattern' => '/^[0-9]+$/'
    ]);

    $errors['authors_ids'] = FormFieldValidator::select($data['authors_ids'] ?? [], [
      'fieldName' => 'Авторы'
    ]);

    return array_filter($errors);
  }
}
