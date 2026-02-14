<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <base href="<?= PATH ?>/">
    <title>Books Library - <?= $title ?? '' ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">

    <style>
        .main {
            margin-top: 40px;
        }

        .mb-40 {
            margin-bottom: 40px;
        }
    </style>
</head>

<body>


    <header class="header">
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
            <div class="container">
                <a class="navbar-brand" href="#">Books Library</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                    aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                        <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="/">Книги</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="/authors">Авторы</a>
                        </li>
                    </ul>

                    <ul class="d-flex text-white align-items-center list-unstyled m-0">
                        <?php if (isset($_SESSION['user_id'])) : ?>
                            <li><a class="nav-link"><?php $_SESSION['user_id'] ?></a></li>
                            <li><a class="nav-link" href="/logout">Выход</a></li>
                        <?php else : ?>
                            <li><a class="nav-link" href="/login">Вход</a></li>
                            <li><a class="nav-link" href="/registration">Регистрация</a></li>
                        <?php endif ?>
                    </ul>
                </div>
            </div>
        </nav>
    </header>

    <?php getAlert() ?>

    <main class="container main">
