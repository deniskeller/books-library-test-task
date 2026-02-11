<?php

namespace BOOKSLibraryCORE;

use Exception;

class View
{
  private static string $viewPath;
  private static ?array $data = [];

  private static function getPath(string $view): string
  {
    $view = str_replace('.', '/', $view);
    // dump($_SERVER['DOCUMENT_ROOT']);
    $path = str_replace('public', 'app/Views/pages/', $_SERVER['DOCUMENT_ROOT']);
    // dump($path);
    $fullPath = $path . $view;
    // dump($fullPath);

    if (!str_ends_with($view, '.php')) {
      $fullPath .= '.php';
    }

    if (!file_exists($fullPath)) {
      throw new Exception("View файл не найден: {$view}");
    }

    // dump($fullPath);
    return $fullPath;
  }

  private static function getContent(): string
  {
    extract(self::$data);
    ob_start();
    include self::$viewPath;
    $html = ob_get_contents();
    ob_end_clean();
    return $html;
  }

  public static function make(string $view, array $data = []): string
  {
    self::$data = $data;
    self::$viewPath = self::getPath($view);
    return self::getContent();
  }

  public static function render(string $view, array $data = []): void
  {
    echo self::make($view, $data);
  }
}
