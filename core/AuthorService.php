<?php

namespace BOOKSLibraryCORE;

use BOOKSLibraryCORE\FormFieldValidator;

class AuthorService
{
  public function validateAuthorData(array $data): array
  {
    $errors = [];

    $errors['name'] = FormFieldValidator::text($data['name'], [
      'fieldName' => 'ФИО автора',
      'minLength' => 2,
      'maxLength' => 255,
    ]);

    return array_filter($errors);
  }
}
