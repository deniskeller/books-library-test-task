<?php

namespace BOOKSLibraryMIDDLEWARE;

class RoleMiddleware
{
  public function handle($role = 'user')
  {
    if ($_SESSION['user_role'] !== 'admin') {
      echo "Доступ запрещен. Требуется роль админ";
      exit;
    }
  }
}
