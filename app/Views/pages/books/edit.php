<?php
require_once COMPONENTS . '/header.php';

$selectedAuthorIds = [];
// dump($_SESSION['data']);

if (isset($_POST['authors_ids'])) {
    $selectedAuthorIds = $_POST['authors_ids'];
} elseif (isset($book['authors'])) {
    foreach ($book['authors'] as $author) {
        $selectedAuthorIds[] = $author['id'];
    }
}
?>


<div class="row">
    <h1><?= isset($book) ? 'Редактирование книги' : 'Добавление книги' ?></h1>

    <form method="POST" action="books/<?= isset($book) ? 'update?id=' . $book['id'] : 'store' ?>">
        <div class="mb-3">
            <label for="title" class="form-label">Название книги</label>
            <input type="text" class="form-control" id="title" name="title"
                value="<?= isset($book) ? htmlspecialchars($book['title']) : '' ?>">

            <?php if (isset($_SESSION['errors']['title'])): ?>
                <span style="color: red"><?= $_SESSION['errors']['title'] ?></span>
            <?php endif; ?>
        </div>

        <div class="mb-3">
            <label for="year" class="form-label">Год издания</label>
            <input type="text" class="form-control" id="year" name="year"
                value="<?= isset($book) ? htmlspecialchars($book['year']) : '' ?>">

            <?php if (isset($_SESSION['errors']['year'])): ?>
                <span style="color: red"><?= $_SESSION['errors']['year'] ?></span>
            <?php endif; ?>
        </div>

        <?php if (!empty($authors)) : ?>
            <div class="mb-3">
                <label for="authors_ids" class="form-label">Авторы</label>

                <select multiple class="form-control" id="authors_ids" name="authors_ids[]" size="1">
                    <?php foreach ($authors as $author) : ?>
                        <option value="<?= $author['id'] ?>" <?= in_array($author['id'], $selectedAuthorIds) ? 'selected' : '' ?>>
                            <?= htmlspecialchars($author['name']) ?></option>
                    <?php endforeach; ?>
                </select>

                <?php if (isset($_SESSION['errors']['authors_ids'])): ?>
                    <span style="color: red"><?= $_SESSION['errors']['authors_ids'] ?></span>
                <?php endif; ?>
            </div>
        <?php endif; ?>

        <button type="submit" class="btn btn-primary">
            <?= isset($book) ? 'Сохранить' : 'Добавить' ?>
        </button>
        <a href="/books" class="btn btn-secondary">Отмена</a>
    </form>
</div>
