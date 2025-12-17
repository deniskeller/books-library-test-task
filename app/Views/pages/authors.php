<?php
require_once CONTROLLERS . '/AuthorsController.php';
require_once COMPONENTS . '/header.php';
?>

<main class="container main">
    <div class="row">
        <div class="col-12">
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>ФИО</th>
                        <th>Количество книг</th>
                        <th>Действия</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <th>1</th>
                        <td>Александр Сергеевич Пушкин</td>
                        <td>1833</td>
                        <td>
                            <div class="action-buttons">
                                <a href="#" class="btn btn-sm btn-outline-primary">
                                    <i class="bi bi-pencil"></i> Редактировать
                                </a>
                                <button type="button" class="btn btn-sm btn-outline-danger">
                                    <i class="bi bi-trash"></i> Удалить
                                </button>
                            </div>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="row mt-4">
        <div class="col-12">
            <button type="button" class="btn btn-success">
                <i class="bi bi-plus-circle"></i> Добавить нового автора
            </button>
        </div>
    </div>
</main>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI"
        crossorigin="anonymous"></script>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">

</body>
</html>