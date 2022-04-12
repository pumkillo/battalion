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
    <title>Добавление нового сотрудника</title>
</head>


<body>
    <div class="container">
        <?php
        $errors = [];

        if (!empty($_POST)) {
            $validator = new Validators($_POST, [
                'name' => ['required', 'min_max:,2,20', 'russian'],
                'surname' => ['required', 'min_max:,2,20', 'russian'],
                'patronymic' => ['required', 'min_max:,2,20', 'russian'],
                'birthdate' => ['required', 'birthdate'],
            ]);

            if (!isset($_POST['division_id'])) {
                $message = 'Вы не можете добавить сотрудника';
            } else {
                if ($validator->fails()) {
                    $errors = $validator->errors();
                } else {
                    $date = strtotime($_POST['birthdate']);
                    $formatDate  = date('Y-m-d H:i:s', $date);
                    if (Query::table('staff')->insert([
                        'name' => $_POST['name'],
                        'surname' => $_POST['surname'],
                        'patronymic' => $_POST['patronymic'],
                        'birthdate' => $formatDate,
                        'sex' => $_POST['sex'],
                        'division_id' => $_POST['division_id'],
                    ])) {
                        Router::redirect('main');
                    }
                    $message = 'Ошибка добавления сотрудника';
                }
            }
        }
        require_once(Loader::load('views') . 'patterns/header.php');
        ?>
        <form method="post" class="container">
            <div class="row">
                <div class="col-sm">
                    <label for="name" class="form-label">Имя сотрудника</label>
                    <input type="text" name="name" class="form-control" id="name" placeholder="Иван" value="<?= $_POST['name'] ?? '' ?>">
                    <?php Messages::renderErrors($errors, 'name'); ?>
                </div>
                <div class="col-sm-7">
                    <label for="surname" class="form-label">Фамилия сотрудника</label>
                    <input type="text" name="surname" class="form-control" id="surname" placeholder="Иванов" value="<?= $_POST['surname'] ?? '' ?>">
                    <?php Messages::renderErrors($errors, 'surname'); ?>
                </div>
            </div>
            <div class="mb-3">
                <label for="patronymic" class="form-label">Отчество сотрудника</label>
                <input type="text" name="patronymic" class="form-control" id="patronymic" placeholder="Иванович" value="<?= $_POST['patronymic'] ?? '' ?>">
                <?php Messages::renderErrors($errors, 'patronymic'); ?>
            </div>
            <div class="row">
                <div class="col">
                    <label for="birthdate" class="form-label">Дата рождения сотрудника</label>
                    <input type="date" name="birthdate" class="form-control" id="birthdate" value="<?= $_POST['birthdate'] ?? '' ?>">
                    <?php Messages::renderErrors($errors, 'birthdate'); ?>
                </div>
                <div class="col">
                    <label for="sex" class="form-label">Пол сотрудника</label>
                    <select name="sex" id="sex" class="form-select" value="<?= $_POST['sex'] ?? '' ?>">
                        <option value="1" selected>Женский</option>
                        <option value="0">Мужской</option>
                    </select>
                </div>
            </div>
            <div class="mb-3">
                <label for="division_id" class="form-label">Отделение</label>
                <?php
                $divisions = Query::table('divisions')->all();
                if (count($divisions) !== 0) :
                ?>
                    <select name="division_id" id="division_id" class="form-select">
                        <?php foreach ($divisions as $division) : ?>
                            <option value="<?= $division['id'] ?>"><?= $division['name'] ?></option>
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
            <input type="submit" value="Добавить" class="btn btn-primary">
        </form>
    </div>
    <?php require_once(Loader::load('views') . 'patterns/footer.php'); ?>

</body>