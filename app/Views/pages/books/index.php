<?php
require_once COMPONENTS . '/header.php';
?>

    <div class="row mb-40">
        <div class="col-md-8 col-lg-9">
            <form class="row g-3">
                <div class="col-md-8">
                    <label for="authorFilter" class="form-label">Фильтр по автору</label>
                    <select id="authorFilter" name="book-filter-author" class="form-select">
                        <option selected value="">Все авторы</option>
                        <option value="1">Александр Сергеевич Пушкин</option>
                        <option value="2">Лев Николаевич Толстой</option>
                        <option value="3">Фёдор Михайлович Достоевский</option>
                    </select>
                </div>
                <div class="col-md-4 d-flex align-items-end">
                    <button type="submit" class="btn btn-primary w-100">
                        Применить фильтр
                    </button>
                </div>
            </form>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="table-responsive">
                <?php if (!empty($books)) : ?>
                    <table class="table table-hover align-middle">
                        <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>Название книги</th>
                            <th>Автор(ы)</th>
                            <th>Год издания</th>
                            <th>Действия</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($books as $index => $book) : ?>
                            <tr>
                                <th><?= $index + 1 ?></th>
                                <td><?= $book['title'] ?></td>
                                <td>Александр Сергеевич Пушкин</td>
                                <td><?= $book['year'] ?></td>
                                <td>
                                    <div class="action-buttons">
                                        <a href="/books/edit?id=<?= $book['id'] ?>"
                                           class="btn btn-sm btn-outline-primary">
                                            <i class="bi bi-pencil"></i> Редактировать
                                        </a>
                                        <a href="/books/destroy?id=<?= $book['id'] ?>"
                                           class="btn btn-sm btn-outline-danger"
                                           onclick="return confirm('Удалить этого автора?')">
                                            <i class="bi bi-trash"></i> Удалить
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                        </tbody>
                    </table>
                <?php else : ?>
                    <div class="emtry">Список книг пуст</div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <div class="row mt-4">
        <div class="col-12">
            <a href="books/create" class="btn btn-success">
                <i class="bi bi-plus-circle"></i> Добавить новую книгу
            </a>
        </div>
    </div>


<?php
require_once COMPONENTS . '/footer.php';
?>