<?php
require_once COMPONENTS . '/header.php';
?>

<form class="col-12 col-md-6" method="POST" action="/registration">
  <h1 class="fs-2">Регистрация</h1>
  <div class="mb-3">
    <label for="email" class="form-label">Email</label>
    <input type="email" class="form-control" id="email" aria-describedby="emailHelp">
    <!-- <div id="emailHelp" class="form-text">We'll never share your email with anyone else.</div> -->
  </div>

  <div class="mb-3">
    <label for="password" class="form-label">Пароль</label>
    <input type="password" class="form-control" id="password">
  </div>

  <button type="submit" class="btn btn-primary">Регистрация</button>
  <a class="ml-2" href="/">На главную</a>
</form>

<?php
require_once COMPONENTS . '/footer.php';
?>
