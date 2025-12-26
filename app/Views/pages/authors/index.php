<?php
require_once COMPONENTS . '/header.php';
?>

<div class="row">
    <div class="col-12">
        <div class="table-responsive">
            <?php if (!empty($authors)) : ?>
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


                    <?php foreach ($authors as $index => $author) : ?>
                        <tr>
                            <th><?= $index + 1 ?></th>
                            <td><?= $author['name'] ?></td>
                            <td>1833</td>
                            <td>
                                <div class="action-buttons">
                                    <a href="/authors/edit?id=<?= $author['id'] ?>"
                                       class="btn btn-sm btn-outline-primary">
                                        <i class="bi bi-pencil"></i> Редактировать
                                    </a>
                                    <a href="/authors/destroy?id=<?= $author['id'] ?>"
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
                <div class="emtry">Список авторов пуст</div>
            <?php endif; ?>
        </div>
    </div>
</div>

<div class="row mt-4">
    <div class="col-12">
        <a href="authors/create" class="btn btn-success">
            <i class="bi bi-plus-circle"></i> Добавить нового автора
        </a>
    </div>
</div>

<?php
require_once COMPONENTS . '/footer.php';
?>
