<?php
require_once COMPONENTS . '/header.php';
?>

<form class="col-12 col-md-6" method="POST" action="/registration/store">
  <h1 class="fs-2">Регистрация</h1>

  <div class="mb-3">
    <label for="username" class="form-label">Логин</label>
    <input type="text" class="form-control" name="username" id="username" aria-describedby="usernameHelp">
    <!-- <div id="usernameHelp" class="form-text">We'll never share your username with anyone else.</div> -->
  </div>

  <div class="mb-3">
    <label for="password" class="form-label">Пароль</label>
    <input type="text" class="form-control" id="password" name="password">
  </div>

  <button type="submit" class="btn btn-primary">Регистрация</button>
  <a class="ml-2" href="/">На главную</a>
</form>

<?php
require_once COMPONENTS . '/footer.php';
?>
