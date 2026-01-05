<?php
require_once COMPONENTS . '/header.php';
?>


<div class="row">
    <h1><?= isset($book) ? 'Редактирование книги' : 'Добавление книги' ?></h1>

    <form method="POST" action="books/<?= isset($book) ? 'update?id=' . $book['id'] : 'store' ?>">
        <div class="mb-3">
            <label for="title" class="form-label">Название книги</label>
            <input type="text" class="form-control" id="title" name="title"
                   value="<?= isset($book) ? htmlspecialchars($book['title']) : '' ?>" required>
        </div>

        <div class="mb-3">
            <label for="year" class="form-label">Год издания</label>
            <input type="text" class="form-control" id="year" name="year"
                   value="<?= isset($book) ? htmlspecialchars($book['year']) : '' ?>" required>
        </div>

        <div class="mb-3">
            <label for="authors" class="form-label">Авторы *</label>
            <select multiple class="form-control" id="authors" name="authors[]" required size="1">
                <?php if (!empty($authors)) : ?>
                    <?php foreach ($authors as $author) : ?>
                        <option value="1"><?= htmlspecialchars($author['name']) ?></option>
                    <?php endforeach; ?>
                <?php endif; ?>
            </select>
            <div class="form-text">Для выбора нескольких авторов удерживайте Ctrl</div>
        </div>

        <button type="submit" class="btn btn-primary">
            <?= isset($book) ? 'Сохранить' : 'Добавить' ?>
        </button>
        <a href="/books" class="btn btn-secondary">Отмена</a>
    </form>
</div>
