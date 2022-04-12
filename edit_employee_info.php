<?php
require_once(__DIR__ . '/App/Loader.php');
require_once(Loader::load('middlewares'));
require_once(Middlewares::getClass('auth'));
AuthMiddleware::check();

require_once(Loader::load('router'));
require_once(Loader::load('constants'));
require_once(Loader::load('validators'));
require_once(Loader::load('query'));
require_once(Loader::load('messages'));
?>

<!DOCTYPE html>
<html lang="ru">

<head>
    <?php
    require_once(Loader::load('views') . 'patterns/head.php');
    ?>
    <title>Перевод сотрудника</title>
</head>


<body>
    <div class="container">
        <?php
        $member = isset($_GET['id']) ?  Query::table('staff')->where("id LIKE '" . $_GET['id'] . "'")[0] ?? null : [];

        if (!empty($_POST)) {
            if ($_POST['division_id'] != $member['division_id']) {
                if (Query::table('staff')->update([
                    'division_id' => $_POST['division_id'],
                ], "id LIKE '" . $_GET['id'] . "'")) {
                    Router::redirect('main');
                }
                $message = 'Ошибка перевода сотрудника';
            }
        }
        require_once(Loader::load('views') . 'patterns/header.php');
        if ((bool)$member) :
        ?>
            <form method="post" class="container">
                <p><?= $_POST['name'] ?? '' ?> <?= $_POST['surname'] ?? '' ?> <?= $_POST['patronymic'] ?? '' ?></p>
                <div class="mb-3">
                    <label for="division_id" class="form-label">Отделение</label>
                    <?php
                    $divisions = Query::table('divisions')->all();
                    if (count($divisions) !== 0) :
                    ?>
                        <select name="division_id" id="division_id" class="form-select">
                            <?php foreach ($divisions as $division) : ?>
                                <option value="<?= $division['id'] ?>" <?= $division['id'] == $member['division_id'] ? 'selected' : '' ?>><?= $division['name'] ?></option>
                            <?php endforeach; ?>
                        <?php else :
                        Messages::renderError('Нет ни одного взвода в базе данных');

                    endif; ?>
                        </select>
                </div>
                <?php
                if (isset($message)) {
                    Messages::renderError($message);
                }
                ?>
                <input type="submit" value="Сохранить" class="btn btn-primary">
            </form>
        <?php elseif ($member === null) :
            Messages::renderError('Такого сотрудника нет в базе данных');
        elseif ($member === []) :
            Messages::renderError('Отсутсвует обязательный параметр id');
        ?>
        <?php endif; ?>
    </div>
    <?php require_once(Loader::load('views') . 'patterns/footer.php'); ?>
</body>