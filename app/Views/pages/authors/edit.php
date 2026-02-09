<?php
require_once COMPONENTS . '/header.php';
?>

<div class="row">
    <h1><?= isset($author) ? 'Редактирование автора' : 'Добавление автора' ?></h1>

    <form method="POST" action="<?= isset($author) ? '/authors/' . $author['id'] : '/authors/store' ?>">
        <!-- Для PUT запроса при редактировании -->
        <?php if (isset($author)) : ?>
            <input type="hidden" name="_method" value="PUT">
        <?php endif; ?>

        <div class="mb-3">
            <label for="name" class="form-label">ФИО</label>
            <input type="text" class="form-control" id="name" name="name"
                value="<?= getFormValue('name', $_SESSION['old_data'] ?? [], $author ?? null) ?>">

            <?php showError('name'); ?>
        </div>

        <button type="submit" class="btn btn-primary">
            <?= isset($author) ? 'Сохранить' : 'Добавить' ?>
        </button>
        <a href="/authors" class="btn btn-secondary">Отмена</a>
    </form>
</div>
