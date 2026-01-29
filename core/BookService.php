<?php

use BOOKSLibraryCORE\FormFieldValidator;

class BookService
{
  public function validateBookData(array $data): array
  {
    $errors = [];

    if (!empty($data['firstName'])) {
      $errors['firstName'] = FormFieldValidator::text($data['firstName'], [
        'required' => false,
        'fieldName' => 'Имя',
        'minLength' => 2
      ]);
    }

    return array_filter($errors);
  }
}
