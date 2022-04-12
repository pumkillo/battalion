<?php
require_once(__DIR__ . '/App/Loader.php');
require_once(Loader::load('middlewares'));
require_once(Middlewares::getClass('auth'));
AuthMiddleware::check();

require_once(Loader::load('constants'));
require_once(Loader::load('router'));
require_once(Loader::load('query'));
require_once(Loader::load('session'));
require_once(Loader::load('validators'));
require_once(Loader::load('messages'));
?>
<!DOCTYPE html>
<html lang="ru">

<head>
    <title>Добавление отделения</title>
    <?php
    require_once(Loader::load('views') . 'patterns/head.php');
    ?>
</head>

<body>
    <div class="container">
        <?php
        require_once(Loader::load('views') . 'patterns/header.php');

        $errors = [];

        if (!empty($_POST)) {
            $validator = new Validators($_POST, [
                'name' => ['unique:divisions,name', 'required', 'min_max:,2,20', 'russian'],
            ]);

            if (!isset($_POST['platoon_id'])) {
                $message = 'Вы не можете добавить отделение';
            } else {
                if ($validator->fails()) {
                    $errors = $validator->errors();
                } else {
                    if (Query::table('divisions')->insert([
                        'name' => $_POST['name'],
                        'platoon_id' => $_POST['platoon_id'],
                    ])) {
                        Router::redirect('main');
                    }
                    $message = 'Ошибка добавления отделения';
                }
            }
        }

        ?>
        <form method="post" class="container">
            <div class="mb-3">
                <label for="platoon_id" class="form-label">Взвод</label>
                <?php
                $platoons = Query::table('platoons')->all();
                if (count($platoons) !== 0) :
                ?>
                    <select name="platoon_id" id="platoon_id" class="form-select">
                        <?php foreach ($platoons as $platoon) : ?>
                            <option value="<?= $platoon['id'] ?>"><?= $platoon['name'] ?></option>
                        <?php endforeach; ?>
                    <?php else :
                    Messages::renderError('Нет ни одного взвода в базе данных');
                endif; ?>
                    </select>
            </div>
            <div class="mb-3">
                <label for="name" class="form-label">Название отделения</label>
                <input id="name" type="text" name="name" placeholder="Отделение №12" class="form-control" value="<?= $_POST['name'] ?? '' ?>">
                <?php Messages::renderErrors($errors, 'name'); ?>
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

</html>