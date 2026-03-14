<?php

namespace BOOKSLibraryMIDDLEWARE;

class RoleMiddleware
{
  public function handle($role = 'user')
  {
    // dump($role);
    // echo 'запуска миддлвера роль';
    if ($_SESSION['user_role'] !== 'admin') {
      // echo "Доступ запрещен. Требуется роль админ";
      // dd($_SERVER);
      $_SESSION['error'] = 'У вас нет прав доступа для этих дейтвий';
      back();
      // exit;
    }
  }
}
