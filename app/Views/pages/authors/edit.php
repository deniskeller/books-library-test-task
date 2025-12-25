<?php
require_once COMPONENTS . '/header.php';
?>


<div class="row">
    <h1><?= isset($author) ? 'Редактирование автора' : 'Добавление автора' ?></h1>

    <form method="POST" action="authors/<?= isset($author) ? 'update?id=' . $author['id'] : 'store' ?>">
        <div class="mb-3">
            <label for="name" class="form-label">ФИО</label>
            <input type="text" class="form-control" id="name" name="name"
                   value="<?= isset($author) ? htmlspecialchars($author['name']) : '' ?>" required>
        </div>

        <button type="submit" class="btn btn-primary">
            <?= isset($author) ? 'Сохранить' : 'Добавить' ?>
        </button>
        <a href="/authors" class="btn btn-secondary">Отмена</a>
    </form>
</div>
