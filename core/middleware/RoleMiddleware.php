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
      // dump($_SESSION['current_url']);
      $_SESSION['error'] = 'У вас нет прав доступа для этих дейтвий';
      back();
    }
  }
}
