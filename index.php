<?php
require_once(__DIR__ . '/App/Loader.php');
require_once(Loader::load('middlewares'));
require_once(Middlewares::getClass('auth'));
AuthMiddleware::check();

require_once(Loader::load('query'));
require_once(Loader::load('constants'));
require_once(Loader::load('messages'));
?>

<!DOCTYPE html>
<html lang="ru">

<head>
    <?php
    require_once(Loader::load('views') . 'patterns/head.php');
    ?>
    <title>Главная</title>
</head>


<body>
    <div class="container">
        <?php
        require_once(Loader::load('views') . 'patterns/header.php');
        $staff = Query::table('staff')->all();
        if (count($staff) !== 0) :
        ?>
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">#id</th>
                        <th scope="col">Фамилия</th>
                        <th scope="col">Имя</th>
                        <th scope="col">Отчество</th>
                        <th scope="col">Дата рождения</th>
                        <th scope="col">Рота</th>
                        <th scope="col">Взвод</th>
                        <th scope="col">Отделение</th>
                        <th scope="col"></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($staff as $member) :
                        $division = Query::table('divisions')->where("id LIKE '" . $member['division_id'] . "'")[0] ?? null;
                        $platoon = isset($division['platoon_id']) ? Query::table('platoons')->where("id LIKE '" . $division['platoon_id'] . "'")[0] ?? null : null;
                        $company = isset($platoon['company_id']) ? Query::table('companies')->where("id LIKE '" . $platoon['company_id'] . "'")[0] ?? null : null;
                    ?>
                        <tr>
                            <th scope="row"><?= $member['id'] ?></th>
                            <td><?= $member['name'] ?></td>
                            <td><?= $member['surname'] ?></td>
                            <td><?= $member['patronymic'] ?></td>
                            <td><?= date('d.m.Y', strtotime($member['birthdate'])) ?></td>
                            <td><?= $company['name'] ?? Messages::renderError('Не найдено') ?></td>
                            <td><?= $platoon['name'] ?? Messages::renderError('Не найдено') ?></td>
                            <td><?= $division['name'] ?? Messages::renderError('Не найдено') ?></td>
                            <td><a href="<?= Router::get('fire') . "?id=" . $member['id'] ?>" class="btn btn-danger btn-sm">Уволить</a></td>
                        </tr>
                    <?php endforeach; ?>
                <tbody>
            </table>
        <?php else : ?>
            <p>В базе данных нет ни одного сотрудника</p>
        <?php endif; ?>
    </div>
    <?php require_once(Loader::load('views') . 'patterns/footer.php'); ?>
</body>

</html>